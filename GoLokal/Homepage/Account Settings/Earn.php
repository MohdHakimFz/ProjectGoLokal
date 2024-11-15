<?php
session_start();
include('config/config.php');

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../../Login/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Check if the connection is alive
function checkConnection($conn)
{
    if (!mysqli_ping($conn)) {
        mysqli_close($conn);
        include('config/config.php'); // Reconnect to the database
    }
}

// Call connection check before running any queries
checkConnection($conn);

// Fetch user points and profile data from the database
$query = "SELECT points, profile_picture, name FROM users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc(); // Fetch the user's data including points
} else {
    // Default to 0 points if there's an issue fetching
    $user['points'] = 0;
    echo "<p style='color: red;'>Error fetching user data. Defaulting to 0 points.</p>";
}

// Fetch available challenges linked to the user
$challenges_query = "SELECT * FROM challenges WHERE proof_status = 'pending' AND user_id = ?";
$challenges_stmt = $conn->prepare($challenges_query);
$challenges_stmt->bind_param("i", $user_id);
$challenges_stmt->execute();
$challenges_result = $challenges_stmt->get_result();

// Fetch points earned through payments
$payments_query = "SELECT * FROM payments WHERE user_id = ? AND payment_status = 'Successful'";
$payments_stmt = $conn->prepare($payments_query);
$payments_stmt->bind_param("i", $user_id);
$payments_stmt->execute();
$payments_result = $payments_stmt->get_result();

// Handle challenge completion (when a user submits proof)
if (isset($_POST['submit_proof'])) {
    $challenge_id = $_POST['challenge_id'];
    $points_earned = $_POST['points_earned'];

    // Handle the file upload for proof submission
    if (isset($_FILES['proof']) && $_FILES['proof']['error'] == UPLOAD_ERR_OK) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["proof"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Validate file type (only allow jpg, jpeg, png, and gif)
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
        if (!in_array($imageFileType, $allowed_extensions)) {
            echo "<script>alert('Only JPG, JPEG, PNG & GIF files are allowed.'); window.history.back();</script>";
            exit();
        }

        // Move the uploaded file
        if (move_uploaded_file($_FILES["proof"]["tmp_name"], $target_file)) {
            // File successfully uploaded, now update the challenge record
            $update_challenge_query = "UPDATE challenges SET proof_image_path=?, proof_status='completed', proof_submission_date=NOW() WHERE id=?";
            $update_stmt = $conn->prepare($update_challenge_query);
            $update_stmt->bind_param("si", $target_file, $challenge_id);
            if ($update_stmt->execute()) {
                // Update user's points
                $new_points = $user['points'] + $points_earned;
                $update_points_query = "UPDATE users SET points=? WHERE id=?";
                $points_stmt = $conn->prepare($update_points_query);
                $points_stmt->bind_param("ii", $new_points, $user_id);
                $points_stmt->execute();

                // Re-fetch updated points
                $user['points'] = $new_points;
                echo "<p class='message success'>Challenge completed, proof uploaded, and $points_earned points earned!</p>";
            } else {
                echo "<p class='message error'>Error updating challenge: " . $update_stmt->error . "</p>";
            }
        } else {
            echo "<script>alert('Sorry, there was an error uploading your file.'); window.history.back();</script>";
            exit();
        }
    } else {
        echo "<script>alert('No file was uploaded or an error occurred.'); window.history.back();</script>";
        exit();
    }
}

// Default to 'default.png' if no profile picture is set
$profile_picture = $user['profile_picture'] ?? 'default.png';
$user_name = $user['name'] ?? 'My Account';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Earn Points</title>
    <link rel="stylesheet" href="assets/css/earn.css">
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
                    <a href="../review/review_form.php">Form Reviews</a>
                    <a href="../Account Settings/weather.php">Weather</a>
                    <a href="../../LogOut/logout.php">Logout</a>
                </div>
            </div>
        </div>
    </div>
</header>

<body>
    <div class="earn-container fade-in">
        <h1>Earn Points</h1>
        <p class="earn-text">You currently have <strong><?php echo isset($user['points']) ? htmlspecialchars($user['points']) : 0; ?></strong> points.</p>


        <h2>Complete Challenges to Earn Points:</h2>
        <ul>
            <?php while ($challenge = $challenges_result->fetch_assoc()) { ?>
                <li class="fade-in">
                    <h3><?php echo htmlspecialchars($challenge['title']); ?></h3>
                    <p><?php echo htmlspecialchars($challenge['description']); ?></p>
                    <p>Points: <strong><?php echo htmlspecialchars($challenge['challenge_points']); ?></strong></p>
                    <form action="earn.php" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="challenge_id" value="<?php echo htmlspecialchars($challenge['id']); ?>">
                        <input type="hidden" name="points_earned" value="<?php echo htmlspecialchars($challenge['challenge_points']); ?>">
                        <label for="proof">Submit Proof (Image):</label>
                        <input type="file" name="proof" required>
                        <button type="submit" name="submit_proof">Submit Proof</button>
                    </form>
                </li>
            <?php } ?>
        </ul>

        <h2>Points Earned from Payments:</h2>
        <ul>
            <?php while ($payment = $payments_result->fetch_assoc()) { ?>
                <li class="fade-in">
                    <p>Plan: <?php echo htmlspecialchars($payment['plan_name']); ?> | Points Earned: <?php echo htmlspecialchars($payment['points_earned']); ?> | Payment Date: <?php echo htmlspecialchars($payment['payment_date']); ?></p>
                </li>
            <?php } ?>
        </ul>

        <!-- Back to Home Button -->
        <a href="../welcome.php" class="back-home-button">Back to Home</a>

        <script src="assets/js/earn.js"></script>
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
</body>

</html>