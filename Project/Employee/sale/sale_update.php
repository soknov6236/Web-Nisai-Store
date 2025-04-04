<?php
session_start();
include("../../connection.php");

// Redirect to login if user is not logged in
if ($_SESSION['USERID'] == "") {
    header("location:../../login.php");
    exit();
}
// Check if the user is logged in
if (trim($_SESSION['USERID']) == "") {
    header("location:../login.php");
    exit();
}

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $saleId = $_POST['id'];
    $quantity = $_POST['quantity'];
    $saleDate = $_POST['sale_date'];
    $discount = $_POST['discount'];
    $status = $_POST['status'];

    // Fetch the sale details to calculate the total amount
    $sql = "SELECT price FROM sales WHERE sale_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $saleId);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($row) {
        $price = $row['price'];

        // Calculate the total amount
        $totalAmount = $price * $quantity * (1 - $discount / 100);

        // Update the sale record in the database
        $sql = "UPDATE sales 
                SET quantity = ?, sale_date = ?, discount = ?, total_amount = ?, status = ?
                WHERE sale_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("isddsi", $quantity, $saleDate, $discount, $totalAmount, $status, $saleId);

        if ($stmt->execute()) {
            echo "1"; // Success
        } else {
            echo "Error updating sale: " . $stmt->error;
        }
    } else {
        echo "Sale not found.";
    }
} else {
    echo "Invalid request method.";
}
?>