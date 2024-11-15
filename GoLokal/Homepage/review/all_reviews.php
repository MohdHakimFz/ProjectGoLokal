<?php
session_start();
require_once 'config/config.php';

// Pagination settings
$reviewsPerPage = 9;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $reviewsPerPage;

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

// Close the statement
$stmt->close();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Reviews - GoLokal</title>
    <link rel="icon" type="image/png" href="assets/image/GoLokal Logo.png">
    <link rel="stylesheet" href="assets/css/reviews.css">
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
                        <a href="../Account Settings//review_form.php">Form Reviews</a>
                        <a href="../Account Settings/weather.php">Weather</a>
                        <a href="../../LogOut/logout.php">Logout</a>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div class="all-reviews-page">
        <div class="hero-section">
            <h1>Traveler Reviews</h1>
            <p>Discover what others are saying about their GoLokal experiences</p>
        </div>

        <div class="reviews-container">
            <div class="loading" id="loading" style="display: none;">
                <i class="fas fa-spinner fa-spin"></i> Loading reviews...
            </div>

            <?php
            try {
                // Get total number of approved reviews
                $countQuery = "SELECT COUNT(*) as total FROM reviews WHERE status = 'approved'";
                $totalReviews = $conn->query($countQuery)->fetch_assoc()['total'];
                $totalPages = ceil($totalReviews / $reviewsPerPage);

                // Get reviews for current page
                $query = "SELECT r.*, u.name, u.profile_picture 
                         FROM reviews r 
                         JOIN users u ON r.user_id = u.id 
                         WHERE r.status = 'approved' 
                         OR (r.status = 'pending' AND r.user_id = ?) 
                         ORDER BY r.created_at DESC 
                         LIMIT ? OFFSET ?";

                if ($stmt = $conn->prepare($query)) {
                    $stmt->bind_param("iii", $user_id, $reviewsPerPage, $offset);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows > 0) {
                        echo '<div class="reviews-grid">';
                        while ($review = $result->fetch_assoc()) {
                            // Add a class to identify the user's own reviews
                            $isUserReview = ($review['user_id'] == $user_id);
                            $reviewStatus = $review['status'];

                            // Fix profile picture path
                            $reviewProfilePic = 'assets/image/default-avatar.png'; // Default image
                            if (!empty($review['profile_picture'])) {
                                $picturePath = '../../uploads/' . htmlspecialchars($review['profile_picture']);
                                if (file_exists($picturePath)) {
                                    $reviewProfilePic = $picturePath;
                                }
                            }
            ?>
                            <div class="review-card <?php echo $isUserReview ? 'user-review' : ''; ?>">
                                <?php if ($isUserReview): ?>
                                    <div class="your-review-badge">
                                        <?php echo ucfirst($reviewStatus); ?>
                                    </div>
                                <?php endif; ?>

                                <div class="reviewer-info">
                                    <img src="<?php echo $reviewProfilePic; ?>"
                                        alt="<?php echo htmlspecialchars($review['name']); ?>"
                                        class="reviewer-image"
                                        onerror="this.src='assets/image/default-avatar.png'">
                                    <div class="reviewer-details">
                                        <h4><?php echo htmlspecialchars($review['name']); ?></h4>
                                        <p class="destination">
                                            <i class="fas fa-map-marker-alt"></i>
                                            <?php echo htmlspecialchars($review['destination_name']); ?>
                                        </p>
                                    </div>
                                </div>

                                <div class="rating">
                                    <?php
                                    $rating = (int)$review['rating'];
                                    for ($i = 1; $i <= 5; $i++) {
                                        echo '<span class="star ' . ($i <= $rating ? 'filled' : '') . '">★</span>';
                                    }
                                    ?>
                                </div>

                                <p class="review-text"><?php echo htmlspecialchars($review['review_text']); ?></p>

                                <div class="review-footer">
                                    <span class="review-date">
                                        <i class="far fa-calendar-alt"></i>
                                        <?php echo date('M d, Y', strtotime($review['created_at'])); ?>
                                    </span>
                                    <?php if ($isUserReview && $reviewStatus === 'pending'): ?>
                                        <span class="pending-notice">
                                            <i class="fas fa-clock"></i> Pending Approval
                                        </span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php
                        }
                        echo '</div>';

                        // Pagination
                        if ($totalPages > 1) {
                        ?>
                            <div class="pagination">
                                <?php if ($page > 1): ?>
                                    <a href="?page=<?php echo ($page - 1); ?>" class="prev">Previous</a>
                                <?php endif; ?>

                                <?php
                                for ($i = 1; $i <= $totalPages; $i++) {
                                    if ($i == $page) {
                                        echo "<span class='current'>$i</span>";
                                    } else {
                                        echo "<a href='?page=$i'>$i</a>";
                                    }
                                }
                                ?>

                                <?php if ($page < $totalPages): ?>
                                    <a href="?page=<?php echo ($page + 1); ?>" class="next">Next</a>
                                <?php endif; ?>
                            </div>
                <?php
                        }
                    } else {
                        echo '<div class="no-reviews">No reviews available yet.</div>';
                    }
                    $stmt->close();
                }
            } catch (Exception $e) {
                error_log("Error in reviews page: " . $e->getMessage());
                ?>
                <div class="error">
                    <i class="fas fa-exclamation-circle"></i>
                    <p>Unable to load reviews at this time. Please try again later.</p>
                    <button onclick="window.location.reload()">Retry</button>
                </div>
            <?php
            } finally {
                // Close the connection here
                if (isset($conn)) {
                    $conn->close();
                }
            }
            ?>
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

    <script src="assets/js/all_review.js"></script>
</body>

</html>