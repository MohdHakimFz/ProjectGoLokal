<?php
session_start();
include('config/config.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: ../../Login/login.html");
    exit();
}

$user_id = $_SESSION['user_id'];
$item_id = $_POST['item_id'] ?? null;
$item_points = $_POST['item_points'] ?? null;
$item_name = $_POST['item_name'] ?? null;
$name = $_POST['name'] ?? null;
$address = $_POST['address'] ?? null;
$phone = $_POST['phone'] ?? null;
$email = $_POST['email'] ?? null;
$notes = $_POST['notes'] ?? '';

// Validate required fields
if (!$item_id || !$item_points || !$item_name || !$name || !$address || !$phone || !$email) {
    echo "<p style='color: red;'>Error: All fields are required.</p>";
    exit();
}

// Validate email format
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "<p style='color: red;'>Error: Invalid email format.</p>";
    exit();
}

// Verify the user's points
$query = "SELECT points FROM users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$current_points = $user['points'];
$stmt->close();

if ($current_points >= $item_points) {
    $new_points = $current_points - $item_points;
    $update_points_query = "UPDATE users SET points = ? WHERE id = ?";
    $stmt = $conn->prepare($update_points_query);
    $stmt->bind_param("ii", $new_points, $user_id);

    if ($stmt->execute()) {
        // Insert redemption record
        $redemption_query = "INSERT INTO redemptions (user_id, item_id, item_name, name, address, phone, email, notes, redemption_status) 
                             VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'Pending')";
        $stmt = $conn->prepare($redemption_query);
        $stmt->bind_param("iissssss", $user_id, $item_id, $item_name, $name, $address, $phone, $email, $notes);

        if ($stmt->execute()) {
            $message = "Redemption successful! Your $item_name will be shipped to $address.";
        } else {
            $message = "Error: Could not record redemption. Please try again.";
        }
    } else {
        $message = "Error: Unable to update points. Please try again.";
    }
    $stmt->close();
} else {
    $message = "Error: You don't have enough points.";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Redemption Status</title>
    <link rel="stylesheet" href="assets/css/confirmation.css">
    <link rel="icon" type="image/png" href="assets/image/GoLokal Logo.png">
</head>

<body>

    <div class="confirmation-container">
        <h1>Redemption Status</h1>
        <p><?php echo htmlspecialchars($message); ?></p>
        <a href="../welcome.php" class="back-home-button">Back to Home</a>
    </div>

</body>

</html>