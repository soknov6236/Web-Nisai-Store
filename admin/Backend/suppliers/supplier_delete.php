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

    // Validate input
    if (empty($id)) {
        echo "Supplier ID is required.";
        exit();
    }

    // Delete query
    $sql = "DELETE FROM suppliers WHERE id='$id'";

    if ($conn->query($sql) === TRUE) {
        echo "1"; // Success
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close(); // Close the database connection
}
?>