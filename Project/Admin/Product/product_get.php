<?php
session_start();
include("../../connection.php");

// Redirect to login if user is not logged in
if ($_SESSION['USERID'] == "") {
    header("location:../../login.php");
    exit();
}

    
$id = $_POST['id'];
$sql = "SELECT * FROM products WHERE id='$id'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

echo json_encode($row);

$conn->close();
?>