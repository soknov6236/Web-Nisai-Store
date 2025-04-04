<?php
session_start();
include("../../connection.php");

// Redirect to login if user is not logged in
if ($_SESSION['USERID'] == "") {
    header("location:../login.php");
    exit();
}

$productCode = $_GET['product_code'];
$sql = "SELECT id, product_code, name, price, color, stock, image FROM products WHERE product_code LIKE '%$productCode%'";
$result = $conn->query($sql);

$products = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
}

echo json_encode($products);
?>