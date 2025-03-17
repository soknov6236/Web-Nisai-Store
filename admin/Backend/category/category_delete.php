<?php
session_start();
include("../../connection.php");

// Redirect to login if user is not logged in
if ($_SESSION['USERID'] == "") {
    header("location:../../login.php");
    exit();
}

// Get the category ID from the AJAX request
$catid = $_POST['catid'];

// Validate input
if (empty($catid)) {
    echo "Category ID is required.";
    exit();
}

// Delete the category from the database
$sql = "DELETE FROM category WHERE catid = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $catid);

if ($stmt->execute()) {
    echo "1"; // Success
} else {
    echo "Error: " . $stmt->error;
}
?>