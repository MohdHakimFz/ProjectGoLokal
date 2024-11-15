<?php
session_start();
require 'config/config.php';

// Check if user is admin
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] != 'admin') {
    echo json_encode(['success' => false, 'message' => 'Unauthorized access']);
    exit;
}

// Check if required parameters are present
if (!isset($_POST['review_id']) || !isset($_POST['action'])) {
    echo json_encode(['success' => false, 'message' => 'Missing parameters']);
    exit;
}

$review_id = (int)$_POST['review_id'];
$action = $_POST['action'];

// Validate action
if (!in_array($action, ['approve', 'reject'])) {
    echo json_encode(['success' => false, 'message' => 'Invalid action']);
    exit;
}

// Update review status
$status = ($action === 'approve') ? 'approved' : 'rejected';
$query = "UPDATE reviews SET status = ? WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("si", $status, $review_id);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Review ' . $status . ' successfully']);
} else {
    echo json_encode(['success' => false, 'message' => 'Error updating review status']);
}

$stmt->close();
$conn->close();
