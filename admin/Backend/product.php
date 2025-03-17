<?php include('include/header.php') ?>
<?php include('include/sidebar.php'); ?>

<main id="main" class="main">

<script>
$(document).ready(function(){
    // Show Add Product Modal
    $("#productAdd").click(function(){
        $("#addProductModal").modal('show');
    });

    // Insert Product
      $("#btnSave").click(function () {
      var formData = new FormData();
      formData.append("name", $("#txtName").val());
      formData.append("category", $("#txtCategory").val());
      formData.append("supplier", $("#txtSupplier").val());
      formData.append("price", $("#txtPrice").val());
      formData.append("stock", $("#txtStock").val());
      formData.append("size", $("#txtSize").val());
      formData.append("color", $("#txtColor").val());
      //formData.append("gender", $("#txtGender").val());
      formData.append("status", $("#txtStatus").val());
      formData.append("product_code", $("#txtProductCode").val()); // Add this line
      formData.append("picture", $("#txtPicture")[0].files[0]);

      $.ajax({
          url: "product/product_add.php",
          type: "POST",
          data: formData,
          processData: false,
          contentType: false,
          success: function (data) {
              if (data == "1") {
                  alert("Product added successfully.");
                  location.reload();
              } else {
                  alert("Error: " + data);
              }
          },
        });
      });

  // Show Update Product Modal
  $("#tblProduct").on("click", ".update", function () {
    var row = $(this).closest("tr");
    var id = row.find("td").eq(0).text();

    $.post("product/product_get.php", { id: id }, function (data) {
        var product = JSON.parse(data);

        // Populate the update modal fields
        $("#txtUpdateProductCode").val(product.product_code); 
        $("#txtUpdateName").val(product.name);
        $("#txtUpdateCategory").val(product.catid);
        $("#txtUpdateSupplier").val(product.supplier_id);
        $("#txtUpdatePrice").val(product.price);
        $("#txtUpdateStock").val(product.stock);
        $("#txtUpdateSize").val(product.size);
        $("#txtUpdateColor").val(product.color);
        $("#txtUpdateGender").val(product.gender);
        $("#productId").val(id);

        // Populate the current picture
        var picturePath = "product/uploads/" + product.image; // Adjust the path as needed
        $("#currentPicture").attr("src", picturePath);

        $("#updateProductModal").modal('show');
    });
});

// Search Product
$("#searchProduct").on("input", function () {
        var searchQuery = $(this).val().toLowerCase(); // Get the search query

        // Loop through all table rows
        $("#tblProduct tbody tr").each(function () {
            var rowText = $(this).text().toLowerCase(); // Get the text content of the row

            // Show or hide the row based on the search query
            if (rowText.indexOf(searchQuery) !== -1) {
                $(this).show(); // Show the row if it matches the search query
            } else {
                $(this).hide(); // Hide the row if it doesn't match
            }
        });
    });

$("#btnUpdateSave").click(function () {
    var id = $("#productId").val();
    var name = $("#txtUpdateName").val();
    var category = $("#txtUpdateCategory").val();
    var supplier = $("#txtUpdateSupplier").val();
    var price = $("#txtUpdatePrice").val();
    var stock = $("#txtUpdateStock").val();
    var size = $("#txtUpdateSize").val();
    var color = $("#txtUpdateColor").val();
    var status = $("#txtUpdateStatus").val();
    var product_code = $("#txtUpdateProductCode").val();
    var picture = $("#txtUpdatePicture")[0].files[0];

    var formData = new FormData();
    formData.append("id", id);
    formData.append("name", name);
    formData.append("category", category);
    formData.append("supplier", supplier);
    formData.append("price", price);
    formData.append("stock", stock);
    formData.append("size", size);
    formData.append("color", color);
    formData.append("status", status);
    formData.append("product_code", product_code);
    formData.append("picture", picture);

    $.ajax({
        url: "product/product_update.php",
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: function (data) {
            if (data == "1") {
                location.reload();
            } else {
                alert("Product update error.");
            }
        },
    });
});
    // Delete Product
    $("#tblProduct").on("click", ".del", function(){
        var row = $(this).closest("tr");
        var id = row.find("td").eq(0).text();

        $("#deleteProductModal").modal('show');
        $("#productToDelete").val(id);
    });

    // Confirm Delete
    $("#btnDeleteConfirm").click(function(){
        var id = $("#productToDelete").val();

        $.post("product/product_delete.php", {productid: id}, function(data){
            if(data == "1"){
                //alert("Product deleted successfully.");
                location.reload();
            } else {
                alert("Error deleting product.");
            }
        });
    });
});
</script>

