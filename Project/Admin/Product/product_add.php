<?php
session_start();
include("../../connection.php");

// Redirect to login if user is not logged in
if ($_SESSION['USERID'] == "") {
    header("location:../../login.php");
    exit();
}

$name = $_POST['name'];
$category = $_POST['category'];
$supplier = $_POST['supplier'];
$price = $_POST['price'];
$stock = $_POST['stock'];
$size = $_POST['size'];
$color = $_POST['color'];
$product_code = $_POST['product_code']; // Add this line
$picture = $_FILES['picture']['name'];
$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["picture"]["name"]);

move_uploaded_file($_FILES["picture"]["tmp_name"], $target_file);

$sql = "INSERT INTO products (name, catid, supplier_id, price, stock, size, color,  image, product_code) 
        VALUES ('$name', '$category', '$supplier', '$price', '$stock', '$size', '$color', '$picture', '$product_code')";

if ($conn->query($sql) === TRUE) {
    echo "1";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>