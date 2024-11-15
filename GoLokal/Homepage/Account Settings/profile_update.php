<?php
session_start();
require 'config/config.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../../Login/login.html"); // Redirect if not logged in
    exit();
}

$user_id = $_SESSION['user_id']; // Get the user ID from session

// Fetch existing user details from the database
$query = "SELECT * FROM users WHERE id=?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Add profile picture URL handling
$profile_picture_url = '';
if (!empty($user['profile_picture'])) {
    $profile_picture_path = "uploads/" . $user['profile_picture'];
    if (file_exists($profile_picture_path)) {
        $profile_picture_url = $profile_picture_path;
    } else {
        $profile_picture_url = 'path/to/default-avatar.png';
    }
} else {
    $profile_picture_url = 'path/to/default-avatar.png';
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $conn->begin_transaction();

        // Validate required fields
        $required_fields = ['full_name', 'email', 'phone', 'username'];
        foreach ($required_fields as $field) {
            if (empty($_POST[$field])) {
                throw new Exception("Please fill in all required fields");
            }
        }

        // Validate email format
        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Invalid email format");
        }

        // Sanitize input data
        $full_name = $conn->real_escape_string(trim($_POST['full_name']));
        $email = $conn->real_escape_string(trim($_POST['email']));
        $phone = $conn->real_escape_string(trim($_POST['phone']));
        $dob = $conn->real_escape_string(trim($_POST['dob']));
        $username = $conn->real_escape_string(trim($_POST['username']));

        // Check for duplicate email
        $email_check_query = "SELECT id FROM users WHERE email = ? AND id != ?";
        $email_check_stmt = $conn->prepare($email_check_query);
        $email_check_stmt->bind_param("si", $email, $user_id);
        $email_check_stmt->execute();
        if ($email_check_stmt->get_result()->num_rows > 0) {
            throw new Exception("The email address is already in use");
        }

        // Handle profile picture upload
        $profile_picture = $user['profile_picture'];
        if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] == 0) {
            $target_dir = "../../uploads/";
            $imageFileType = strtolower(pathinfo($_FILES['profile_picture']['name'], PATHINFO_EXTENSION));
            $target_file = $target_dir . basename($user_id . '.' . $imageFileType);

            if (!is_dir($target_dir)) {
                mkdir($target_dir, 0777, true);
            }

            if ($_FILES['profile_picture']['size'] > 2097152) {
                throw new Exception("Sorry, your file is too large. Max size: 2MB.");
            }

            $allowed_formats = array("jpg", "jpeg", "png", "gif");
            if (!in_array($imageFileType, $allowed_formats)) {
                throw new Exception("Sorry, only JPG, JPEG, PNG & GIF files are allowed.");
            }

            $check = getimagesize($_FILES['profile_picture']['tmp_name']);
            if ($check === false) {
                throw new Exception("File is not a valid image.");
            }

            if (!move_uploaded_file($_FILES['profile_picture']['tmp_name'], $target_file)) {
                throw new Exception("Error uploading profile picture.");
            }

            $profile_picture = $user_id . '.' . $imageFileType;
        }

        // Handle password update
        $password_update = false;
        if (!empty($_POST['new_password'])) {
            if (strlen($_POST['new_password']) < 8) {
                throw new Exception("Password must be at least 8 characters long");
            }
            if ($_POST['new_password'] !== $_POST['confirm_password']) {
                throw new Exception("Passwords do not match");
            }
            $password_update = true;
            $password_hash = password_hash($conn->real_escape_string($_POST['new_password']), PASSWORD_DEFAULT);
        }

        // Prepare update query
        $sql = "UPDATE users SET 
                name = ?, 
                email = ?, 
                phone = ?, 
                dob = ?, 
                username = ?, 
                profile_picture = ?";

        if ($password_update) {
            $sql .= ", password = ?";
        }
        $sql .= " WHERE id = ?";

        $stmt = $conn->prepare($sql);

        if ($password_update) {
            $stmt->bind_param("sssssssi", $full_name, $email, $phone, $dob, $username, $profile_picture, $password_hash, $user_id);
        } else {
            $stmt->bind_param("ssssssi", $full_name, $email, $phone, $dob, $username, $profile_picture, $user_id);
        }

        if (!$stmt->execute()) {
            throw new Exception("Error updating profile");
        }

        $conn->commit();

        // Update session
        $_SESSION['user_name'] = $full_name;
        $_SESSION['profile_picture'] = $profile_picture;

        $_SESSION['success_message'] = "Profile updated successfully";
        header("Location: ../welcome.php");
        exit();
    } catch (Exception $e) {
        $conn->rollback();
        $_SESSION['error_message'] = $e->getMessage();
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
}

$stmt->close();
$conn->close();
