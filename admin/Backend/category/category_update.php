<?php
session_start();
include("../../connection.php");

// Check if the user is logged in
if (trim($_SESSION['USERID']) == "") {
    header("location:../../login.php");
    exit();
}

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $catid = $_POST['catid'];
    $title = $_POST['title'];

    // Handle file upload (if a new picture is provided)
    $picture = null;
    if (isset($_FILES['picture']) && $_FILES['picture']['error'] == 0) {
        $target_dir = "uploads/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0755, true); // Create the directory if it doesn't exist
        }

        $imageFileType = strtolower(pathinfo($_FILES["picture"]["name"], PATHINFO_EXTENSION));

        // Check if the file is an image
        $check = getimagesize($_FILES["picture"]["tmp_name"]);
        if ($check !== false) {
            // Generate a unique filename to avoid conflicts
            $picture = uniqid() . "." . $imageFileType;
            $target_file = $target_dir . $picture;

            // Move the uploaded file to the target directory
            if (move_uploaded_file($_FILES["picture"]["tmp_name"], $target_file)) {
                // File uploaded successfully
            } else {
                echo "Error: Failed to move uploaded file.";
                exit();
            }
        } else {
            echo "Error: File is not an image.";
            exit();
        }
    }

    // Update the category record in the database
    if ($picture) {
        // If a new picture is uploaded, update both the title and picture fields
        $sql = "UPDATE category SET cat_title = ?, picture = ? WHERE catid = ?";
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            echo "Error preparing statement: " . $conn->error;
            exit();
        }
        $stmt->bind_param("ssi", $title, $picture, $catid);
    } else {
        // If no new picture is uploaded, update only the title field
        $sql = "UPDATE category SET cat_title = ? WHERE catid = ?";
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            echo "Error preparing statement: " . $conn->error;
            exit();
        }
        $stmt->bind_param("si", $title, $catid);
    }

    // Execute the statement
    if ($stmt->execute()) {
        echo "1"; // Success
    } else {
        echo "Error updating category: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
} else {
    echo "Invalid request method.";
}

// Close the database connection
$conn->close();
?>