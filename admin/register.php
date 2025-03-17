<?php
session_start();
include("connection.php"); // Include your database connection file

// Enable error logging for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the form data
    $username = $_POST['txtuser'];
    $email = $_POST['txtemail'];
    $password = $_POST['txtpass'];

    // Validate inputs
    if (empty($username) || empty($email) || empty($password)) {
        echo "0"; // Return 0 if any field is empty
        exit();
    }

    // Check if the username or email already exists
    $checkUserQuery = "SELECT * FROM users WHERE username = ? OR email = ?";
    $stmt = $conn->prepare($checkUserQuery);
    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "0"; // Return 0 if username or email already exists
        exit();
    }

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insert the new user into the database
    $insertUserQuery = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($insertUserQuery);
    $stmt->bind_param("sss", $username, $email, $hashedPassword);

    if ($stmt->execute()) {
        echo "1"; // Return 1 if registration is successful
    } else {
        echo "0"; // Return 0 if there's an error
    }

    // Close the database connection
    $stmt->close();
    $conn->close();
} else {
    echo "0"; // Return 0 if the request method is not POST
}
?>