<?php
session_start();
include('config.php');

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: ../../Login/login.html');
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['challenge_id']) && isset($_FILES['proofUpload'])) {
    $challenge_id = $_POST['challenge_id'];
    $proof_image = $_FILES['proofUpload'];

    // Handle file upload
    $target_dir = "../../uploads/";
    $target_file = $target_dir . basename($proof_image["name"]);

    if (move_uploaded_file($proof_image["tmp_name"], $target_file)) {
        // Update the challenge record with proof information
        $submission_date = date('Y-m-d H:i:s');
        $status = 'Pending';

        $sql = "UPDATE challenges 
                SET proof_image_path = ?, proof_submission_date = ?, proof_status = ?
                WHERE id = ?";

        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            die("Error preparing statement: " . $conn->error);
        }

        $stmt->bind_param('sssi', $target_file, $submission_date, $status, $challenge_id);

        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => $stmt->error]);
        }

        $stmt->close();
    } else {
        echo json_encode(['success' => false, 'message' => 'Error uploading file.']);
    }
}