<section class="section">
    <div class="pagetitle">
        <h1>Product page</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item active">Product page</li>
                
            </ol>
        </nav>
    </div>


    <div class="container mt-4">

        <div align="right" style="margin: 10px;">
            <a href="#" class="btn btn-outline-primary" id="productAdd"> <i class="ri-add-line"> <i class="bi bi-box-seam"></i></i></a>
        </div>
        <div class="row mb-3">
        <div class="col-md-6">
            <h5>Search Product<h5>
            <input type="text" class="form-control" id="searchProduct" placeholder="Search Product name, code, or category">
            </div>
        </div>
        <table class="table table-bordered" id="tblProduct">
        <thead>
                <tr class="table-primary" align="center">
                    <td>ID</td>
                    <td>Product code</td> <!-- Add this column -->
                    <td>Product name</td>
                    <td>Product Category</td>
                    <td>Product Supplier</td>
                    <td>Price</td>
                    <td>stock</td>
                    <td>Size</td>
                    <td>Color</td>
                    <td>Creation Date</td>
                    <td>Pictures</td>
                    <td>Active</td>
                </tr>
            </thead>
            <tbody>
                <?php 
                $sql = "SELECT p.*, c.cat_title AS category_name, s.name AS supplier_name FROM products p
                        JOIN category c ON p.catid = c.catid
                        JOIN suppliers s ON p.supplier_id = s.id";             
                $result = $conn->query($sql);
                if($result->num_rows > 0){
                    while($row = $result->fetch_assoc()){
                        echo "<tr>
                                <td>{$row["id"]}</td>
                                <td>{$row["product_code"]}</td> <!-- Add this line -->
                                <td>{$row["name"]}</td>
                                <td>{$row["category_name"]}</td>
                                <td>{$row["supplier_name"]}</td>
                                <td>\${$row["price"]}</td>
                                <td>{$row["stock"]}</td>
                                <td>{$row["size"]}</td>
                                <td>{$row["color"]}</td>
                                <td>{$row["created_at"]}</td>
                                <td><img src='product/uploads/{$row["image"]}' width='110'></td>
                                <td>
                                    <a href='#' class='update btn btn-outline-warning'><i class='bi bi-pencil-square'></i>       </a>
                                    <a href='#' class='del btn btn-outline-danger'><i class='bi bi-trash'></i></a>
                                </td>
                              </tr>";
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
    
</section>

<!-- Add Product Modal -->
<div class="modal fade" id="addProductModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add new product</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form>
          <div class="row">
            <div class="col-md-6 mb-3">
              <label>Product code</label>
              <input type="text" class="form-control" id="txtProductCode">
            </div>
            <div class="col-md-6 mb-3">
              <label>Product name</label>
              <input type="text" class="form-control" id="txtName">
            </div>

            <div class="col-md-6 mb-3">
              <label>Product Category</label>
              <select class="form-control" id="txtCategory">
                <option value="">Select product category</option>
                <?php
                $sql = "SELECT * FROM category";
                $result = $conn->query($sql);
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='{$row['catid']}'>{$row['cat_title']}</option>";
                }
                ?>
              </select>
            </div>

            <div class="col-md-6 mb-3">
              <label>Product Supplier</label>
              <select class="form-control" id="txtSupplier">
                <option value="">Select a product supplier</option>
                <?php
                $sql = "SELECT * FROM suppliers";
                $result = $conn->query($sql);
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='{$row['id']}'>{$row['name']}</option>";
                }
                ?>
              </select>
            </div>

            <div class="col-md-6 mb-3">
              <label>Price</label>
              <input type="number" class="form-control" id="txtPrice">
            </div>
            <div class="col-md-6 mb-3">
              <label>Stock</label>
              <input type="number" class="form-control" id="txtStock">
            </div>

            <div class="col-md-6 mb-3">
              <label>Size</label>
              <select class="form-control" id="txtSize">
                <option value="S">Section size</option>
                <option value="S">S</option>
                <option value="M">M</option>
                <option value="L">L</option>
                <option value="XL">XL</option>
                <option value="XXL">XXL</option>
              </select>
            </div>
            <div class="col-md-6 mb-3">
              <label>Color</label>
              <input type="text" class="form-control" id="txtColor">
            </div>

            <div class="col-md-12 mb-3">
              <label>Product pictures</label>
              <input type="file" class="form-control" id="txtPicture">
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal"><i class="ri-delete-back-2-line"></i></button>
        <button type="button" class="btn btn-outline-primary" id="btnSave"><i class="ri-save-3-line"></i></button>
      </div>
    </div>
  </div>
