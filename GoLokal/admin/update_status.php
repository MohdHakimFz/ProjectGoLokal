<?php
session_start();
include('config/config.php');

if (!isset($_SESSION['user_role']) || ($_SESSION['user_role'] != 'admin' && $_SESSION['user_role'] != 'staff')) {
    header("Location: ../Login/login.html");
    exit;
}

// Fetch user data from the database based on the user_id stored in the session
$user_id = $_SESSION['user_id'];
$query = "SELECT profile_picture, name FROM users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Default to 'default.png' if no profile picture is set
$profile_picture = isset($user['profile_picture']) ? $user['profile_picture'] : 'default.png';
$user_name = isset($user['name']) ? $user['name'] : 'My Account';

// Construct the full path for the profile picture
$profile_picture_path = "../uploads/" . htmlspecialchars($profile_picture);

// Check if the profile picture file exists and is a valid image
if (!file_exists($profile_picture_path) || exif_imagetype($profile_picture_path) === false) {
    $profile_picture_path = "../uploads/default.png"; // Fallback to default image if not found or invalid image
}

// Get redemption ID and status from POST
$redemption_id = $_POST['redemption_id'] ?? null;
$redemption_status = $_POST['redemption_status'] ?? null;

if ($redemption_id && $redemption_status) {
    // Update the status in the database
    $query = "UPDATE redemptions SET redemption_status = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("si", $redemption_status, $redemption_id);
    if ($stmt->execute()) {
        $_SESSION['message'] = "Redemption status updated successfully.";
    } else {
        $_SESSION['error'] = "Error updating redemption status.";
    }
    $stmt->close();
} else {
    $_SESSION['error'] = "Invalid redemption update request.";
}

$conn->close();

// Redirect back to redemption status management page
header("Location: ../admin/redeem_status.php");
exit();
