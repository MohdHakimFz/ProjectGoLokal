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
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Explore Malaysia - GoLokal</title>
    <link rel="stylesheet" href="assets/css/explore.css">
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

    <!-- Search and Filter Section -->
    <section class="search-filter-section">
        <input type="text" id="search-bar" placeholder="Search for a state..." onkeyup="searchStates()" />
        <select id="state-filter" onchange="filterStates()">
            <option value="all">All Categories</option>
            <option value="beaches">Beaches</option>
            <option value="history">Historical Sites</option>
            <option value="nature">Nature & Adventure</option>
            <option value="food">Food & Culture</option>
        </select>
    </section>

    <!-- Main Content Section -->
    <section class="explore-section">
        <h1>Choose a State in Malaysia</h1>
        <div class="state-grid" id="stateGrid">
            <!-- Johor -->
            <div class="state-card" data-category="beaches nature">
                <img src="assets/image/Johor/Johor Istana Bukit Serene.jpg" alt="Johor">
                <h3>Johor</h3>
                <p>Famous for its beaches, royal palaces, and theme parks like Legoland.</p>
                <p>10 Vacations</p>
                <a href="johor.php" class="learn-more-btn">Learn More</a>
            </div>

            <!-- Kedah -->
            <div class="state-card" data-category="nature">
                <img src="assets/image/Kedah/Kedah.jpg" alt="Kedah">
                <h3>Kedah</h3>
                <p>The rice bowl of Malaysia with beautiful paddy fields and Langkawi Island.</p>
                <p>10 Vacations</p>
                <a href="kedah.php" class="learn-more-btn">Learn More</a>
            </div>

            <!-- Kelantan -->
            <div class="state-card" data-category="culture history">
                <img src="assets/image/Kelantan/Kelantan.jpg" alt="Kelantan">
                <h3>Kelantan</h3>
                <p>Known for its strong Malay culture, traditional crafts, and Islamic heritage.</p>
                <p>10 Vacations</p>
                <a href="kelantan.php" class="learn-more-btn">Learn More</a>
            </div>

            <!-- Melaka -->
            <div class="state-card" data-category="history culture">
                <img src="assets/image/Melaka/Melaka.jpg" alt="Melaka">
                <h3>Melaka</h3>
                <p>Rich in historical sites, from A Famosa to the Dutch Square.</p>
                <p>10 Vacations</p>
                <a href="Melaka.php" class="learn-more-btn">Learn More</a>
            </div>

            <!-- Negeri Sembilan -->
            <div class="state-card" data-category="culture nature">
                <img src="assets/image/Negeri Sembilan/Negeri Sembilan.jpg" alt="Negeri Sembilan">
                <h3>Negeri Sembilan</h3>
                <p>Known for its traditional Minangkabau architecture and serene landscapes.</p>
                <p>10 Vacations</p>
                <a href="NegeriSembilan.php" class="learn-more-btn">Learn More</a>
            </div>

            <!-- Pahang -->
            <div class="state-card" data-category="nature beaches">
                <img src="assets/image/Pahang/Pahang.jpg" alt="Pahang">
                <h3>Pahang</h3>
                <p>Home to Taman Negara, Malaysia's largest national park, and beautiful beaches.</p>
                <p>10 Vacations</p>
                <a href="Pahang.php" class="learn-more-btn">Learn More</a>
            </div>

            <!-- Perak -->
            <div class="state-card" data-category="history nature">
                <img src="assets/image/Perak/Perak.jpg" alt="Perak">
                <h3>Perak</h3>
                <p>Known for its caves, temples, and historic towns like Ipoh.</p>
                <p>10 Vacations</p>
                <a href="Perak.php" class="learn-more-btn">Learn More</a>
            </div>

            <!-- Perlis -->
            <div class="state-card" data-category="nature">
                <img src="assets/image/Perlis/Perlis.jpg" alt="Perlis">
                <h3>Perlis</h3>
                <p>A small state with a big heart, known for its peaceful countryside.</p>
                <p>10 Vacations</p>
                <a href="Perlis.php" class="learn-more-btn">Learn More</a>
            </div>

            <!-- Penang -->
            <div class="state-card" data-category="food culture history">
                <img src="assets/image/Pulau Pinang/Pulau Pinang Penang Hill.jpg" alt="Penang">
                <h3>Penang</h3>
                <p>Famous for its street food, George Town’s heritage, and Penang Hill.</p>
                <p>10 Vacations</p>
                <a href="Penang.php" class="learn-more-btn">Learn More</a>
            </div>

            <!-- Sabah -->
            <div class="state-card" data-category="nature beaches">
                <img src="assets/image/Sabah/Sabah.jpg" alt="Sabah">
                <h3>Sabah</h3>
                <p>A paradise for nature lovers with Mount Kinabalu and amazing diving spots.</p>
                <p>10 Vacations</p>
                <a href="Sabah.php" class="learn-more-btn">Learn More</a>
            </div>

            <!-- Sarawak -->
            <div class="state-card" data-category="nature culture">
                <img src="assets/image/Sarawak/Sarawak.jpg" alt="Sarawak">
                <h3>Sarawak</h3>
                <p>Explore the wonders of Borneo with rainforests, caves, and tribal cultures.</p>
                <p>10 Vacations</p>
                <a href="Sarawak.php" class="learn-more-btn">Learn More</a>
            </div>

            <!-- Selangor -->
            <div class="state-card" data-category="culture history">
                <img src="assets/image/Selangor/Selangor.jpeg" alt="Selangor">
                <h3>Selangor</h3>
                <p>Malaysia's most populous state, home to Kuala Lumpur and Batu Caves.</p>
                <p>10 Vacations</p>
                <a href="Selangor.php" class="learn-more-btn">Learn More</a>
            </div>

            <!-- Terengganu -->
            <div class="state-card" data-category="beaches nature">
                <img src="assets/image/Terengganu/Terengganu.jpg" alt="Terengganu">
                <h3>Terengganu</h3>
                <p>Famous for its islands like Redang and Perhentian, and rich cultural heritage.</p>
                <p>10 Vacations</p>
                <a href="Terengganu.php" class="learn-more-btn">Learn More</a>
            </div>
        </div>
    </section>

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
    <script src="assets/js/explore.js"></script>
</body>

</html>