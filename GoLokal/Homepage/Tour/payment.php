<?php
session_start();
include('../../config/config.php');

// Function to check if the connection is alive and reconnect if needed
function checkConnection($conn)
{
    if (!mysqli_ping($conn)) {
        mysqli_close($conn);
        include('../../config/config.php'); // Reconnect to the database
    }
}

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "<p style='color: red;'>Error: User is not logged in.</p>";
    exit();
}

$user_id = $_SESSION['user_id'];
$plan_name = isset($_POST['plan_name']) ? $_POST['plan_name'] : '';
$plan_price = isset($_POST['plan_price']) ? $_POST['plan_price'] : '';

if (empty($plan_name) || empty($plan_price)) {
    echo "<p style='color: red;'>Error: Plan details are missing. Please go back and try again.</p>";
    echo "<a href='../Tour/Tour.php'>Go back to Tour page</a>";
    exit();
}

// Process payment
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['process_payment'])) {
    // Simulate payment processing delay
    sleep(1);

    // Check the connection before processing payment
    checkConnection($conn);

    // Create a payment record
    $sql = "INSERT INTO payments (user_id, plan_name, plan_price, payment_status, payment_date, points_earned) 
            VALUES (?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Error preparing statement: " . $conn->error);
    }

    $payment_status = 'Successful';
    $payment_date = date('Y-m-d H:i:s');
    $points_earned = rand(50, 200); // Random points earned

    // Bind parameters
    $stmt->bind_param('isdssi', $user_id, $plan_name, $plan_price, $payment_status, $payment_date, $points_earned);

    // Check the connection again before executing the statement
    checkConnection($conn);

    // Execute the statement
    if ($stmt->execute()) {
        $payment_id = $stmt->insert_id; // Save payment_id from this transaction

        // Prepare for the receipt
        $_SESSION['booking'] = [
            'plan_name' => $plan_name,
            'plan_price' => $plan_price,
            'payment_status' => $payment_status,
            'payment_date' => $payment_date,
            'points_earned' => $points_earned
        ];

        // Insert into receipts table
        $receipt_date = date('Y-m-d H:i:s');
        $receipt_details = json_encode([
            'plan_name' => $plan_name,
            'plan_price' => $plan_price,
            'payment_status' => $payment_status,
            'payment_date' => $payment_date,
            'points_earned' => $points_earned
        ]);

        // Start transaction
        $conn->begin_transaction();

        try {
            // Lock the receipts table and get the latest receipt number
            $last_id_query = "SELECT MAX(CAST(SUBSTRING(receipt_id, 3) AS UNSIGNED)) as max_num 
                             FROM receipts 
                             WHERE receipt_id LIKE 'GL%' 
                             FOR UPDATE";
            $result = $conn->query($last_id_query);
            $row = $result->fetch_assoc();
            $next_num = ($row['max_num'] === null) ? 1 : $row['max_num'] + 1;

            // Generate new receipt_id
            $receipt_id = 'GL' . str_pad($next_num, 5, '0', STR_PAD_LEFT);

            // Insert into receipts table
            $insert_receipt_query = "INSERT INTO receipts (receipt_id, payment_id, receipt_date, total_amount, receipt_details, created_at) 
                                   VALUES (?, ?, ?, ?, ?, ?)";

            $receipt_stmt = $conn->prepare($insert_receipt_query);
            if ($receipt_stmt) {
                $receipt_stmt->bind_param('sissss', $receipt_id, $payment_id, $receipt_date, $plan_price, $receipt_details, $receipt_date);

                if (!$receipt_stmt->execute()) {
                    throw new Exception("Error creating receipt: " . $receipt_stmt->error);
                }
                $receipt_stmt->close();
            }

            // Commit transaction
            $conn->commit();
        } catch (Exception $e) {
            // Rollback transaction on error
            $conn->rollback();
            echo "<p style='color: red;'>" . $e->getMessage() . "</p>";
            exit();
        }

        // Automatically create a challenge related to the booking
        $challenge_title = "Complete your visit for first booking" . $payment_id;
        $challenge_description = "Submit proof of your visit to earn points.";
        $challenge_points = 1000; // Set points for this challenge

        $insert_challenge_query = "INSERT INTO challenges (title, description, challenge_points, proof_status, plan_name, user_id, payment_id)
                                   VALUES (?, ?, ?, 'pending', ?, ?, ?)";

        $challenge_stmt = $conn->prepare($insert_challenge_query);
        if ($challenge_stmt) {
            $challenge_stmt->bind_param('ssissi', $challenge_title, $challenge_description, $challenge_points, $plan_name, $user_id, $payment_id);
            if (!$challenge_stmt->execute()) {
                echo "<p style='color: red;'>Error creating challenge: " . $challenge_stmt->error . "</p>";
            }
            $challenge_stmt->close();
        }

        // Redirect to the receipt page
        header('Location: ../Account Settings/Transaction.php');
        exit();
    } else {
        echo "<p style='color: red;'>Error processing payment: " . $stmt->error . "</p>";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secure Payment Gateway</title>
    <link rel="stylesheet" href="assets/css/payment.css">
    <link rel="icon" type="image/png" href="assets/image/GoLokal Logo.png">
</head>

<body>
    <div class="payment-container">
        <div class="header">
            <h1>Secure Payment</h1>
            <div class="payment-icons">
                <span>💳</span>
                <span>🔒</span>
                <span>🏦</span>
            </div>
        </div>

        <div class="order-summary">
            <h2>Order Summary</h2>
            <p>Plan: <strong><?php echo htmlspecialchars($plan_name); ?></strong></p>
            <p>Amount: <strong>RM <?php echo htmlspecialchars($plan_price); ?></strong></p>
        </div>

        <form class="payment-form" method="POST" action="" id="paymentForm">
            <input type="hidden" name="plan_name" value="<?php echo htmlspecialchars($plan_name); ?>">
            <input type="hidden" name="plan_price" value="<?php echo htmlspecialchars($plan_price); ?>">

            <div class="form-group">
                <label for="cardName">Cardholder Name</label>
                <input type="text" id="cardName" required placeholder="John Doe">
            </div>

            <div class="form-group">
                <label for="cardNumber">Card Number</label>
                <input type="text" id="cardNumber" required placeholder="1234 5678 9012 3456" maxlength="19">
            </div>

            <div class="card-info">
                <div class="form-group">
                    <label for="expiry">Expiry Date</label>
                    <input type="text" id="expiry" required placeholder="MM/YY" maxlength="5">
                </div>
                <div class="form-group">
                    <label for="cvv">CVV</label>
                    <input type="text" id="cvv" required placeholder="123" maxlength="3">
                </div>
            </div>

            <button type="submit" name="process_payment" id="payButton">Pay RM <?php echo htmlspecialchars($plan_price); ?></button>
        </form>

        <a href="../Tour/Tour.php" class="back-link">← Back to Tour Page</a>
    </div>

    <script>
        // Format card number input
        document.getElementById('cardNumber').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            value = value.replace(/(\d{4})(?=\d)/g, '$1 ');
            e.target.value = value;
        });

        // Format expiry date input
        document.getElementById('expiry').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length >= 2) {
                value = value.slice(0, 2) + '/' + value.slice(2);
            }
            e.target.value = value;
        });
    </script>
</body>

</html>