<?php include('include/header.php') ?>
<?php include('include/sidebar.php'); ?>

    <main id="main" class="main">
        <section>
            <div class="pagetitle">
                <h1>Add Sale</h1>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                        <li class="breadcrumb-item"><a href="sale.php">Sale</a></li>
                        <li class="breadcrumb-item active">Add Sale</li>
                    </ol>
                </nav>
            </div>
        </section>

        <section>
    <div class="container">
        <form id="addSaleForm" action="sale/sale_add.php" method="POST" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-12 mb-3">
                    <label>Search Product Code</label>
                    <input type="text" class="form-control" id="searchProductCode" placeholder="Enter Product Code">
                    <div id="searchResults" class="mt-2"></div>
                </div>
            </div>

            <!-- Table to display selected products -->
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-bordered" id="tblPurchases">
                        <thead>
                            <tr class="table-primary" align="center">
                                <th>Product Code</th>
                                <th>Product Name</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Color</th>
                                
                                <th>Discount (%)</th>
                                <th>Total Amount</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Rows will be dynamically added here -->
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="row">
              <div class="col-md-4 mb-3">
                  <label>Sale Date</label>
                  <input type="datetime-local" class="form-control" name="sale_date" value="<?php echo date('Y-m-d H:i:s'); ?>" readonly required>
              </div>
              <div class="col-md-4 mb-3">
                  <label>Cashier Name</label>
                  <input type="text" class="form-control" name="cashier_name" value="<?php echo $_SESSION['USERNAME']; ?>" readonly required>
              </div>
              <div class="col-md-4 mb-3">
                  <label>Status</label>
                  <select class="form-control" name="status" required>
                      <option value="Completed">Completed</option>
                      <option value="Pending">Pending</option>
                      <option value="Cancelled">Cancelled</option>
                  </select>
              </div>
          </div>

            <div class="row">
                <div class="col-md-12 mb-3">
                    <button type="submit" class="btn btn-outline-primary"><i class="bi bi-cart-plus"></i></button>
                    <a href="sale.php" class="btn btn-outline-danger"><i class="ri-delete-back-2-line"></i></a>
                </div>
            </div>
        </form>
    </div>

    <!-- Modal for Sale Details -->
<div class="modal fade" id="saleDetailsModal" tabindex="-1" aria-labelledby="saleDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="saleDetailsModalLabel">Sale Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <!-- Logo, Date Range, and Cashier Name -->
              <div class="text-center mb-4">
                    <img src="../assets/img/logo_report.png" alt="Nisai Store Logo" style="width: 200px; height: auto;">
                    <h4>Nisai Store</h4>
                    <p><strong>Cashier Name:</strong> <span style="text-transform: capitalize; font-size: 18px;"><?php echo $_SESSION['USERNAME']; ?></span></p>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Product Code</th>
                            <th>Product Name</th>
                            <th>Quantity</th>
                            <th>Color</th>
                            <th>Sale Date</th>
                            <th>Discount (%)</th>
                            <th>Price</th>
                            <th>Total Amount</th>
                            <th>Cashier Name</th>
                        </tr>
                    </thead>
                    <tbody id="saleDetailsBody">
                        <!-- Sale details will be dynamically added here -->
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-primary" id="confirmSale">OK</button>
            </div>
        </div>
    </div>
</div>
</section>
    </main><!-- End #main -->


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

        // Add product to the table
        var newRow = `
            <tr>
                <td>${productCode}</td>
                <td>${productName}</td>
                <td>${productPrice}</td>
                <td><input type="number" class="form-control quantity" value="1" min="1" max="${productStock}"></td>
                <td>${productColor}</td>
                <td><input type="number" class="form-control discount" value="0" min="0" max="100"></td>
                <td>${productPrice}</td>
                <td>
                    <button class="btn btn-outline-danger btn-remove"><i class="bi bi-trash"></i></button>
                </td>
            </tr>
        `;
        $("#tblPurchases tbody").append(newRow);

        // Clear search results
        $("#searchResults").html("");
        $("#searchProductCode").val("");
    });

    // Remove product from the table
    $(document).on("click", ".btn-remove", function () {
        $(this).closest("tr").remove();
    });

    // Calculate total amount when quantity or discount changes
    $(document).on("input", ".quantity, .discount", function () {
        var row = $(this).closest("tr");
        var price = parseFloat(row.find("td:eq(2)").text());
        var quantity = parseFloat(row.find(".quantity").val());
        var discount = parseFloat(row.find(".discount").val());
        var totalAmount = price * quantity * (1 - discount / 100);
        row.find("td:eq(6)").text(totalAmount.toFixed(2));
    });

    // Submit the form via AJAX
    $("#addSaleForm").on("submit", function (e) {
        e.preventDefault();

        var sales = [];
        $("#tblPurchases tbody tr").each(function () {
            var sale = {
                product_code: $(this).find("td:eq(0)").text(),
                product_name: $(this).find("td:eq(1)").text(),
                price: $(this).find("td:eq(2)").text(),
                quantity: $(this).find(".quantity").val(),
                color: $(this).find("td:eq(4)").text(),
                discount: $(this).find(".discount").val(),
                total_amount: $(this).find("td:eq(6)").text(),
            };
            sales.push(sale);
        });

        var saleData = {
            sales: sales,
            sale_date: $("input[name='sale_date']").val(),
            cashier_name: $("input[name='cashier_name']").val(),
            status: $("select[name='status']").val(),
        };

        $.ajax({
            url: "sale/sale_add.php",
            type: "POST",
            data: saleData,
            success: function (response) {
                var result = JSON.parse(response);
                if (result.success) {
                    // Populate the modal with sale details
                    var saleDetailsHtml = "";
                    var totalAmount = 0;

                    sales.forEach(function (sale) {
                        saleDetailsHtml += `
                            <tr>
                                <td>${sale.product_code}</td>
                                <td>${sale.product_name}</td>
                                <td>${sale.quantity}</td>
                                <td>${sale.color}</td>
                                <td>${saleData.sale_date}</td>
                                <td>${sale.discount}</td>
                                <td>${sale.price}</td>
                                <td>${sale.total_amount}</td>
                                <td>${saleData.cashier_name}</td>
                            </tr>
                        `;
                        totalAmount += parseFloat(sale.total_amount);
                    });

                    // Add total amount row
                    saleDetailsHtml += `
                        <tr class="table-primary">
                            <td colspan="7" align="right"><strong>Total Amount:</strong></td>
                            <td colspan="2"><strong>${totalAmount.toFixed(2)}</strong></td>
                        </tr>
                    `;

                    // Populate the modal body
                    $("#saleDetailsBody").html(saleDetailsHtml);

                    // Show the modal
                    $("#saleDetailsModal").modal("show");
                } else {
                    alert("Error: " + result.message);
                }
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
                alert("An error occurred while processing your request.");
            }
        });
    });

    // Redirect to sale.php when the "OK" button is clicked
    $("#confirmSale").on("click", function () {
        window.location.href = "sale.php";
    });
});
    </script>
<?php include('include/footer.php') ?>