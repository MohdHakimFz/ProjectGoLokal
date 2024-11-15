<?php
session_start();
require 'config/config.php';

// Check if user is admin
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] != 'admin') {
    header("Location: ../Login/login.html");
    exit;
}

// Fetch user data from the database based on the user_id stored in the session
$user_id = $_SESSION['user_id'];
$query = "SELECT profile_picture, name, role FROM users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Profile picture handling
$profile_picture = $user['profile_picture'] ?? 'default.png';
$user_name = $user['name'] ?? 'Admin';
$profile_picture_path = "../uploads/" . htmlspecialchars($profile_picture);

if (!file_exists($profile_picture_path) || exif_imagetype($profile_picture_path) === false) {
    $profile_picture_path = "../uploads/default.png";
}

// Pagination
$reviews_per_page = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $reviews_per_page;

// Get total reviews count
$count_query = "SELECT COUNT(*) as total FROM reviews WHERE status = 'pending'";
$total_result = $conn->query($count_query);
$total_reviews = $total_result->fetch_assoc()['total'];
$total_pages = ceil($total_reviews / $reviews_per_page);

// Fetch reviews
$reviews_query = "SELECT r.*, u.name, u.profile_picture 
                 FROM reviews r 
                 JOIN users u ON r.user_id = u.id 
                 WHERE r.status = 'pending' 
                 ORDER BY r.created_at DESC 
                 LIMIT ? OFFSET ?";
$stmt = $conn->prepare($reviews_query);
$stmt->bind_param("ii", $reviews_per_page, $offset);
$stmt->execute();
$reviews = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Review Approval | Admin Dashboard</title>
    <link rel="stylesheet" href="assets/css/review_approve.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="icon" type="image/png" href="assets/image/GoLokal Logo.png">
</head>

<body>

    <!-- Header Section -->
    <header>
        <div class="container">
            <div class="logo">
                <a href="../admin/admin_dashboard.php">
                    <img src="assets/image/GoLokal_try.png" alt="GoLokal Logo">
                </a>

                <!-- User Dropdown Menu -->
                <div class="user-dropdown">
                    <div class="user-image-container">
                        <img src="<?php echo $profile_picture_path; ?>" alt="Profile Picture of <?php echo htmlspecialchars($user_name); ?>" id="profile-picture">
                        <p><?php echo htmlspecialchars($user_name); ?></p>
                    </div>
                    <button class="dropdown-toggle" id="dropdownToggle">
                        <span class="dropdown-arrow">▼</span>
                    </button>

                    <div class="dropdown-menu" id="dropdownMenu">
                        <a href="../admin/edit_admin.php">Account Settings</a>
                        <a href="../LogOut/logout.php">Logout</a>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <main>
        <div class="container">
            <div class="page-header">
                <a href="../admin/admin_dashboard.php" class="back-button">
                    Back to Dashboard
                </a>
                <div class="stats">
                    <div class="stat-item">
                        <i class="fas fa-clock"></i>
                        <span>Pending Reviews: <?php echo $total_reviews; ?></span>
                    </div>
                </div>
            </div>

            <div class="reviews-container">
                <?php if ($reviews->num_rows > 0): ?>
                    <?php while ($review = $reviews->fetch_assoc()): ?>
                        <div class="review-card" data-review-id="<?php echo $review['id']; ?>">
                            <div class="reviewer-info">
                                <img src="../uploads/<?php echo htmlspecialchars($review['profile_picture']); ?>"
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

                                <!-- Add approve/reject buttons -->
                                <div class="review-actions">
                                    <button class="approve-btn" onclick="handleReview(<?php echo $review['id']; ?>, 'approve')">
                                        <i class="fas fa-check"></i> Approve
                                    </button>
                                    <button class="reject-btn" onclick="handleReview(<?php echo $review['id']; ?>, 'reject')">
                                        <i class="fas fa-times"></i> Reject
                                    </button>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>

                    <?php if ($total_pages > 1): ?>
                        <div class="pagination">
                            <?php if ($page > 1): ?>
                                <a href="?page=<?php echo ($page - 1); ?>" class="page-link">
                                    <i class="fas fa-chevron-left"></i> Previous
                                </a>
                            <?php endif; ?>

                            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                                <a href="?page=<?php echo $i; ?>"
                                    class="page-link <?php echo $i === $page ? 'active' : ''; ?>">
                                    <?php echo $i; ?>
                                </a>
                            <?php endfor; ?>

                            <?php if ($page < $total_pages): ?>
                                <a href="?page=<?php echo ($page + 1); ?>" class="page-link">
                                    Next <i class="fas fa-chevron-right"></i>
                                </a>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                <?php else: ?>
                    <div class="no-reviews">
                        <i class="fas fa-check-circle"></i>
                        <h2>All Caught Up!</h2>
                        <p>There are no pending reviews to approve at the moment.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </main>

    <script src="assets/js/review_approve.js"></script>
    <script>
    </script>
</body>

</html>

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