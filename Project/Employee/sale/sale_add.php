<?php
session_start();
include("../../connection.php");

// Redirect to login if user is not logged in
if ($_SESSION['USERID'] == "") {
    header("location:../../login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sales = $_POST['sales'];
    $sale_date = $_POST['sale_date'];
    $cashier_name = $_POST['cashier_name'];
    $status = $_POST['status'];
    $total_amount = 0; // Initialize total amount

    // Start a transaction
    $conn->begin_transaction();

    try {
        // Save each sale to the database and update stock
        foreach ($sales as $sale) {
            $product_code = $sale['product_code'];
            $product_name = $sale['product_name'];
            $price = $sale['price'];
            $quantity = $sale['quantity'];
            $color = $sale['color'];
            $discount = $sale['discount'];

            // Calculate the total amount for this sale item
            $item_total_amount = $price * $quantity * (1 - $discount / 100);

            // Add the item total to the overall total amount
            $total_amount += $item_total_amount;

            // Insert the sale into the sales table
            $sql = "INSERT INTO sales (product_code, product_name, price, quantity, color, discount, sale_date, cashier_name, total_amount, status)
                    VALUES ('$product_code', '$product_name', '$price', '$quantity', '$color', '$discount', '$sale_date', '$cashier_name', '$item_total_amount', '$status')";
            $conn->query($sql);

            // Update the stock in the products table
            $updateStockSql = "UPDATE products SET stock = stock - $quantity WHERE product_code = '$product_code'";
            $conn->query($updateStockSql);

            // Check if the stock update was successful
            if ($conn->affected_rows === 0) {
                throw new Exception("Failed to update stock for product: $product_code");
            }
        }

        // Commit the transaction
        $conn->commit();

        // Return success response with the total amount
        echo json_encode([
            'success' => true,
            'total_amount' => $total_amount,
        ]);
    } catch (Exception $e) {
        // Rollback the transaction on error
        $conn->rollback();

        // Return error response
        echo json_encode([
            'success' => false,
            'message' => $e->getMessage(),
        ]);
    }
} else {
    // Return error response for invalid request method
    echo json_encode([
        'success' => false,
        'message' => 'Invalid request method.',
    ]);
}
?>