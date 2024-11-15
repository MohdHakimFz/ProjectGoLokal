<?php
session_start();
require_once 'config/config.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: ../../Login/login.php');
    exit();
}

$error = '';
$success = '';

try {
    // Fetch user data
    $user_id = $_SESSION['user_id'];
    $query = "SELECT profile_picture, name, role FROM users WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        header("Location: ../../Login/login.php");
        exit();
    }

    $user = $result->fetch_assoc();
    $profile_picture = $user['profile_picture'] ?? 'default.png';
    $user_name = $user['name'] ?? 'My Account';

    // Handle form submission
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $destination = trim($_POST['destination']);
        $rating = (int)$_POST['rating'];
        $review = trim($_POST['review']);

        if (empty($destination) || empty($review) || $rating < 1 || $rating > 5) {
            $error = "Please fill all fields correctly.";
        } else {
            $reviewStmt = $conn->prepare("INSERT INTO reviews (user_id, destination_name, rating, review_text, status) VALUES (?, ?, ?, ?, 'pending')");
            $reviewStmt->bind_param("isis", $user_id, $destination, $rating, $review);

            if ($reviewStmt->execute()) {
                $success = "Review submitted successfully! It will be visible after approval.";
            } else {
                $error = "Error submitting review. Please try again.";
            }
            $reviewStmt->close();
        }
    }
} catch (Exception $e) {
    error_log("Error in review_form.php: " . $e->getMessage());
    $error = "An error occurred. Please try again later.";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Write a Review - GoLokal</title>
    <link rel="icon" type="image/png" href="assets/image/GoLokal Logo.png">
    <link rel="stylesheet" href="assets/css/review-form.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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

    <main class="review-form-container fade-in-up">
        <h2>Write a Review</h2>

        <?php
        // Display error messages if any
        if (isset($errors) && !empty($errors)): ?>
            <div class="error-messages fade-in-up">
                <?php foreach ($errors as $error): ?>
                    <div class="error-message fade-in-up">
                        <i class="fas fa-exclamation-circle"></i>
                        <?php echo htmlspecialchars($error); ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php
        // Display success message if any
        if (isset($_SESSION['success_message'])): ?>
            <div class="success-message fade-in-up">
                <i class="fas fa-check-circle"></i>
                <?php
                echo htmlspecialchars($_SESSION['success_message']);
                unset($_SESSION['success_message']);
                ?>
            </div>
        <?php endif; ?>

        <form method="POST" class="review-form fade-in-up" id="reviewForm">
            <div class="form-group fade-in-up">
                <label for="destination">Destination Name <span class="required">*</span></label>
                <input type="text"
                    id="destination"
                    name="destination"
                    required
                    maxlength="100"
                    placeholder="Enter destination name"
                    value="<?php echo isset($_POST['destination']) ? htmlspecialchars($_POST['destination']) : ''; ?>"
                    class="form-control">
                <small class="form-text">Maximum 100 characters</small>
            </div>

            <div class="form-group fade-in-up">
                <label>Rating <span class="required">*</span></label>
                <div class="rating-input">
                    <?php
                    $selectedRating = isset($_POST['rating']) ? (int)$_POST['rating'] : 0;
                    for ($i = 5; $i >= 1; $i--):
                    ?>
                        <input type="radio"
                            id="star<?php echo $i; ?>"
                            name="rating"
                            value="<?php echo $i; ?>"
                            <?php echo ($selectedRating === $i) ? 'checked' : ''; ?>
                            required>
                        <label for="star<?php echo $i; ?>" title="<?php echo $i; ?> stars">★</label>
                    <?php endfor; ?>
                </div>
                <small class="form-text">Click to rate from 1 to 5 stars</small>
            </div>

            <div class="form-group fade-in-up">
                <label for="review">Your Review <span class="required">*</span></label>
                <textarea id="review"
                    name="review"
                    required
                    maxlength="1000"
                    placeholder="Share your experience..."
                    class="form-control"><?php echo isset($_POST['review']) ? htmlspecialchars($_POST['review']) : ''; ?></textarea>
                <small class="form-text">
                    <span id="charCount">0</span>/1000 characters
                </small>
            </div>

            <div class="form-actions fade-in-up">
                <button type="submit" class="submit-btn">
                    <i class="fas fa-paper-plane"></i> Submit Review
                </button>
            </div>
        </form>
    </main>

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

    <script src="assets/js/review-form.js"></script>
</body>

</html>
<?php
if (isset($conn)) {
    $conn->close();
}
?>