</div>


<!-- Update Product Modal -->
<div class="modal fade" id="updateProductModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Update Product</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form>
          <input type="hidden" id="productId">

          <div class="row">
            <div class="col-md-6 mb-3">
              <label>Product code</label>
              <input type="text" class="form-control" id="txtUpdateProductCode">
            </div>
            <div class="col-md-6 mb-3">
              <label>Product name</label>
              <input type="text" class="form-control" id="txtUpdateName">
            </div>

            <div class="col-md-6 mb-3">
              <label>Product Category</label>
              <select class="form-control" id="txtUpdateCategory">
                <option value="">Select product category</option>
                <?php
                $sql = "SELECT * FROM category";
                $result = $conn->query($sql);
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='{$row['catid']}'>{$row['cat_title']}</option>";
                }
                ?>
              </select>
            </div>

            <div class="col-md-6 mb-3">
              <label>Product Supplier</label>
              <select class="form-control" id="txtUpdateSupplier">
                <option value="">Select a product supplier</option>
                <?php
                $sql = "SELECT * FROM suppliers";
                $result = $conn->query($sql);
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='{$row['id']}'>{$row['name']}</option>";
                }
                ?>
              </select>
            </div>

            <div class="col-md-6 mb-3">
              <label>Price</label>
              <input type="number" class="form-control" id="txtUpdatePrice">
            </div>
            <div class="col-md-6 mb-3">
              <label>Stock</label>
              <input type="number" class="form-control" id="txtUpdateStock">
            </div>

            <div class="col-md-6 mb-3">
              <label>Size</label>
              <select class="form-control" id="txtUpdateSize">
                <option value="">Section size</option>
                <option value="S">S</option>
                <option value="M">M</option>
                <option value="L">L</option>
                <option value="XL">XL</option>
                <option value="XXL">XXL</option>
              </select>
            </div>
            <div class="col-md-6 mb-3">
              <label>Color</label>
              <input type="text" class="form-control" id="txtUpdateColor">
            </div>

            <div class="col-md-12 mb-3">
              <label>Current image</label><br>
              <img id="currentPicture" src="" alt="Current Picture" width="100" class="img-thumbnail">
            </div>

            <div class="col-md-12 mb-3">
              <label>New Product Pictures</label>
              <input type="file" class="form-control" id="txtUpdatePicture">
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal"><i class="ri-delete-back-2-line"></i></button>
        <button type="button" class="btn btn-outline-primary" id="btnUpdateSave"><i class="ri-save-3-line"></i></button>
      </div>
    </div>
  </div>
</div>


<!-- Delete Product Modal -->
<div class="modal fade" id="deleteProductModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Delete product</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" id="productToDelete">
        <p>Are you sure you want to delete this product??</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-danger" id="btnDeleteConfirm">Delete</button>
      </div>
    </div>
  </div>
</div>

</main><!-- End #main -->

<!-- ======= Footer ======= -->
<?php include('include/footer.php') ?>