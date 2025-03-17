<?php
session_start();
include("../../connection.php");

// Redirect to login if user is not logged in
if ($_SESSION['USERID'] == "") {
    header("location:../../login.php");
    exit();
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['user'];
    $email = $_POST['email'];
    $password = password_hash($_POST['pass'], PASSWORD_DEFAULT); // Hash the password
    $status = $_POST['status'];

    // Insert the new user
    $sql = "INSERT INTO users (username, email, password, status) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $username, $email, $password, $status);

    if ($stmt->execute()) {
        echo "1"; // Success
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request method.";
}
?>