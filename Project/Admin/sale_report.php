<?php
include('include/header.php');
include('include/sidebar.php');
// Initialize filter variables
$startDate = isset($_GET['startDate']) ? $_GET['startDate'] : '';
$endDate = isset($_GET['endDate']) ? $_GET['endDate'] : '';
$cashierName = isset($_GET['cashierName']) ? $_GET['cashierName'] : '';

// Build the base query
$query = "SELECT sale_id, product_code, product_name, color, quantity, discount, sale_date, cashier_name, total_amount, status 
          FROM sales 
          WHERE 1=1";

// Add filters to the query
if (!empty($startDate)) {
    $query .= " AND sale_date >= '$startDate'";
}
if (!empty($endDate)) {
    $query .= " AND sale_date <= '$endDate'";
}
if (!empty($cashierName)) {
    $query .= " AND cashier_name = '$cashierName'";
}

$query .= " ORDER BY sale_date DESC"; // Adjust the query based on your table structure
$result = mysqli_query($conn, $query);

?>
  <main id="main" class="main">
    <div class="pagetitle">
      <h1>Sale Report</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.php">Home</a></li>
          <li class="breadcrumb-item active">Sale Report</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Sale Report</h5>

<!-- Add this above the sale report table -->
<div class="row mb-3">
    <div class="col-md-4">
        <label for="startDate">Start Date</label>
        <input type="date" class="form-control" id="startDate" name="startDate" value="<?php echo $startDate; ?>">
    </div>
    <div class="col-md-4">
        <label for="endDate">End Date</label>
        <input type="date" class="form-control" id="endDate" name="endDate" value="<?php echo $endDate; ?>">
    </div>
    <div class="col-md-4">
        <label for="cashierName">Cashier Name</label>
        <select class="form-control" id="cashierName" name="cashierName">
            <option value="">All Cashiers</option>
            <?php
            // Fetch unique cashier names from the database
            $cashierQuery = "SELECT DISTINCT cashier_name FROM sales";
            $cashierResult = mysqli_query($conn, $cashierQuery);
            while ($cashierRow = mysqli_fetch_assoc($cashierResult)) {
                $selected = ($cashierName == $cashierRow['cashier_name']) ? 'selected' : '';
                echo "<option value='{$cashierRow['cashier_name']}' $selected>{$cashierRow['cashier_name']}</option>";
            }
            ?>
        </select>
    </div>
</div>
<div class="row mb-3">
    <div class="col-md-12">
        <button type="button" class="btn btn-outline-primary" id="applyFilter">Apply Filter</button>
        <button type="button" class="btn btn-outline-danger" id="resetFilter"><i class="bi bi-repeat"> Reset</i> </button>
        <button type="button" class="btn btn-outline-info" id="printReport"><i class="bi bi-printer"> Print</i></button>
    </div>
</div>
              <!-- Sale Report Table -->
              <table class="table datatable">
                <thead>
                  <tr>
                    <th>Sale ID</th>
                    <th>Sale Date</th>
                    <th>Cashier Name</th>
                    <th>Product Code</th>
                    <th>Product Name</th>
                    <th>Color</th>
                    <th>Quantity</th>
                    <th>Discount</th>
                    <th>Total Amount</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  if (mysqli_num_rows($result) > 0) {
                      while ($row = mysqli_fetch_assoc($result)) {
                          echo "<tr>
                                  <td>{$row['sale_id']}</td>
                                  <td>{$row['sale_date']}</td>
                                  <td>{$row['cashier_name']}</td>
                                  <td>{$row['product_code']}</td>
                                  <td>{$row['product_name']}</td>
                                  <td>{$row['color']}</td>
                                  <td>{$row['quantity']}</td>
                                  <td>{$row['discount']}%</td>
                                  <td>\${$row['total_amount']}</td>
                                </tr>";
                      }
                  } else {
                      echo "<tr><td colspan='11' class='text-center'>No sale records found.</td></tr>";
                  }
                  ?>
                </tbody>
              </table>
              <!-- End Sale Report Table -->
            </div>
          </div>
        </div>
      </div>
    </section>
<!-- Modal for Sale Report Details -->
<div class="modal fade" id="saleReportModal" tabindex="-1" aria-labelledby="saleReportModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="saleReportModalLabel">Sale Report Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered">
                    <tr>
                        <th>Sale ID</th>
                        <td id="modalSaleId"></td>
                    </tr>
                    <tr>
                        <th>Sale Date</th>
                        <td id="modalSaleDate"></td>
                    </tr>
                    <tr>
                        <th>Cashier Name</th>
                        <td id="modalCashierName"></td>
                    </tr>
                    <tr>
                        <th>Product Code</th>
                        <td id="modalProductCode"></td>
                    </tr>
                    <tr>
                        <th>Product Name</th>
                        <td id="modalProductName"></td>
                    </tr>
                    <tr>
                        <th>Color</th>
                        <td id="modalColor"></td>
                    </tr>
                    <tr>
                        <th>Quantity</th>
                        <td id="modalQuantity"></td>
                    </tr>
                    <tr>
                        <th>Discount</th>
                        <td id="modalDiscount"></td>
                    </tr>
                    <tr>
                        <th>Total Amount</th>
                        <td id="modalTotalAmount"></td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td id="modalStatus"></td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
    

