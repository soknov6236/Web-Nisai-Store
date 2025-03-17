<?php
session_start();
include("../../connection.php");

// Redirect to login if user is not logged in
if ($_SESSION['USERID'] == "") {
    header("location:../../login.php");
    exit();
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get data from the POST request
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    // Validate input
    if (empty($name) || empty($phone) || empty($address)) {
        echo "All fields are required.";
        exit();
    }

    // Insert query
    $sql = "INSERT INTO suppliers (name, phone, address, created_at) VALUES ('$name', '$phone', '$address', NOW())";

    if ($conn->query($sql) === TRUE) {
        echo "1"; // Success
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close(); // Close the database connection
}
?>