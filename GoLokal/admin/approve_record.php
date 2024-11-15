<?php
session_start();
if (!isset($_SESSION['user_role']) || ($_SESSION['user_role'] != 'admin' && $_SESSION['user_role'] != 'staff')) {
    header("Location: ../Login/login.html");
    exit;
}

// Include the database connection file
include 'config/config.php';

if (isset($_GET['id'])) {
    $recordId = intval($_GET['id']); // Ensure the ID is an integer

    // Prepare and execute the update query
    $query = "UPDATE challenges SET proof_status = 'approved' WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $recordId);

    if ($stmt->execute()) {
        echo "<script>alert('Record approved successfully.'); window.location.href = '../admin/view_record.php';</script>";
    } else {
        echo "<script>alert('Error approving record: " . $stmt->error . "'); window.history.back();</script>";
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
} else {
    echo "<script>alert('Invalid request.'); window.history.back();</script>";
}
