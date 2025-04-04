<?php
session_start();
include("connection.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = $_POST['txtuser'];
    $pass = $_POST['txtpass'];

    // Use prepared statement to prevent SQL injection
    $sql = "SELECT * FROM users WHERE username = ? LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $user);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $hashedPassword = $row['password'];

        // Verify password
        if (password_verify($pass, $hashedPassword)) {
            // Login successful - set session variables
            $_SESSION['USERID'] = $row['id'];
            $_SESSION['USERNAME'] = $row['username'];
            $_SESSION['ROLE'] = $row['role']; // Store user role in session
            $_SESSION['login_success'] = "Login successful! Welcome Back " . $row['username'] . "!"; 
            
            // Return role for redirection
            echo $row['role']; // Return 'admin' or 'employee' for AJAX handling
        } else {
            // Invalid password
            echo "0"; // Failure
        }
    } else {
        // User not found
        echo "0"; // Failure
    }
    $stmt->close();
}
$conn->close();
?>