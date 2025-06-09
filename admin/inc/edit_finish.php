<?php
session_start();
require_once '../../inc/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
    $name = trim($_POST['name']);
    
    // Validate input
    if (empty($name) || !$id) {
        $_SESSION['error_message'] = "Please provide valid information.";
        header('Location: ../finishes.php');
        exit();
    }
    
    try {
        // Check if a new image was uploaded
        if (!empty($_FILES["image"]["name"])) {
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
                throw new Exception("File is not an image.");
            }
            
            // Check file size (max 5MB)
            if ($_FILES["image"]["size"] > 5000000) {
                throw new Exception("Sorry, your file is too large. Maximum size is 5MB.");
            }
            
            // Allow certain file formats
            $allowedTypes = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
            if (!in_array($imageFileType, $allowedTypes)) {
                throw new Exception("Sorry, only JPG, JPEG, PNG & GIF files are allowed.");
            }
            
            // Get the old image path to delete it later
            $stmt = $pdo->prepare("SELECT image FROM finishes WHERE id = ?");
            $stmt->execute([$id]);
            $oldImage = $stmt->fetchColumn();
            
            // Try to upload the new file
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                $image_path = 'uploads/finishes/' . $newFileName;
                
                // Update with new image
                $stmt = $pdo->prepare("UPDATE finishes SET name = ?, image = ? WHERE id = ?");
                $stmt->execute([$name, $image_path, $id]);
                
                // Delete the old image if it exists
                if ($oldImage && file_exists("../" . $oldImage)) {
                    unlink("../" . $oldImage);
                }
                
                $_SESSION['success_message'] = "Finish updated successfully!";
            } else {
                throw new Exception("Sorry, there was an error uploading your file.");
            }
        } else {
            // Update without changing the image
            $stmt = $pdo->prepare("UPDATE finishes SET name = ? WHERE id = ?");
            $stmt->execute([$name, $id]);
            
            $_SESSION['success_message'] = "Finish updated successfully!";
        }
    } catch (Exception $e) {
        $_SESSION['error_message'] = "Error updating finish: " . $e->getMessage();
    }
    
    header('Location: ../finishes.php');
    exit();
} else {
    // If not a POST request, redirect back
    header('Location: ../finishes.php');
    exit();
}
