<?php
session_start();
include('config/config.php');

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "<p style='color: red;'>Error: User is not logged in.</p>";
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch user points from the database securely
$query = "SELECT points FROM users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows === 0) {
    echo "<p style='color: red;'>Error: User not found.</p>";
    exit();
}
$user = $result->fetch_assoc();
$points = $user['points'];
$stmt->close();

// Define available items for redemption with proper commas
$items = [
    ["id" => 1, "name" => "Gift Card RM15", "points" => 1000, "img" => "assets/image/Redeem Gift/Spotify Card.jpg"],
    ["id" => 2, "name" => "Wireless Earbuds", "points" => 25000, "img" => "assets/image/Redeem Gift/Wireless Earbuds.png"],
    ["id" => 3, "name" => "Smartwatch", "points" => 500000, "img" => "assets/image/Redeem Gift/Smartwatch.png"],
    ["id" => 4, "name" => "Gaming Console", "points" => 15000, "img" => "assets/image/Redeem Gift/Gaming Console.webp"],
    ["id" => 5, "name" => "Bluetooth Speaker", "points" => 35000, "img" => "assets/image/Redeem Gift/Bluetooth Speaker.png"],
    ["id" => 6, "name" => "Wireless Charger", "points" => 10000, "img" => "assets/image/Redeem Gift/Wireless Charger.png"],
    ["id" => 7, "name" => "Portable Charger", "points" => 12000, "img" => "assets/image/Redeem Gift/Portable Charger.webp"],
    ["id" => 8, "name" => "Wireless Mouse", "points" => 8000, "img" => "assets/image/Redeem Gift/Wireless Mouse.png"],
    ["id" => 9, "name" => "Wireless Keyboard", "points" => 18000, "img" => "assets/image/Redeem Gift/Wireless Keyboard.png"],
    ["id" => 10, "name" => "Monitor", "points" => 15700, "img" => "assets/image/Redeem Gift/Monitor.png"],
    ["id" => 11, "name" => "Mouse Pad", "points" => 5000, "img" => "assets/image/Redeem Gift/Mousepad.png"],
    ["id" => 12, "name" => "Mystery Car", "points" => 100000, "img" => "assets/image/Redeem Gift/Mystery Car.png"],
    ["id" => 13, "name" => "Gaming PC", "points" => 10000, "img" => "assets/image/Redeem Gift/Gaming PC.webp"],
    ["id" => 14, "name" => "Gaming Chair", "points" => 50000, "img" => "assets/image/Redeem Gift/Gaming Chair.png"]
];

// Handle redemption logic
if (isset($_POST['redeem_item'])) {
    $item_id = $_POST['item_id'];
    $item_points = $_POST['item_points'];
    $item_name = $_POST['item_name'];

    if ($points >= $item_points) {
        // Deduct points securely using prepared statement
        $new_points = $points - $item_points;
        $update_points_query = "UPDATE users SET points = ? WHERE id = ?";
        $stmt = $conn->prepare($update_points_query);
        $stmt->bind_param("ii", $new_points, $user_id);

        if ($stmt->execute()) {
            // Successful redemption
            $message = "You have successfully redeemed $item_name!";
            $points = $new_points; // Update points for display
        } else {
            $message = "Error redeeming item: " . $stmt->error;
        }
        $stmt->close();
    } else {
        $message = "You don't have enough points to redeem this item.";
    }
}

// Fetch user data for display
$query = "SELECT profile_picture, name, role FROM users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    header("Location: ../../Login/login.html");
    exit();
}

$user = $result->fetch_assoc();
$profile_picture = $user['profile_picture'] ?? 'default.png';
$user_name = $user['name'] ?? 'My Account';
$user_role = $user['role'] ?? 'user';

$profile_picture_path = "../../uploads/" . htmlspecialchars($profile_picture);
if (!file_exists($profile_picture_path) || exif_imagetype($profile_picture_path) === false) {
    $profile_picture_path = "../../uploads/default.png";
}

$stmt->close();
$conn->close(); // Close the database connection
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Redeem Points</title>
    <link rel="stylesheet" href="assets/css/redeem.css">
    <link rel="icon" type="image/png" href="assets/image/GoLokal Logo.png">
</head>

<body>

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
                        <a href="edit_profile.php">Account Settings</a>
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

    <div class="redeem-container">
        <h1>Redeem Items</h1>
        <p>You currently have <strong><?php echo $points; ?></strong> points.</p>

        <?php if (isset($message)) echo "<p class='message'>$message</p>"; ?>

        <div class="items-grid">
            <?php foreach ($items as $item) { ?>
                <div class="item">
                    <img src="<?php echo htmlspecialchars($item['img']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>">
                    <h3><?php echo htmlspecialchars($item['name']); ?></h3>
                    <p>Points: <?php echo htmlspecialchars($item['points']); ?></p>
                    <form action="confirmation.php" method="post">
                        <input type="hidden" name="item_id" value="<?php echo htmlspecialchars($item['id']); ?>">
                        <input type="hidden" name="item_points" value="<?php echo htmlspecialchars($item['points']); ?>">
                        <input type="hidden" name="item_name" value="<?php echo htmlspecialchars($item['name']); ?>">
                        <button type="submit" name="redeem_item" class="redeem-btn">Redeem</button>
                    </form>
                </div>
            <?php } ?>
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

        <!-- Back to Home Button -->
        <a href="../welcome.php" class="back-home-button">Back to Home</a>
    </div>

    <script src="assets/js/redeem.js"></script>

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

</body>

</html>