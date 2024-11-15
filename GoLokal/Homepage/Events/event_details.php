<?php
session_start();
require_once 'config/config.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../../Login/login.html");
    exit();
}

// Check if event ID is provided
if (!isset($_GET['id'])) {
    header("Location:../Events/events.php");
    exit();
}

try {
    // Fetch user data
    $user_id = $_SESSION['user_id'];
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

    // Fetch event details
    $event_id = $_GET['id'];
    $event_query = "SELECT * FROM events WHERE id = ?";
    $event_stmt = $conn->prepare($event_query);
    $event_stmt->bind_param("i", $event_id);
    $event_stmt->execute();
    $event_result = $event_stmt->get_result();

    if ($event_result->num_rows === 0) {
        header("Location: ../Events/events.php");
        exit();
    }

    $event = $event_result->fetch_assoc();
?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo htmlspecialchars($event['event_name']); ?> - GoLokal</title>
        <link rel="stylesheet" href="assets/css/events.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
        <style>
            .event-details-container {
                max-width: 1200px;
                margin: 2rem auto;
                padding: 2rem;
                background: #fff;
                border-radius: 10px;
                box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            }

            .event-header {
                display: flex;
                gap: 2rem;
                margin-bottom: 2rem;
            }

            .event-image {
                flex: 0 0 50%;
                max-height: 400px;
                overflow: hidden;
                border-radius: 10px;
            }

            .event-image img {
                width: 100%;
                height: 100%;
                object-fit: cover;
            }

            .event-info {
                flex: 1;
            }

            .event-meta {
                display: flex;
                gap: 1rem;
                margin: 1rem 0;
                color: #666;
            }

            .event-meta i {
                width: 20px;
            }

            .event-description {
                margin: 2rem 0;
                line-height: 1.6;
            }

            .back-button {
                display: inline-block;
                padding: 0.8rem 1.5rem;
                background: #007bff;
                color: white;
                text-decoration: none;
                border-radius: 5px;
                margin-top: 1rem;
                transition: background 0.3s;
            }

            .back-button:hover {
                background: #0056b3;
            }
        </style>
    </head>

    <body>
        <!-- Header Section -->
        <header>
            <div class="container">
                <div class="logo">
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

                    <!-- User dropdown menu -->
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

        <!-- Event Details Content -->
        <div class="event-details-container">
            <div class="event-header">
                <div class="event-image">
                    <?php if (!empty($event['image_path'])): ?>
                        <img src="<?php echo htmlspecialchars($event['image_path']); ?>"
                            alt="<?php echo htmlspecialchars($event['event_name']); ?>">
                    <?php else: ?>
                        <img src="assets/image/default-event.jpg" alt="Default Event Image">
                    <?php endif; ?>
                </div>
                <div class="event-info">
                    <h1><?php echo htmlspecialchars($event['event_name']); ?></h1>

                    <div class="event-meta">
                        <i class="fas fa-calendar"></i>
                        <span><?php echo date('F d, Y', strtotime($event['event_date'])); ?></span>
                    </div>

                    <div class="event-meta">
                        <i class="fas fa-map-marker-alt"></i>
                        <span><?php echo htmlspecialchars($event['location']); ?></span>
                    </div>

                    <?php if (!empty($event['time'])): ?>
                        <div class="event-meta">
                            <i class="fas fa-clock"></i>
                            <span><?php echo htmlspecialchars($event['time']); ?></span>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="event-description">
                <h2>About This Event</h2>
                <p><?php echo nl2br(htmlspecialchars($event['description'])); ?></p>
            </div>

            <a href="events.php" class="back-button">
                <i class="fas fa-arrow-left"></i> Back to Events
            </a>
        </div>

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

        <script>
            // Dropdown menu functionality
            document.addEventListener('DOMContentLoaded', function() {
                const dropdownToggle = document.getElementById('dropdownToggle');
                const dropdownMenu = document.getElementById('dropdownMenu');

                dropdownToggle.addEventListener('click', function() {
                    dropdownMenu.style.display =
                        dropdownMenu.style.display === 'block' ? 'none' : 'block';
                });

                // Close dropdown when clicking outside
                document.addEventListener('click', function(event) {
                    if (!event.target.closest('.user-dropdown')) {
                        dropdownMenu.style.display = 'none';
                    }
                });
            });
        </script>
    </body>

    </html>

<?php
} catch (Exception $e) {
    error_log("Error in event_details.php: " . $e->getMessage());
    header("Location: error.php");
    exit();
} finally {
    if (isset($stmt)) $stmt->close();
    if (isset($event_stmt)) $event_stmt->close();
    if (isset($conn)) $conn->close();
}
?>