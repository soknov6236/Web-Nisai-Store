<?php
session_start();
include("../../connection.php");

// Redirect to login if user is not logged in
if ($_SESSION['USERID'] == "") {
    header("location:../../login.php");
    exit();
}


$filter = $_GET['filter']; // Get the filter from the AJAX request

// Calculate revenue based on the selected filter
switch ($filter) {
  case 'today':
    $sql = "SELECT SUM(total_amount) AS revenue FROM sales WHERE DATE(sale_date) = CURDATE()";
    break;
  case 'month':
    $sql = "SELECT SUM(total_amount) AS revenue FROM sales WHERE MONTH(sale_date) = MONTH(CURDATE()) AND YEAR(sale_date) = YEAR(CURDATE())";
    break;
  case 'year':
    $sql = "SELECT SUM(total_amount) AS revenue FROM sales WHERE YEAR(sale_date) = YEAR(CURDATE())";
    break;
  default:
    $sql = "SELECT SUM(total_amount) AS revenue FROM sales"; // Default to total revenue
}

$result = $conn->query($sql);
$row = $result->fetch_assoc();
$revenue = $row['revenue'] ?? 0; // Default to 0 if no revenue is found

echo number_format($revenue, 2); // Return the revenue value formatted to 2 decimal places
?>