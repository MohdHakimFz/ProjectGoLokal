<?php
session_start();
include('../../config/config.php');

// Check if user is logged in and booking details exist
if (!isset($_SESSION['user_id']) || !isset($_SESSION['booking']) || !isset($_SESSION['payment_id'])) {
    header('Location: tour.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$booking = $_SESSION['booking'];
$payment_id = $_SESSION['payment_id'];

// Generate receipt details
$receipt_date = date('Y-m-d H:i:s');
$total_amount = $booking['plan_price'];
$receipt_details = json_encode([
    'plan_name' => $booking['plan_name'],
    'payment_date' => $booking['payment_date'],
    'points_earned' => $booking['points_earned']
]);

// Step 1: Insert receipt into the database (initially without receipt_id)
$sql = "INSERT INTO receipts (payment_id, receipt_date, total_amount, receipt_details) 
        VALUES (?, ?, ?, ?)";

$stmt = $conn->prepare($sql);

if ($stmt === false) {
    die("Error preparing statement: " . $conn->error);
}

// Bind parameters
$stmt->bind_param('isds', $payment_id, $receipt_date, $total_amount, $receipt_details);

if (!$stmt->execute()) {
    echo "Error storing receipt: " . $stmt->error;
    exit();
}

$receipt_id_numeric = $stmt->insert_id; // Get the auto-incremented receipt_id as a number
$stmt->close();

// Step 2: Get the last receipt number and format the new receipt_id
$last_receipt_sql = "SELECT MAX(CAST(SUBSTRING(receipt_id, 3) AS UNSIGNED)) as last_number 
                     FROM receipts 
                     WHERE receipt_id REGEXP '^GL[0-9]+$'";
$last_receipt_result = $conn->query($last_receipt_sql);

if ($last_receipt_result && $last_receipt_result->fetch_assoc()['last_number']) {
    $next_number = $last_receipt_result->fetch_assoc()['last_number'] + 1;
} else {
    $next_number = 3; // Start from GL00003 if no previous receipts
}

$formatted_receipt_id = 'GL' . str_pad($next_number, 5, '0', STR_PAD_LEFT);

// Step 3: Update the receipt record with the formatted receipt_id
$update_sql = "UPDATE receipts SET receipt_id = ? WHERE id = ?";
$update_stmt = $conn->prepare($update_sql);

if ($update_stmt === false) {
    die("Error preparing update statement: " . $conn->error);
}

$update_stmt->bind_param('si', $formatted_receipt_id, $receipt_id_numeric);

if (!$update_stmt->execute()) {
    echo "Error updating receipt ID: " . $update_stmt->error;
    exit();
}

$update_stmt->close();

// Get user details if needed
$user_sql = "SELECT username, email FROM users WHERE id = ?";
$user_stmt = $conn->prepare($user_sql);

if ($user_stmt === false) {
    die("Error preparing statement: " . $conn->error);
}

$user_stmt->bind_param('i', $user_id);
$user_stmt->execute();
$user_result = $user_stmt->get_result();
$user_data = $user_result->fetch_assoc();
$user_stmt->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Payment Receipt</title>
    <link rel="stylesheet" href="assets/css/receipt.css">
    <link rel="icon" type="image/png" href="assets/image/GoLokal Logo.png">
</head>

<body>
    <div class="receipt-container">
        <div class="receipt-header">
            <h1>Payment Receipt</h1>
            <!-- Output the formatted receipt ID -->
            <div class="receipt-id">Receipt <?php echo htmlspecialchars($formatted_receipt_id); ?></div>
        </div>

        <div class="receipt-details">
            <div class="receipt-row">
                <span class="receipt-label">Customer:</span>
                <span><?php echo htmlspecialchars($user_data['username']); ?></span>
            </div>
            <div class="receipt-row">
                <span class="receipt-label">Email:</span>
                <span><?php echo htmlspecialchars($user_data['email']); ?></span>
            </div>
            <div class="receipt-row">
                <span class="receipt-label">Date:</span>
                <span><?php echo date('F j, Y g:i A', strtotime($booking['payment_date'])); ?></span>
            </div>
            <div class="receipt-row">
                <span class="receipt-label">Payment ID:</span>
                <span><?php echo htmlspecialchars($payment_id); ?></span>
            </div>
            <div class="receipt-row">
                <span class="receipt-label">Plan:</span>
                <span><?php echo htmlspecialchars($booking['plan_name']); ?></span>
            </div>

            <div class="receipt-row total-amount">
                <span class="receipt-label">Total Amount:</span>
                <span>RM <?php echo number_format($total_amount, 2); ?></span>
            </div>
        </div>

        <div class="points-earned">
            You earned <?php echo htmlspecialchars($booking['points_earned']); ?> points with this purchase!
        </div>

        <div class="receipt-footer">
            Thank you for your purchase!
        </div>

        <button onclick="window.print()" class="print-button">Print Receipt</button>
        <a href="../Tour/Tour.php" class="back-link">← Back to Tour Page</a>
    </div>

    <?php
    // Clear the session variables after displaying the receipt
    unset($_SESSION['booking']);
    unset($_SESSION['payment_id']);
    ?>
</body>

</html>