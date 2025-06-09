<?php
session_start();
require_once '../../inc/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    
    // Validate input
    if (empty($name)) {
        $_SESSION['error_message'] = "Please provide a name for the finish.";
        header('Location: ../finishes.php');
        exit();
    }
    
    // Handle file upload
    $target_dir = "../uploads/finishes/";
    
    // Create directory if it doesn't exist
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }
    
    $imageFileType = strtolower(pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION));
    $newFileName = uniqid('finish_') . '.' . $imageFileType;
    $target_file = $target_dir . $newFileName;
    $uploadOk = 1;
    
    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if ($check === false) {
        $_SESSION['error_message'] = "File is not an image.";
        $uploadOk = 0;
    }
    
    // Check file size (max 5MB)
    if ($_FILES["image"]["size"] > 5000000) {
        $_SESSION['error_message'] = "Sorry, your file is too large. Maximum size is 5MB.";
        $uploadOk = 0;
    }
    
    // Allow certain file formats
    $allowedTypes = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    if (!in_array($imageFileType, $allowedTypes)) {
        $_SESSION['error_message'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }
    
    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        header('Location: ../finishes.php');
        exit();
    } else {
        // Try to upload file
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            // File uploaded successfully, now insert into database
            $image_path = 'uploads/finishes/' . $newFileName;
            
            try {
                $stmt = $pdo->prepare("INSERT INTO finishes (name, image) VALUES (?, ?)");
                $stmt->execute([$name, $image_path]);
                
                $_SESSION['success_message'] = "Finish added successfully!";
            } catch (PDOException $e) {
                // Delete the uploaded file if database insert fails
                unlink($target_file);
                $_SESSION['error_message'] = "Error adding finish: " . $e->getMessage();
            }
        } else {
            $_SESSION['error_message'] = "Sorry, there was an error uploading your file.";
        }
    }
    
    header('Location: ../finishes.php');
    exit();
} else {
    // If not a POST request, redirect back
    header('Location: ../finishes.php');
    exit();
}
