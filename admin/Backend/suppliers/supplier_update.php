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
    $id = $_POST['id'];
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    // Validate input
    if (empty($id) || empty($name) || empty($phone) || empty($address)) {
        echo "All fields are required.";
        exit();
    }

    // Update query
    $sql = "UPDATE suppliers SET name='$name', phone='$phone', address='$address' WHERE id='$id'";

    if ($conn->query($sql) === TRUE) {
        echo "1"; // Success
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close(); // Close the database connection
}
?>