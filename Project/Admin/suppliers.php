<?php include('include/header.php') ?>
<?php include('include/sidebar.php'); ?>

<main id="main" class="main">
<script>
$(document).ready(function(){
    // Show Add Supplier Modal
    $("#supplierAdd").click(function(){
        $("#addSupplierModal").modal('show');
    });

    // Insert Supplier
    $("#btnSave").click(function(){
        var name = $("#txtName").val();
        var phone = $("#txtPhone").val();
        var address = $("#txtAddress").val();

        $.post("suppliers/supplier_add.php", {name: name, phone: phone, address: address}, function(data){
            if(data == "1"){
                alert("Supplier added successfully.");
                location.reload();
            } else {
                alert("Error: " + data);
            }
        });
    });

    // Show Update Modal
    $("#tblSupplier").on('click', '.edit', function(){
        var row = $(this).closest("tr");
        var id = row.find("td").eq(0).text();
        var name = row.find("td").eq(1).text();
        var phone = row.find("td").eq(2).text();
        var address = row.find("td").eq(3).text();

        $("#txtSupplierIdU").val(id);
        $("#txtNameU").val(name);
        $("#txtPhoneU").val(phone);
        $("#txtAddressU").val(address);
        $("#updateSupplierModal").modal("show");
    });

    // Update Supplier
    $("#btnSaveChange").click(function(){
        var id = $("#txtSupplierIdU").val();
        var name = $("#txtNameU").val();
        var phone = $("#txtPhoneU").val();
        var address = $("#txtAddressU").val();

        $.post("suppliers/supplier_update.php", {id: id, name: name, phone: phone, address: address}, function(data){
            if(data == "1"){
                alert("Supplier updated successfully.");
                location.reload();
            } else {
                alert("Error: " + data);
            }
        });
    });

    // Delete Supplier
    $("#tblSupplier").on("click", ".del", function(){
        var row = $(this).closest("tr");
        var id = row.find("td").eq(0).text();

        if(confirm("Are you sure you want to delete this supplier?")){
            $.post("suppliers/supplier_delete.php", {id: id}, function(data){
                if(data == "1"){
                    alert("Supplier deleted successfully.");
                    location.reload();
                } else {
                    alert("Error deleting supplier.");
                }
            });
        }
    });
});
</script>

<section>
    <div class="pagetitle">
        <h1>Suppliers Page</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item active">Suppliers Page</li>
            </ol>
        </nav>
    </div>
</section>

<section>
    <div class="container">
        <div align="right" style="margin: 10px;">
            <a href="#" class="btn btn-outline-primary" id="supplierAdd"> <i class="bi bi-person-plus"></i></a>
        </div>

        <table class="table table-bordered" id="tblSupplier">
            <thead>
                <tr class="table-primary" align="center">
                    <td>ID</td>
                    <td>Name</td>
                    <td>Phone</td>
                    <td>Address</td>
                    <td>Created At</td>
                    <td width="210px">Action</td>
                </tr>
            </thead>
            <tbody>
                <?php 
                $sql = "SELECT * FROM suppliers";
                $result = $conn->query($sql);
                if($result->num_rows > 0){
                    while($row = $result->fetch_assoc()){
                        echo "<tr>
                                <td>{$row["id"]}</td>
                                <td>{$row["name"]}</td>
                                <td>{$row["phone"]}</td>
                                <td>{$row["address"]}</td>
                                <td>{$row["created_at"]}</td>
                                <td>
                                    <a href='#' class='edit btn btn-outline-primary'><i class='bi bi-pencil-square'></i></a> | 
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

<!-- Add Supplier Modal -->
<div class="modal fade" id="addSupplierModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add New Supplier</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form>
            <div class="mb-3">
                <label>Name</label>
                <input type="text" class="form-control" id="txtName">
            </div>
            <div class="mb-3">
                <label>Phone</label>
                <input type="text" class="form-control" id="txtPhone">
            </div>
            <div class="mb-3">
                <label>Address</label>
                <textarea class="form-control" id="txtAddress"></textarea>
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal"><i class="ri-delete-back-2-line"></i></button>
        <button type="button" class="btn btn-outline-primary" id="btnSave"><i class="ri-save-3-line"></i></button></button>
      </div>
    </div>
  </div>
</div>
<!-- Update Supplier Modal -->
<div class="modal fade" id="updateSupplierModal" tabindex="-1" aria-labelledby="updateSupplierLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="updateSupplierLabel">Update Supplier</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form>
            <input type="hidden" id="txtSupplierIdU">
            <div class="mb-3">
                <label>Name</label>
                <input type="text" class="form-control" id="txtNameU">
            </div>
            <div class="mb-3">
                <label>Phone</label>
                <input type="text" class="form-control" id="txtPhoneU">
            </div>
            <div class="mb-3">
                <label>Address</label>
                <input type="text" class="form-control" id="txtAddressU">
            </div>
        </form>
      </div>
      <div class="modal-footer">
      <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal"><i class="ri-delete-back-2-line"></i></button>
        <button type="button" class="btn btn-outline-primary" id="btnSaveChange"><i class="ri-save-3-line"></i></button></button>
      </div>
    </div>
  </div>
</div>

</main><!-- End #main -->

<!-- ======= Footer ======= -->
<?php include('include/footer.php') ?>