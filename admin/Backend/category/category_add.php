<?php
session_start();
include("../../connection.php");

// Redirect to login if user is not logged in
if ($_SESSION['USERID'] == "") {
    header("location:../../login.php");
    exit();
}

// Get data from the AJAX request
$title = $_POST['title'];
$picture = $_FILES['picture']; // File upload handling

// Validate inputs
if (empty($title)) {
    echo "Title is required.";
    exit();
}

// Handle file upload
if (isset($picture) && $picture['error'] == 0) {
    $targetDir = "uploads/"; // Directory to store uploaded files
    $fileName = basename($picture["name"]);
    $targetFilePath = $targetDir . $fileName;
    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

    // Allow certain file formats
    $allowedTypes = array('jpg', 'png', 'jpeg', 'gif');
    if (in_array($fileType, $allowedTypes)) {
        // Upload file to server
        if (move_uploaded_file($picture["tmp_name"], $targetFilePath)) {
            // Insert category into the database
            $sql = "INSERT INTO category (cat_title, picture) VALUES (?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $title, $fileName);

            if ($stmt->execute()) {
                echo "1"; // Success
            } else {
                echo "Error: " . $stmt->error;
            }
        } else {
            echo "Error uploading file.";
        }
    } else {
        echo "Invalid file type. Only JPG, PNG, JPEG, and GIF are allowed.";
    }
} else {
    echo "File upload error.";
}
?>