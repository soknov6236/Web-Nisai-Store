<?php include('include/header.php') ?>
<?php include('include/sidebar.php'); ?>

<main id="main" class="main">
  <!-- Alert Container -->
  <div id="alertContainer" class="position-fixed top-0 start-0 end-0 p-3" style="z-index: 1050;">
    <div id="alertMessage" class="alert alert-primary alert-dismissible fade show d-none" role="alert">
      <span id="alertText"></span>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  </div>

  <section>
    <div class="pagetitle">
      <h1>Product Category Page</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.php">Home</a></li>
          <li class="breadcrumb-item active">Product Category</li>
        </ol>
      </nav>
    </div>
  </section>

  <section>
    <div class="container">
      <div align="right" style="margin: 10px;">
        <a href="#" class="btn btn-outline-primary" id="categoryAdd"><i class="ri-folder-add-line"></i> </a>
      </div>

      <table class="table table-bordered" id="tblCategory">
        <thead>
          <tr class="table-primary" align="center">
            <td>Category ID</td>
            <td>Category Name</td>
            <td>Total Stock</td>
            <td>Product Pictures</td>
            <td width="210px">Action</td>
          </tr>
        </thead>
        <tbody>
          <?php 
          // Fetch categories with total stock
          $sql = "SELECT c.catid, c.cat_title, c.picture, IFNULL(SUM(p.stock), 0) AS total_stock 
                  FROM category c 
                  LEFT JOIN products p ON c.catid = p.catid 
                  GROUP BY c.catid";
          $result = $conn->query($sql);
          if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
              echo "<tr>
                      <td>{$row["catid"]}</td>
                      <td>{$row["cat_title"]}</td>
                      <td>{$row["total_stock"]}</td>
                      <td><img src='category/uploads/{$row["picture"]}' width='150'></td>
                      <td>
                        <a href='#' class='edit btn btn-outline-info'><i class='bi bi-pencil-square'></i></a> | 
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

  <!-- Add Category Modal -->
  <div class="modal fade" id="addCategoryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Add new category</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <form>
            <div class="mb-3">
              <label>Category name</label>
              <input type="text" class="form-control" id="txtTitle">
            </div>
            <div class="mb-3">
              <label>Product pictures</label>
              <input type="file" class="form-control" id="txtPicture">
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

  <!-- Update Category Modal -->
  <div class="modal fade" id="updateCategoryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Product Editing</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <form>
            <input type="hidden" id="txtCatIdU">
            <div class="mb-3">
              <label>Production Category</label>
              <input type="text" class="form-control" id="txtTitleU">
            </div>
            <div class="mb-3">
              <label>Product pictures</label>
              <input type="file" class="form-control" id="txtPictureU">
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal"><i class="ri-close-fill"></i></button>
          <button type="button" class="btn btn-outline-primary" id="btnSaveChange"> <i class="ri-save-3-line"></i></button>
        </div>
      </div>
    </div>
  </div>
</main><!-- End #main -->

<script>
$(document).ready(function(){
  // Show Add Category Modal
  $("#categoryAdd").click(function(){
    $("#addCategoryModal").modal('show');
  });

  // Insert Category
  $("#btnSave").click(function(){
    var title = $("#txtTitle").val();
    var picture = $("#txtPicture")[0].files[0]; // Get the file

    if (!title || !picture) {
      showAlert("All fields are required!", "danger");
      return;
    }

    var formData = new FormData();
    formData.append("title", title);
    formData.append("picture", picture);

    $.ajax({
      url: "category/category_add.php",
      type: "POST",
      data: formData,
      processData: false,
      contentType: false,
      success: function(data){
        if(data == "1"){
          showAlert("Category added successfully.", "success");
          setTimeout(function(){
            location.reload();
          }, 1000);
        } else {
          showAlert("Error: " + data, "danger");
        }
      }
    });
  });

  // Show Update Modal
  $("#tblCategory").on('click', '.edit', function(){
    var row = $(this).closest("tr");
    var id = row.find("td").eq(0).text();
    var title = row.find("td").eq(1).text();

    $("#txtCatIdU").val(id);
    $("#txtTitleU").val(title);
    $("#txtPictureU").val(""); // Clear the file input
    $("#updateCategoryModal").modal("show");
  });

  // Update Category
  $("#btnSaveChange").click(function(){
    var catid = $("#txtCatIdU").val();
    var title = $("#txtTitleU").val();
    var picture = $("#txtPictureU")[0].files[0]; // Get the file (if any)

    if (!title) {
      showAlert("Category name is required!", "danger");
      return;
    }

    var formData = new FormData();
    formData.append("catid", catid);
    formData.append("title", title);
    if (picture) {
      formData.append("picture", picture);
    }

    $.ajax({
      url: "category/category_update.php",
      type: "POST",
      data: formData,
      processData: false,
      contentType: false,
      success: function(data){
        if(data == "1"){
          showAlert("Category updated successfully.", "success");
          setTimeout(function(){
            location.reload();
          }, 1000);
        } else {
          showAlert("Error: " + data, "danger");
        }
      }
    });
  });

  // Delete Category
  $("#tblCategory").on("click", ".del", function(){
    var row = $(this).closest("tr");
    var id = row.find("td").eq(0).text();

    if(confirm("Are you sure you want to delete this category?")){
      $.post("category/category_delete.php", {catid: id}, function(data){
        if(data == "1"){
          showAlert("Category deleted successfully.", "success");
          setTimeout(function(){
            location.reload();
          }, 1000);
        } else {
          showAlert("Error deleting category.", "danger");
        }
      });
    }
  });

  // Function to show alert
  function showAlert(message, type) {
    $("#alertText").text(message);
    $("#alertMessage").removeClass("alert-primary alert-success alert-danger").addClass("alert-" + type);
    $("#alertMessage").removeClass("d-none").addClass("d-block");

    setTimeout(function () {
      $("#alertMessage").addClass("d-none").removeClass("d-block");
    }, 5000);
  }
});
</script>

<!-- ======= Footer ======= -->
<?php include('include/footer.php') ?>