<?php
session_start();
include("../../connection.php");

// Redirect to login if user is not logged in
if ($_SESSION['USERID'] == "") {
    header("location:../../login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userid = $_POST['userid'];
    $username = $_POST['user'];
    $email = $_POST['email'];
    $password = !empty($_POST['pass']) ? password_hash($_POST['pass'], PASSWORD_DEFAULT) : null; // Hash the password if provided
    $status = $_POST['status'];

    // Update the user
    if ($password) {
        $sql = "UPDATE users SET username = ?, email = ?, password = ?, status = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssi", $username, $email, $password, $status, $userid);
    } else {
        $sql = "UPDATE users SET username = ?, email = ?, status = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssi", $username, $email, $status, $userid);
    }

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