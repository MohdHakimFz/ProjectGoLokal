<?php
session_start();
include('config/config.php');

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: ../../Login/login.html'); // Redirect to login page if user is not logged in
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch user transactions from the database
$sql = "SELECT * FROM receipts WHERE payment_id IN (SELECT id FROM payments WHERE user_id = ?) ORDER BY receipt_date DESC";
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    die("Error preparing statement: " . $conn->error);
}

$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();
$transactions = [];

while ($row = $result->fetch_assoc()) {
    $transactions[] = $row;
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
$profile_picture = $user['profile_picture'] ?? 'default.png';
$user_name = $user['name'] ?? 'My Account';

$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Your Transactions</title>
    <link rel="stylesheet" href="assets/css/transaction.css">
    <link rel="icon" type="image/png" href="assets/image/GoLokal Logo.png">
</head>

<!-- Header Section -->
<header>
    <div class="container">
        <div class="logo">
            <!-- GoLokal Logo -->
            <a href="../welcome.php">
                <img src="assets/image/GoLokal_try.png" alt="GoLokal Logo">
            </a>
            <nav class="nav-menu" id="navMenu">
                <ul>
                    <li><a href="../welcome.php">Home</a></li>
                    <li><a href="../state/explore.php">Explore</a></li>
                    <li><a href="../Learn/Learn.php">Learn</a></li>
                    <li><a href="../Tour/Tour.php">Tour</a></li>
                    <li><a href="../review/all_reviews.php">Reviews</a></li>
                    <li><a href="../Events/events.php">Events</a></li>
                </ul>
            </nav>

            <!-- user dropdown menu -->
            <div class="user-dropdown">
                <div class="user-image-container">
                    <img src="../../uploads/<?php echo htmlspecialchars($profile_picture); ?>" alt="User Image" id="profile-picture">
                    <p><?php echo htmlspecialchars($user_name); ?></p>
                </div>
                <button class="dropdown-toggle" id="dropdownToggle">
                    <span class="dropdown-arrow">▼</span>
                </button>

                <div class="dropdown-menu" id="dropdownMenu">
                    <a href="../Account Settings/edit_profile.php">Account Settings</a>
                    <a href="../Account Settings/Transaction.php">Transactions</a>
                    <a href="../Account Settings/Earn.php">Earn</a>
                    <a href="../Account Settings/Redeem.php">Redeem</a>
                    <a href="../Account Settings/redemption_status.php">Redemption Status</a>
                    <a href="../Account Settings/review_form.php">Form Reviews</a>
                    <a href="../Account Settings/weather.php">Weather</a>
                    <a href="../../LogOut/logout.php">Logout</a>
                </div>
            </div>
        </div>
    </div>
</header>

<body>
    <div class="transaction-container">
        <h1>Your Transactions</h1>
        <div class="sort-container">
            <label for="sortSelect">Sort By:</label>
            <select id="sortSelect">
                <option value="latest">Latest</option>
                <option value="oldest">Oldest</option>
            </select>
        </div>
        <div id="transactionsList">
            <?php foreach ($transactions as $transaction) { ?>
                <div class="transaction-card" data-date="<?php echo strtotime($transaction['receipt_date']); ?>">
                    <div class="transaction-header">
                        <h2>Receipt #GL<?php echo str_pad($transaction['id'], 5, '0', STR_PAD_LEFT); ?></h2>
                        <span class="transaction-date"><?php echo date('F j, Y, g:i A', strtotime($transaction['receipt_date'])); ?></span>
                    </div>
                    <div class="transaction-details">
                        <p>Plan: <strong><?php echo htmlspecialchars(json_decode($transaction['receipt_details'])->plan_name); ?></strong></p>
                        <p>Total Amount: <strong>RM <?php echo number_format($transaction['total_amount'], 2); ?></strong></p>
                        <p>Points Earned: <strong><?php echo htmlspecialchars(json_decode($transaction['receipt_details'])->points_earned); ?></strong></p>
                    </div>
                    <button class="print-button" onclick="printReceipt(this)">
                        <img src="assets/image/print.png" alt="Print" width="15" height="15">
                        Print Receipt
                    </button>
                </div>
            <?php } ?>
        </div>
        <a href="../Tour/Tour.php" class="back-link">← Back to Tour Page</a>
    </div>

    <!-- Chatbot Section -->
    <div id="chatbot-container" class="chatbot-container">
        <div class="chat-header">
            <h4>GoLokal Assistant</h4>
            <button id="minimize-chat">−</button>
        </div>
        <div id="chat-messages" class="chat-messages">
            <div class="bot-message">Hi! I'm your GoLokal assistant. How can I help you today?</div>
        </div>
        <div class="chat-input">
            <input type="text" id="user-input" placeholder="Type your message...">
            <button id="send-message">Send</button>
        </div>
    </div>

    <!-- Chatbot Toggle Button -->
    <button id="chat-toggle" class="chat-toggle">
        <img src="assets/image/Chat.png" alt="Chat" width="30" height="30">
    </button>

    <!-- Footer -->
    <footer>
        <div class="footer-content">
            <h3>Follow Us on</h3>
            <ul class="socials">
                <li><a href="https://github.com/MohdHakimFz"><img src="assets/image/github.png" alt="GitHub"></a></li>
                <li><a href="https://www.instagram.com/_.hkimfz"><img src="assets/image/instagram (1).png" alt="Instagram"></a></li>
                <li><a href="https://wa.me/+601162299601"><img src="assets/image/Whatsapp (1).png" alt="WhatsApp"></a></li>
            </ul>
        </div>
        <p>&copy; 2024 GoLokal. All Rights Reserved.</p>
    </footer>

    <script src="assets/js/transaction.js"></script>
</body>

</html>