<!-- Modal for Print Report Summary -->
<div class="modal fade" id="printReportModal" tabindex="-1" aria-labelledby="printReportModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="printReportModalLabel">Print Sale Report Summary</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Logo, Date Range, and Cashier Name -->
                <div class="text-center mb-4">
                    <img src="../assets/img/logo_report.png" alt="Nisai Store Logo" style="width: 200px; height: auto;">
                    <h4>Nisai Store</h4>
                    <p>
                        <strong>Start Date:</strong> <span id="printStartDate"></span> | 
                        <strong>End Date:</strong> <span id="printEndDate"></span>
                    </p>
                    <p><strong>Cashier Name:</strong> <span id="printCashierName"></span></p>
                </div>

                <!-- Sale Summary Table -->
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Product Code</th>
                            <th>Product Name</th>
                            <th>Color</th>
                            <th>Quantity Sold</th>
                            <th>Discount</th>
                            <th>Total Amount</th>
                        </tr>
                    </thead>
                    <tbody id="printReportBody">
                        <!-- Data will be populated here dynamically -->
                    </tbody>
                </table>

                <!-- Total Sales Footer -->
                <div class="mt-4 text-end">
                    <h5>Total Sales: <strong>$<span id="printTotalSales">0.00</span></strong></h5>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="printModalContent">Print</button>
            </div>
        </div>
    </div>
</div>

<script>
  $(document).ready(function () {
    // Function to apply filters automatically
    function applyFilters() {
        var startDate = $("#startDate").val();
        var endDate = $("#endDate").val();
        var cashierName = $("#cashierName").val();

        // Build the URL with filter parameters
        var url = `sale_report.php?startDate=${startDate}&endDate=${endDate}&cashierName=${cashierName}`;

        // Redirect to the updated URL with filters
        window.location.href = url;
    }

    // Auto-apply filters when any filter input changes
    $("#startDate, #endDate, #cashierName").on("change", function () {
        applyFilters();
    });

    // Reset Filters
    $("#resetFilter").on("click", function () {
        window.location.href = "sale_report.php"; // Reload the page without filters
    });

    // Handle "Print Report" button click
    $("#printReport").on("click", function () {
        // Get the filter values
        var startDate = $("#startDate").val();
        var endDate = $("#endDate").val();
        var cashierName = $("#cashierName").val();

        // Set the logo, date range, and cashier name in the modal
        $("#printStartDate").text(startDate || "N/A");
        $("#printEndDate").text(endDate || "N/A");
        $("#printCashierName").text(cashierName || "All Cashiers");

        // Fetch the filtered data from the table
        var rows = [];
        var totalSales = 0;

        $(".datatable tbody tr").each(function () {
            var row = {
                productCode: $(this).find("td:eq(3)").text(),
                productName: $(this).find("td:eq(4)").text(),
                color: $(this).find("td:eq(5)").text(),
                quantity: $(this).find("td:eq(6)").text(),
                discount: $(this).find("td:eq(7)").text(),
                totalAmount: parseFloat($(this).find("td:eq(8)").text().replace("$", "")),
            };
            rows.push(row);
            totalSales += row.totalAmount; // Calculate total sales
        });

        // Populate the modal with the filtered data
        var printBody = $("#printReportBody");
        printBody.empty(); // Clear previous data

        rows.forEach(function (row) {
            printBody.append(`
                <tr>
                    <td>${row.productCode}</td>
                    <td>${row.productName}</td>
                    <td>${row.color}</td>
                    <td>${row.quantity}</td>
                    <td>${row.discount}%</td>
                    <td>$${row.totalAmount.toFixed(2)}</td>
                </tr>
            `);
        });

        // Set the total sales in the footer
        $("#printTotalSales").text(totalSales.toFixed(2));

        // Show the modal
        $("#printReportModal").modal("show");
    });

    // Handle "Print" button inside the modal
    $("#printModalContent").on("click", function () {
        // Print the modal content
        var printContents = document.getElementById("printReportModal").innerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
        location.reload(); // Reload the page to restore the original content
    });
});
</script>
<?php include('include/footer.php') ?>