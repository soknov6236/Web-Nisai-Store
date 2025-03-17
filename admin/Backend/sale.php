<?php include('include/header.php') ?>
<?php include('include/sidebar.php'); ?>

<main id="main" class="main">

<script>
$(document).ready(function() {
    // Redirect to sale_product.php when Add Sale button is clicked
    $("#saleAdd").click(function() {
        window.location.href = "sale_product.php";
    });
    
    $(document).ready(function () {
    // Open Update Sale Modal
    $(document).on("click", ".updateSale", function () {
        var saleId = $(this).data("id");

        $.ajax({
            url: "sale/sale_get.php", // PHP script to fetch sale details
            type: "GET",
            data: { id: saleId },
            success: function (data) {
                var sale = JSON.parse(data);

                // Populate the update modal fields
                $("#updateSaleId").val(sale.sale_id);
                $("#updateProductCode").val(sale.product_code);
                $("#updateProductName").val(sale.product_name);
                $("#updatePrice").val(sale.price);
                $("#updateQuantity").val(sale.quantity);
                $("#updateColor").val(sale.color);
                $("#updateSaleDate").val(sale.sale_date.replace(" ", "T")); // Convert to datetime-local format
                $("#updateDiscount").val(sale.discount);
                $("#updateTotalAmount").val(sale.total_amount);
                $("#updateStatus").val(sale.status);

                $("#updateSaleModal").modal("show"); // Show the update modal
            }
        });
    });

    // Update Sale
    $("#btnUpdateSale").click(function () {
        var formData = $("#updateSaleForm").serialize(); // Serialize form data

        $.ajax({
            url: "sale/sale_update.php", // PHP script to handle the update
            type: "POST",
            data: formData,
            success: function (data) {
                if (data == "1") {
                    alert("Sale updated successfully.");
                    location.reload(); // Reload the page to reflect changes
                } else {
                    alert("Error updating sale.");
                }
            }
        });
    });
});

    // Delete Sale
    $(document).on("click", ".deleteSale", function () {
        var saleId = $(this).data("id");

        if (confirm("Are you sure you want to delete this sale?")) {
            $.ajax({
                url: "sale/sale_delete.php", // PHP script to handle the delete
                type: "POST",
                data: { id: saleId },
                success: function (data) {
                    if (data == "1") {
                        alert("Sale deleted successfully.");
                        location.reload(); // Reload the page to reflect changes
                    } else {
                        alert("Error deleting sale.");
                    }
                }
            });
        }
    });
});

</script>

<section>
    <div class="pagetitle">
        <h1>Sale Page</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item active">Sale Page</li>
            </ol>
        </nav>
    </div>
</section>

<section>
    <div class="container">
    <div align="right" style="margin: 10px;">
       <a href="#" class="btn btn-outline-primary" id="saleAdd"><i class="bi bi-cart-plus"></i></a>
    </div>

    <table class="table table-bordered" id="tblSales">
    <thead>
        <tr class="table-primary" align="center">
            <th>ID</th>
            <th>Product Code</th>
            <th>Product Name</th>
            <th>Quantity</th>
            <th>Color</th>
            <th>Sale Date</th>
            <th>Discount</th>
            <th>Price</th>
            <th>Total Amount</th>
            <th>Cashier Name</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
            <tbody>
            <?php
            $sql = "SELECT * FROM sales";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['sale_id']}</td>
                            <td>{$row['product_code']}</td>
                            <td>{$row['product_name']}</td>
                            <td>{$row['quantity']}</td>
                            <td>{$row['color']}</td>
                            <td>{$row['sale_date']}</td>
                            <td>{$row['discount']} %</td>
                            <td>\${$row['price']}</td>
                            <td>\${$row['total_amount']}</td>
                            <td>{$row['cashier_name']}</td>
                            <td>{$row['status']}</td>
                            <td>
                            <a href='#' class='updateSale btn btn-outline-warning' data-id='{$row['sale_id']}'><i class='bi bi-pencil-square'></i></a>
                            <a href='#' class='deleteSale btn btn-outline-danger' data-id='{$row['sale_id']}'><i class='bi bi-trash'></i></a>
                            </td>
                            </tr>";
                            
                }
            }
            ?>
        </tbody>
      </table>
    </div>
</section>

<!-- Update Sale Modal -->
<div class="modal fade" id="updateSaleModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Sale</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="updateSaleForm">
                    <input type="hidden" id="updateSaleId" name="id">
                    <div class="mb-3">
                        <label>Product Code</label>
                        <input type="text" class="form-control" id="updateProductCode" name="product_code" readonly>
                    </div>
                    <div class="mb-3">
                        <label>Product Name</label>
                        <input type="text" class="form-control" id="updateProductName" name="product_name" readonly>
                    </div>
                    <div class="mb-3">
                        <label>Price</label>
                        <input type="number" class="form-control" id="updatePrice" name="price" readonly>
                    </div>
                    <div class="mb-3">
                        <label>Quantity</label>
                        <input type="number" class="form-control" id="updateQuantity" name="quantity" required>
                    </div>
                    <div class="mb-3">
                        <label>Color</label>
                        <input type="text" class="form-control" id="updateColor" name="color" readonly>
                    </div>
                    <div class="mb-3">
                        <label>Sale Date</label>
                        <input type="datetime-local" class="form-control" id="updateSaleDate" name="sale_date" required>
                    </div>
                    <div class="mb-3">
                        <label>Discount</label>
                        <input type="number" class="form-control" id="updateDiscount" name="discount" required>
                    </div>
                    <div class="mb-3">
                        <label>Total Amount</label>
                        <input type="number" class="form-control" id="updateTotalAmount" name="total_amount" readonly>
                    </div>
                    <div class="mb-3">
                        <label>Status</label>
                        <select class="form-control" id="updateStatus" name="status" required>
                            <option value="Completed">Completed</option>
                            <option value="Pending">Pending</option>
                            <option value="Cancelled">Cancelled</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal"><i class="ri-delete-back-2-line"></i></button>
                <button type="button" class="btn btn-outline-primary" id="btnUpdateSale"><i class="ri-save-3-line"></i></button>
            </div>
        </div>
    </div>
</div>

</main><!-- End #main -->

<!-- ======= Footer ======= -->
<?php include('include/footer.php') ?>