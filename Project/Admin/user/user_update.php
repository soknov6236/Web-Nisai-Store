<?php
include('../include/connect.php');

// Get the posted data
$userid = $_POST['userid'];
$username = $_POST['user'];
$email = $_POST['email'];
$role = $_POST['role'];
$status = $_POST['status'];

// Validate inputs
if (empty($username) || empty($email) || empty($userid)) {
    die("All fields are required");
}

// Check if username or email already exists (excluding current user)
$check_sql = "SELECT * FROM users WHERE (username = ? OR email = ?) AND id != ?";
$check_stmt = $conn->prepare($check_sql);
$check_stmt->bind_param("ssi", $username, $email, $userid);
$check_stmt->execute();
$result = $check_stmt->get_result();

if ($result->num_rows > 0) {
    die("Username or email already exists");
}

// Update the user
$update_sql = "UPDATE users SET username = ?, email = ?, role = ?, status = ? WHERE id = ?";
$update_stmt = $conn->prepare($update_sql);
$update_stmt->bind_param("sssii", $username, $email, $role, $status, $userid);

if ($update_stmt->execute()) {
    echo "1"; // Success
} else {
    echo "Error: " . $conn->error;
}

$update_stmt->close();
$conn->close();
?>