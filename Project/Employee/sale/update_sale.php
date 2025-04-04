<?php
session_start();
include("../../connection.php");

// Redirect to login if user is not logged in
if ($_SESSION['USERID'] == "") {
    header("location:../../login.php");
    exit();
}

// Check if the sale ID is provided in the URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "Invalid sale ID.";
    exit;
}

$saleId = $_GET['id'];

// Fetch the sale details from the database
$sql = "SELECT * FROM sales WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $saleId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "Sale record not found.";
    exit;
}

$sale = $result->fetch_assoc();
$stmt->close();
?>

<script>
$(document).ready(function () {
    // Search Product Code
    $("#searchProductCode").on("input", function () {
        var productCode = $(this).val();

        if (productCode.length >= 2) {
            $.ajax({
                url: "sale/search_product.php",
                type: "GET",
                data: { product_code: productCode },
                success: function (data) {
                    var products = JSON.parse(data);
                    var html = "";

                    if (products.length > 0) {
                        products.forEach(function (product) {
                            html += `
                                <div class="search-result mb-2" data-code="${product.product_code}" data-name="${product.name}" data-price="${product.price}" data-color="${product.color}" data-stock="${product.stock}">
                                    <img src="product/uploads/${product.image}" width="150" height="150" class="me-2">
                                    <span>${product.product_code} - ${product.name} (Stock: ${product.stock})</span>
                                </div>
                            `;
                        });
                    } else {
                        html = "<div>No products found.</div>";
                    }

                    $("#searchResults").html(html);
                }
            });
        } else {
            $("#searchResults").html("");
        }
    });

    // Populate Product Details when a picture is clicked
    $(document).on("click", ".search-result", function () {
        var productCode = $(this).data("code");
        var productName = $(this).data("name");
        var productPrice = $(this).data("price");
        var productColor = $(this).data("color");
        var productStock = $(this).data("stock");

        $("#productCode").val(productCode);
        $("#productName").val(productName);
        $("#productPrice").val(productPrice);
        $("#color").val(productColor);
        $("#stock").val(productStock); // Add a hidden input for stock

        $("#searchResults").html("");
        $("#searchProductCode").val("");
    });

    // Validate quantity against stock
    $("#updateSaleForm").on("submit", function (e) {
        var quantity = parseFloat($("input[name='quantity']").val());
        var stock = parseFloat($("#stock").val());

        if (quantity > stock) {
            alert("Insufficient stock for this product.");
            e.preventDefault();
        }
    });

    // Auto-calculate Total Amount
    $("input[name='quantity']").on("input", function () {
        var price = parseFloat($("#productPrice").val());
        var quantity = parseFloat($(this).val());
        var discount = parseFloat($("input[name='discount']").val());

        if (!isNaN(price) && !isNaN(quantity)) {
            var discountAmount = (price * quantity * discount) / 100;
            var totalAmount = (price * quantity) - discountAmount;
            $("input[name='total_amount']").val(totalAmount.toFixed(2));
        }
    });

    // Recalculate when discount changes
    $("input[name='discount']").on("input", function () {
        $("input[name='quantity']").trigger("input");
    });

    // Submit the form via AJAX
    $("#updateSaleForm").on("submit", function (e) {
        e.preventDefault();

        $.ajax({
            url: "sale/sale_update.php",
            type: "POST",
            data: new FormData(this),
            processData: false,
            contentType: false,
            success: function (response) {
                var result = JSON.parse(response);

                if (result.status === 'success') {
                    alert(result.message);
                    window.location.href = "sale.php"; // Redirect to sale list
                } else {
                    alert(result.message); // Show error message
                }
            }
        });
    });
});
</script>

<section>
    <div class="pagetitle">
        <h1>Update Sale</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item"><a href="sale.php">Sale</a></li>
                <li class="breadcrumb-item active">Update Sale</li>
            </ol>
        </nav>
    </div>
</section>

<section>
    <div class="container">
        <form id="updateSaleForm" action="sale/sale_update.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="sale_id" value="<?php echo $saleId; ?>">
            <div class="row">
                <div class="col-md-12 mb-3">
                    <label>Search Product Code</label>
                    <input type="text" class="form-control" id="searchProductCode" placeholder="Enter Product Code">
                    <div id="searchResults" class="mt-2"></div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label>Product Code</label>
                    <input type="text" class="form-control" name="product_code" id="productCode" value="<?php echo $sale['product_code']; ?>" readonly required>
                </div>
                <div class="col-md-4 mb-3">
                    <label>Product Name</label>
                    <input type="text" class="form-control" name="product_name" id="productName" value="<?php echo $sale['product_name']; ?>" readonly required>
                </div>
                <div class="col-md-4 mb-3">
                    <label>Price</label>
                    <input type="number" class="form-control" name="price" id="productPrice" value="<?php echo $sale['price']; ?>" readonly required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label>Quantity</label>
                    <input type="number" class="form-control" name="quantity" value="<?php echo $sale['quantity']; ?>" placeholder="Please input Quantity" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label>Color</label>
                    <input type="text" class="form-control" name="color" id="color" value="<?php echo $sale['color']; ?>" readonly required>
                </div>
                <div class="col-md-4 mb-3">
                    <label>Sale Date</label>
                    <input type="datetime-local" class="form-control" name="sale_date" value="<?php echo date('Y-m-d\TH:i', strtotime($sale['sale_date'])); ?>" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label>Cashier Name</label>
                    <input type="text" class="form-control" name="cashier_name" value="<?php echo $sale['cashier_name']; ?>" readonly required>
                </div>
                <div class="col-md-4 mb-3">
                    <label>Discount %</label>
                    <input type="number" class="form-control" name="discount" value="<?php echo $sale['discount']; ?>" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label>Total Amount</label>
                    <input type="number" class="form-control" name="total_amount" value="<?php echo $sale['total_amount']; ?>" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label>Status</label>
                    <select class="form-control" name="status" required>
                        <option value="Completed" <?php echo ($sale['status'] === 'Completed') ? 'selected' : ''; ?>>Completed</option>
                        <option value="Pending" <?php echo ($sale['status'] === 'Pending') ? 'selected' : ''; ?>>Pending</option>
                        <option value="Cancelled" <?php echo ($sale['status'] === 'Cancelled') ? 'selected' : ''; ?>>Cancelled</option>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 mb-3">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="sale.php" class="btn btn-secondary">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</section>

<?php
include('footer.php');
?>