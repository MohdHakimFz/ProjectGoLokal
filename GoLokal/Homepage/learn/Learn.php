<?php
session_start();
require 'config/config.php'; // Include your database connection file

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../../Login/login.html"); // Redirect to login if not logged in
    exit();
}

// Fetch user data from the database based on the user_id stored in the session
$user_id = $_SESSION['user_id'];
$query = "SELECT profile_picture, name, role FROM users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    // Handle case where user is not found
    header("Location: ../../Login/login.html"); // Redirect to login
    exit();
}

$user = $result->fetch_assoc();

// Default to 'default.png' if no profile picture is set
$profile_picture = $user['profile_picture'] ?? 'default.png';
$user_name = $user['name'] ?? 'My Account';
$user_role = $user['role'] ?? 'user'; // Get the user role

// Construct the full path for the profile picture
$profile_picture_path = "../../uploads/" . htmlspecialchars($profile_picture);

// Check if the profile picture file exists and is a valid image
if (!file_exists($profile_picture_path) || exif_imagetype($profile_picture_path) === false) {
    $profile_picture_path = "../../uploads/default.png"; // Fallback to default image if not found or invalid image
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Explore Malaysia - GoLokal</title>
    <link rel="stylesheet" href="assets/css/learn.css">
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
                        <li><a href="../learn/Learn.php">Learn</a></li>
                        <li><a href="../Tour/Tour.php">Tour</a></li>
                        <li><a href="../Review/all_reviews.php">Reviews</a></li>
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
                        <a href="../Account Settings/Edit_profile.php">Account Settings</a>
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

    <div class="container">
        <!-- Sidebar Section -->
        <div class="sidebar">
            <h2>State Flags of Malaysia</h2>
            <ul class="flag-list">
                <li class="flag-item active" data-state="Johor">
                    <img src="assets/image/Johor/Flag Johor.png" alt="Johor Flag">
                    <span>Johor</span>
                </li>
                <li class="flag-item" data-state="Kedah">
                    <img src="assets/image/Kedah/Flag Kedah.png" alt="Kedah Flag">
                    <span>Kedah</span>
                </li>
                <li class="flag-item" data-state="Kelantan">
                    <img src="assets/image/Kelantan/Flag Kelantan.png" alt="Kelantan Flag">
                    <span>Kelantan</span>
                </li>
                <li class="flag-item" data-state="Melaka">
                    <img src="assets/image/Melaka/Flag Melaka.png" alt="MelakaFlag">
                    <span>Melaka</span>
                </li>
                <li class="flag-item" data-state="Negeri Sembilan">
                    <img src="assets/image/Negeri Sembilan/Flag Negeri Sembilan.png" alt="Negeri Sembilan Flag">
                    <span>Negeri Sembilan</span>
                </li>
                <li class="flag-item" data-state="Pahang">
                    <img src="assets/image/Pahang/Flag Pahang.png" alt="Pahang Flag">
                    <span>Pahang</span>
                </li>
                <li class="flag-item" data-state="Penang">
                    <img src="assets/image/Pulau Pinang/Penang Flag.png" alt="Penang Flag">
                    <span>Penang</span>
                </li>
                <li class="flag-item" data-state="Perak">
                    <img src="assets/image/Perak/Flag Perak.png" alt="Perak Flag">
                    <span>Perak</span>
                </li>
                <li class="flag-item" data-state="Perlis">
                    <img src="assets/image/Perlis/Flag Perlis.png" alt="Perlis Flag">
                    <span>Perlis</span>
                </li>
                <li class="flag-item" data-state="Sabah">
                    <img src="assets/image/Sabah/Flag Sabah.png" alt="Sabah Flag">
                    <span>Sabah</span>
                </li>
                <li class="flag-item" data-state="Sarawak">
                    <img src="assets/image/Sarawak/Flag Sarawak.png" alt="Sarawak Flag">
                    <span>Sarawak</span>
                </li>
                <li class="flag-item" data-state="Selangor">
                    <img src="assets/image/Selangor/Flag Selangor.png" alt="Selangor Flag">
                    <span>Selangor</span>
                </li>
                <li class="flag-item" data-state="Terengganu">
                    <img src="assets/image/Terengganu/Flag Terengganu.png" alt="Terengganu Flag">
                    <span>Terengganu</span>
                </li>
            </ul>
        </div>

        <!-- Main Content Section -->
        <div class="main-content">
            <h2>State Language Dictionary</h2>
            <div class="dictionary">
                <p>Select a state to view the language dictionary.</p>
            </div>
        </div>
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

    <script src="assets/js/learn.js"></script>
</body>

</html>