<?php
session_start();
include("../../connection.php");

// Redirect to login if user is not logged in
if (empty($_SESSION['USERID'])) {
    header("location:../../login.php");
    exit();
}

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve and sanitize form data
    $id = intval($_POST['id']);
    $name = htmlspecialchars($_POST['name']);
    $category = intval($_POST['category']);
    $supplier = intval($_POST['supplier']);
    $price = floatval($_POST['price']);
    $stock = intval($_POST['stock']);
    $size = htmlspecialchars($_POST['size']);
    $color = htmlspecialchars($_POST['color']);
    $product_code = htmlspecialchars($_POST['product_code']);

    // Validate required fields
    if (empty($id) || empty($name) || empty($category) || empty($supplier) || empty($price) || empty($stock) || empty($size) || empty($color) || empty($product_code)) {
        echo "Error: All fields are required.";
        exit();
    }

    // Handle file upload
    $picture = null;
    if (isset($_FILES['picture']) && $_FILES['picture']['error'] == 0) {
        $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
        $max_size = 5 * 1024 * 1024; // 5MB
        $target_dir = "uploads/";
        $file_name = basename($_FILES["picture"]["name"]);
        $imageFileType = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

        // Validate file type
        if (!in_array($imageFileType, $allowed_types)) {
            echo "Error: Only JPG, JPEG, PNG, and GIF files are allowed.";
            exit();
        }

        // Validate file size
        if ($_FILES["picture"]["size"] > $max_size) {
            echo "Error: File size exceeds the maximum limit of 5MB.";
            exit();
        }

        // Generate a unique filename
        $picture = uniqid() . "." . $imageFileType;
        $target_file = $target_dir . $picture;

        // Move the uploaded file
        if (!move_uploaded_file($_FILES["picture"]["tmp_name"], $target_file)) {
            echo "Error: Failed to upload file.";
            exit();
        }
    }

    // Update the product record in the database
    $conn->begin_transaction();

    try {
        if ($picture) {
            $sql = "UPDATE products 
                    SET name = ?, catid = ?, supplier_id = ?, price = ?, stock = ?, size = ?, color = ?, product_code = ?, image = ?
                    WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("siidsssssi", $name, $category, $supplier, $price, $stock, $size, $color, $product_code, $picture, $id);
        } else {
            $sql = "UPDATE products 
                    SET name = ?, catid = ?, supplier_id = ?, price = ?, stock = ?, size = ?, color = ?, product_code = ?
                    WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("siidssssi", $name, $category, $supplier, $price, $stock, $size, $color, $product_code, $id);
        }

        if (!$stmt->execute()) {
            throw new Exception("Error updating product: " . $stmt->error);
        }

        $conn->commit();
        echo "1"; // Success
    } catch (Exception $e) {
        $conn->rollback();
        echo $e->getMessage();
    }

    $stmt->close();
    $conn->close();
} else {
    http_response_code(405); // Method Not Allowed
    echo "Error: Invalid request method.";
}
?>