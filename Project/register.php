<?php
session_start();
include('connection.php');

// Get and sanitize input data
$username = trim($_POST['txtuser'] ?? '');
$email = trim($_POST['txtemail'] ?? '');
$password = $_POST['txtpass'] ?? '';

// Validate inputs
if (empty($username) || empty($email) || empty($password)) {
    die("All fields are required");
}

// Validate username (4-20 chars, alphanumeric + underscore)
if (!preg_match('/^[a-zA-Z0-9_]{4,20}$/', $username)) {
    die("Username must be 4-20 characters (letters, numbers, underscores)");
}

// Validate email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die("Please enter a valid email address");
}

// Validate password (min 8 chars with at least 1 number)
if (strlen($password) < 8 || !preg_match('/\d/', $password)) {
    die("Password must be at least 8 characters with at least one number");
}

// Check if username or email already exists
$stmt = $conn->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
$stmt->bind_param("ss", $username, $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $stmt->close();
    $conn->close();
    die("Username or email already exists");
}

// Hash the password
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Default role and status for new users
$role = 'employee';
$status = 1; // Active

// Insert the new user
$insert_stmt = $conn->prepare("INSERT INTO users (username, email, password, role, status, created_at) 
                             VALUES (?, ?, ?, ?, ?, NOW())");
$insert_stmt->bind_param("ssssi", $username, $email, $hashed_password, $role, $status);

if ($insert_stmt->execute()) {
    // Registration successful
    echo "1";
} else {
    // Database error
    echo "Registration failed. Please try again later.";
}

$insert_stmt->close();
$conn->close();
?>