<?php
session_start();
require 'config/config.php'; // Include your database connection file

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location:../../Login/login.html"); // Redirect to login if not logged in
    exit();
}

// Array of states and their corresponding plans with best prices
$states = [
    "Johor" => [
        ["name" => "Top Attractions", "price" => 1200],
        ["name" => "Cultural Heritage", "price" => 1100],
        ["name" => "Adventure", "price" => 1300],
    ],
    "Kedah" => [
        ["name" => "Top Attractions", "price" => 1150],
        ["name" => "Cultural Heritage", "price" => 1050],
        ["name" => "Adventure", "price" => 1250],
    ],
    "Kelantan" => [
        ["name" => "Top Attractions", "price" => 1100],
        ["name" => "Cultural Heritage", "price" => 1000],
        ["name" => "Adventure", "price" => 1200],
    ],
    "Melaka" => [
        ["name" => "Top Attractions", "price" => 1250],
        ["name" => "Cultural Heritage", "price" => 1150],
        ["name" => "Adventure", "price" => 1350],
    ],
    "Negeri Sembilan" => [
        ["name" => "Top Attractions", "price" => 1300],
        ["name" => "Cultural Heritage", "price" => 1200],
        ["name" => "Adventure", "price" => 1400],
    ],
    "Pahang" => [
        ["name" => "Top Attractions", "price" => 1350],
        ["name" => "Cultural Heritage", "price" => 1250],
        ["name" => "Adventure", "price" => 1450],
    ],
    "Perak" => [
        ["name" => "Top Attractions", "price" => 1300],
        ["name" => "Cultural Heritage", "price" => 1200],
        ["name" => "Adventure", "price" => 1400],
    ],
    "Perlis" => [
        ["name" => "Top Attractions", "price" => 1150],
        ["name" => "Cultural Heritage", "price" => 1050],
        ["name" => "Adventure", "price" => 1250],
    ],
    "Penang" => [
        ["name" => "Top Attractions", "price" => 1400],
        ["name" => "Cultural Heritage", "price" => 1300],
        ["name" => "Adventure", "price" => 1500],
    ],
    "Sabah" => [
        ["name" => "Top Attractions", "price" => 1800],  // Includes flight
        ["name" => "Cultural Heritage", "price" => 1700], // Includes flight
        ["name" => "Adventure", "price" => 1900],         // Includes flight
    ],
    "Sarawak" => [
        ["name" => "Top Attractions", "price" => 1850],  // Includes flight
        ["name" => "Cultural Heritage", "price" => 1750], // Includes flight
        ["name" => "Adventure", "price" => 1950],         // Includes flight
    ],
    "Selangor" => [
        ["name" => "Top Attractions", "price" => 1250],
        ["name" => "Cultural Heritage", "price" => 1150],
        ["name" => "Adventure", "price" => 1350],
    ],
    "Terengganu" => [
        ["name" => "Top Attractions", "price" => 1200],
        ["name" => "Cultural Heritage", "price" => 1100],
        ["name" => "Adventure", "price" => 1300],
    ],
];



// Handle state selection and plan details
$selected_state = isset($_POST['state']) ? $_POST['state'] : '';
$selected_plans = $selected_state ? $states[$selected_state] : [];

// Store the selected plan in the session when booking
if (isset($_POST['book_now']) && isset($_POST['plan_name']) && isset($_POST['plan_price'])) {
    $_SESSION['selected_plan'] = [
        'name' => $_POST['plan_name'],
        'price' => $_POST['plan_price'],
        'state' => $_POST['state']
    ];
    header('Location: payment.php'); // Redirect to payment page
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
    <link rel="stylesheet" href="assets/css/tour.css">
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
                        <a href="../Review/review_form.php">Form Reviews</a>
                        <a href="../Weather/weather.php">Weather</a>
                        <a href="../../LogOut/logout.php">Logout</a>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- State Selection Form -->
    <h1>Select a State for Your Tour</h1>
    <form method="POST" action="">
        <label for="state">Choose a state:</label>
        <select name="state" id="state">
            <option value="">Select a state</option>
            <?php foreach ($states as $state => $plans) { ?>
                <option value="<?php echo $state; ?>" <?php if ($state == $selected_state) echo 'selected'; ?>>
                    <?php echo $state; ?>
                </option>
            <?php } ?>
        </select>
        <button type="submit">View Plans</button>
    </form>

    <!-- Display Selected Plans and Best Price -->
    <?php if ($selected_plans) { ?>
        <div class="tour-plans-container">
            <h2>Tour Package for <?php echo htmlspecialchars($selected_state); ?></h2>
            <div class="plans-container">
                <?php foreach ($selected_plans as $plan) { ?>
                    <div class="plan">
                        <h3><?php echo htmlspecialchars($plan['name']); ?></h3>
                        <p>3 days, 2 nights</p>
                        <p>Price: RM <?php echo htmlspecialchars($plan['price']); ?></p>

                        <!-- Button Container -->
                        <div class="button-container">
                            <!-- Preview Journey Button -->
                            <a href="journey.php?plan_name=<?php echo urlencode($plan['name']); ?>&state=<?php echo urlencode($selected_state); ?>">
                                <button type="button" class="preview-btn">Preview Journey</button>
                            </a>

                            <!-- Book Now Button (redirect to payment.php) -->
                            <form method="POST" action="payment.php">
                                <input type="hidden" name="plan_name" value="<?php echo htmlspecialchars($plan['name']); ?>">
                                <input type="hidden" name="plan_price" value="<?php echo htmlspecialchars($plan['price']); ?>">
                                <input type="hidden" name="state" value="<?php echo htmlspecialchars($selected_state); ?>">
                                <button type="submit" class="book-btn">Book Now</button>
                            </form>
                        </div>
                    </div>
                <?php } ?>
            </div> <!-- Close plans-container -->
        <?php } ?>

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

        <script src="assets/js/tour.js"></script>
</body>

</html>