<?php
session_start();
include("connection.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = $_POST['txtuser'];
    $pass = $_POST['txtpass'];

    // Fetch user from database
    $sql = "SELECT * FROM users WHERE username = '$user' LIMIT 1";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $hashedPassword = $row['password'];

        // Verify password
        if (password_verify($pass, $hashedPassword)) {
            // Login successful
            $_SESSION['USERID'] = $row['id'];
            $_SESSION['USERNAME'] = $row['username'];
            $_SESSION['login_success'] = "Login successful! Welcome back Nisai Store!" . $row['username'] . "."; 
            echo 1; // Success
        } else {
            // Invalid password
            echo 0; // Failure
        }
    } else {
        // User not found
        echo 0; // Failure
    }
}
?>