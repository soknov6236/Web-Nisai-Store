<?php
include('../include/connect.php');

// Get the posted data
$username = $_POST['user'];
$email = $_POST['email'];
$password = $_POST['pass'];
$role = $_POST['role'];
$status = $_POST['status'];

// Validate inputs
if (empty($username) || empty($email) || empty($password)) {
    die("All fields are required");
}

// Check if username or email already exists
$check_sql = "SELECT * FROM users WHERE username = ? OR email = ?";
$check_stmt = $conn->prepare($check_sql);
$check_stmt->bind_param("ss", $username, $email);
$check_stmt->execute();
$result = $check_stmt->get_result();

if ($result->num_rows > 0) {
    die("Username or email already exists");
}

// Hash the password
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Insert the new user
$insert_sql = "INSERT INTO users (username, email, password, role, status, created_at) 
               VALUES (?, ?, ?, ?, ?, NOW())";
$insert_stmt = $conn->prepare($insert_sql);
$insert_stmt->bind_param("ssssi", $username, $email, $hashed_password, $role, $status);

if ($insert_stmt->execute()) {
    echo "1"; // Success
} else {
    echo "Error: " . $conn->error;
}

$insert_stmt->close();
$conn->close();
?>