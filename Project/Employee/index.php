<?php
include('include/header.php');
include('include/sidebar.php');

// Fetch total number of users
$sql = "SELECT COUNT(*) AS total_users FROM users";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$total_users = $row['total_users'];

// Fetch total revenue
$sql = "SELECT SUM(total_amount) AS total_revenue FROM sales";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$total_revenue = $row['total_revenue'];

// Fetch total number of sales
$sql = "SELECT COUNT(*) AS total_sales FROM sales";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$total_sales = $row['total_sales'];

// Fetch total stock of products
$sql = "SELECT SUM(stock) AS total_stock FROM products";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$total_stock = $row['total_stock'];
?>

<main id="main" class="main">
  <?php
  // Display login success message if set
  if (isset($_SESSION['login_success'])) {
      echo '
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        ' . $_SESSION['login_success'] . '
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
      ';
      unset($_SESSION['login_success']); // Clear the session variable
  }
  ?>

  <div class="pagetitle">
    <h1>Dashboard</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
        <li class="breadcrumb-item active">Dashboard</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <section class="section dashboard">
    <div class="row">
      <!-- Left side columns -->
      <div class="col-lg-12">
        <div class="row">
          <!-- Revenue Card -->
          <div class="col-xxl-4 col-md-6">
            <div class="card info-card revenue-card">
              <div class="filter">
                <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                  <li class="dropdown-header text-start">
                    <h6>Filter</h6>
                  </li>
                  <li><a class="dropdown-item filter-revenue" href="#" data-filter="today">Today</a></li>
                  <li><a class="dropdown-item filter-revenue" href="#" data-filter="week">This Week</a><li> 
                  <li><a class="dropdown-item filter-revenue" href="#" data-filter="month">This Month</a></li>
                  <li><a class="dropdown-item filter-revenue" href="#" data-filter="year">This Year</a></li>
                </ul>
              </div>
              <div class="card-body">
                <h5 class="card-title">Revenue <span>| Total</span></h5>
                <div class="d-flex align-items-center">
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-currency-dollar"></i>
                  </div>
                  <div class="ps-3">
                    <h6 id="revenue-value">$<?php echo number_format($total_revenue, 2); ?></h6> <!-- Default total revenue -->
                  </div>
                </div>
              </div>
            </div>
          </div><!-- End Revenue Card -->

          <!-- Sales Card -->
          <div class="col-xxl-4 col-md-6">
            <div class="card info-card sales-card">
              <div class="filter">
                <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                  <li class="dropdown-header text-start">
                    <h6>Filter</h6>
                  </li>
                </ul>
              </div>
              <div class="card-body">
                <h5 class="card-title">Sales <span>| Total</span></h5>
                <div class="d-flex align-items-center">
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-cart"></i>
                  </div>
                  <div class="ps-3">
                    <h6><?php echo $total_sales; ?></h6> <!-- Display total sales dynamically -->
                  </div>
                </div>
              </div>
            </div>
          </div><!-- End Sales Card -->

          <!-- Total Stock Product Card -->
          <div class="col-xxl-4 col-md-6">
            <div class="card info-card sales-card">
              <div class="filter">
                <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                  <li class="dropdown-header text-start">
                    <h6>Filter</h6>
                  </li>
                </ul>
              </div>
              <div class="card-body">
                <h5 class="card-title">Stock <span>| Total</span></h5>
                <div class="d-flex align-items-center">
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-box"></i>
                  </div>
                  <div class="ps-3">
                    <h6><?php echo $total_stock; ?></h6> <!-- Display total stock dynamically -->
                  </div>
                </div>
              </div>
            </div>
          </div><!-- End Total Stock Product Card -->

          <!-- Customers Card -->
          <div class="col-xxl-4 col-xl-6">
            <div class="card info-card customers-card">
              <div class="filter">
                <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                  <li class="dropdown-header text-start">
                    <h6>Filter</h6>
                  </li>
                  <li><a class="dropdown-item" href="#">Today</a></li>
                  <li><a class="dropdown-item" href="#">This Month</a></li>
                  <li><a class="dropdown-item" href="#">This Year</a></li>
                </ul>
              </div>
              <div class="card-body">
                <h5 class="card-title">Users <span>| Total</span></h5>
                <div class="d-flex align-items-center">
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-person"></i>
                  </div>
                  <div class="ps-3">
                    <h6><?php echo $total_users; ?></h6> <!-- Display total users dynamically -->
                  </div>
                </div>
              </div>
            </div>
          </div><!-- End Customers Card -->
        </div>
      </div><!-- End Left side columns -->
    </div>
  </section>
</main><!-- End #main -->

<script>
$(document).ready(function() {
  // Handle Revenue Card filter clicks
  $(".filter-revenue").click(function(e) {
    e.preventDefault(); // Prevent default link behavior
    var filter = $(this).data("filter"); // Get the selected filter (today, month, year)

    // Send AJAX request to get filtered revenue
    $.ajax({
      url: "dashboard/get_revenue.php", // Backend script to calculate revenue
      type: "GET",
      data: { filter: filter },
      success: function(response) {
        // Update the revenue value in the card
        $("#revenue-value").text("$" + response);
      },
      error: function(xhr, status, error) {
        console.error("Error fetching revenue data: " + error);
      }
    });
  });
});
</script>

<?php include('include/footer.php') ?>