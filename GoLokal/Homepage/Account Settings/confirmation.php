<?php
session_start();
include('config/config.php');

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../../Login/login.html");
    exit();
}

// Get item details from POST
$item_id = $_POST['item_id'] ?? null;
$item_name = $_POST['item_name'] ?? null;
$item_points = $_POST['item_points'] ?? null;

// Check if item details are valid
if (!$item_id || !$item_name || !$item_points) {
    echo "<p style='color: red;'>Invalid redemption request.</p>";
    exit();
}

// Fetch user's points
$user_id = $_SESSION['user_id'];
$query = "SELECT points FROM users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$user_points = $user['points'];
$stmt->close();

// Check if user has enough points
if ($user_points < $item_points) {
    // Redirect back to welcome.php with an error message
    $_SESSION['error_message'] = "You do not have enough points for this item.";
    header("Location: ../welcome.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Redeem Confirmation</title>
    <link rel="stylesheet" href="assets/css/confirmation.css">
    <link rel="icon" type="image/png" href="assets/image/GoLokal Logo.png">
</head>

<body>

    <div class="confirmation-container">
        <h1>Confirm Your Redemption</h1>
        <p>You're about to redeem: <strong><?php echo htmlspecialchars($item_name); ?></strong></p>
        <p>Points Required: <strong><?php echo htmlspecialchars($item_points); ?></strong></p>
        <p>Your Current Points: <strong><?php echo htmlspecialchars($user_points); ?></strong></p>

        <form action="process_redemption.php" method="post">
            <!-- Pass item details to the next step -->
            <input type="hidden" name="item_id" value="<?php echo htmlspecialchars($item_id); ?>">
            <input type="hidden" name="item_points" value="<?php echo htmlspecialchars($item_points); ?>">
            <input type="hidden" name="item_name" value="<?php echo htmlspecialchars($item_name); ?>">

            <!-- User details form -->
            <label for="name">Full Name:</label>
            <input type="text" id="name" name="name" required>

            <label for="address">Shipping Address:</label>
            <textarea id="address" name="address" required></textarea>

            <label for="phone">Phone Number:</label>
            <input type="text" id="phone" name="phone" required>

            <label for="email">Email Address:</label>
            <input type="email" id="email" name="email" required>

            <label for="notes">Additional Notes (optional):</label>
            <textarea id="notes" name="notes"></textarea>

            <button type="submit" class="confirm-btn">Confirm Redemption</button>
        </form>
    </div>

</body>

</html>