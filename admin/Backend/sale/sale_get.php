<?php
session_start();
include("../../connection.php");

// Redirect to login if user is not logged in
if ($_SESSION['USERID'] == "") {
    header("location:../../login.php");
    exit();
}

$id = $_GET['id'];

$sql = "SELECT * FROM sales WHERE sale_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $sale = $result->fetch_assoc();
    echo json_encode($sale);
} else {
    echo json_encode([]);
}

$stmt->close();
$conn->close();
?>