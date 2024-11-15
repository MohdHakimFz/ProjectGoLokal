<?php
session_start();
require_once 'config/config.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../../Login/login.html");
    exit();
}

// Pagination settings
$eventsPerPage = 12;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $eventsPerPage;

// Filter settings
$stateFilter = isset($_GET['state']) ? $_GET['state'] : '';
$monthFilter = isset($_GET['month']) ? $_GET['month'] : '';

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
    $user_role = $user['role'] ?? 'user';

    // Profile picture handling
    $profile_picture_path = "../../uploads/" . htmlspecialchars($profile_picture);
    if (!file_exists($profile_picture_path) || !is_file($profile_picture_path)) {
        $profile_picture_path = "../../uploads/default.png";
    }

    // Get total number of events with filters
    $countQuery = "SELECT COUNT(*) as total FROM events WHERE 1=1";
    $countParams = [];
    $countTypes = "";

    if ($stateFilter) {
        $countQuery .= " AND location LIKE ?";
        $countParams[] = "%$stateFilter%";
        $countTypes .= "s";
    }
    if ($monthFilter) {
        $countQuery .= " AND MONTH(event_date) = ?";
        $countParams[] = $monthFilter;
        $countTypes .= "i";
    }

    $countStmt = $conn->prepare($countQuery);
    if (!empty($countParams)) {
        $countStmt->bind_param($countTypes, ...$countParams);
    }
    $countStmt->execute();
    $totalEvents = $countStmt->get_result()->fetch_assoc()['total'];
    $totalPages = ceil($totalEvents / $eventsPerPage);

    // Fetch events with filters
    $eventQuery = "SELECT * FROM events WHERE 1=1";
    $eventParams = [];
    $eventTypes = "";

    if ($stateFilter) {
        $eventQuery .= " AND location LIKE ?";
        $eventParams[] = "%$stateFilter%";
        $eventTypes .= "s";
    }
    if ($monthFilter) {
        $eventQuery .= " AND MONTH(event_date) = ?";
        $eventParams[] = $monthFilter;
        $eventTypes .= "i";
    }

    $eventQuery .= " ORDER BY event_date ASC LIMIT ? OFFSET ?";
    $eventParams[] = $eventsPerPage;
    $eventParams[] = $offset;
    $eventTypes .= "ii";

    $eventStmt = $conn->prepare($eventQuery);
    if (!empty($eventParams)) {
        $eventStmt->bind_param($eventTypes, ...$eventParams);
    }
    $eventStmt->execute();
    $events = $eventStmt->get_result();

    // Start HTML output
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Events & Festivals - GoLokal</title>
        <link rel="icon" type="image/png" href="assets/image/GoLokal Logo.png">
        <link rel="stylesheet" href="assets/css/events.css">
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

        <div class="events-page">
            <div class="hero-section">
                <h1>Events & Festivals</h1>
                <p>Discover the vibrant celebrations and cultural events across Malaysia</p>
            </div>

            <!-- Calendar and Filters Section -->
            <div class="calendar-filters-section">
                <!-- Calendar View -->
                <div class="calendar-wrapper">
                    <div class="calendar-header">
                        <button id="prevMonth"><i class="fas fa-chevron-left"></i></button>
                        <h2 id="currentMonth"></h2>
                        <button id="nextMonth"><i class="fas fa-chevron-right"></i></button>
                    </div>
                    <div class="calendar-weekdays">
                        <div>Sun</div>
                        <div>Mon</div>
                        <div>Tue</div>
                        <div>Wed</div>
                        <div>Thu</div>
                        <div>Fri</div>
                        <div>Sat</div>
                    </div>
                    <div class="calendar-days" id="calendarDays"></div>
                </div>

                <!-- Filters -->
                <div class="filters-section">
                    <form class="filters-form" method="GET">
                        <select name="state" id="stateFilter">
                            <option value="">All States</option>
                            <option value="All States" <?php echo $stateFilter === 'All States' ? 'selected' : ''; ?>>National Events</option>
                            <option value="Johor" <?php echo $stateFilter === 'Johor' ? 'selected' : ''; ?>>Johor</option>
                            <option value="Kedah" <?php echo $stateFilter === 'Kedah' ? 'selected' : ''; ?>>Kedah</option>
                            <option value="Kelantan" <?php echo $stateFilter === 'Kelantan' ? 'selected' : ''; ?>>Kelantan</option>
                            <option value="Melaka" <?php echo $stateFilter === 'Melaka' ? 'selected' : ''; ?>>Melaka</option>
                            <option value="Negeri Sembilan" <?php echo $stateFilter === 'Negeri Sembilan' ? 'selected' : ''; ?>>Negeri Sembilan</option>
                            <option value="Pahang" <?php echo $stateFilter === 'Pahang' ? 'selected' : ''; ?>>Pahang</option>
                            <option value="Penang" <?php echo $stateFilter === 'Penang' ? 'selected' : ''; ?>>Penang</option>
                            <option value="Perak" <?php echo $stateFilter === 'Perak' ? 'selected' : ''; ?>>Perak</option>
                            <option value="Perlis" <?php echo $stateFilter === 'Perlis' ? 'selected' : ''; ?>>Perlis</option>
                            <option value="Sabah" <?php echo $stateFilter === 'Sabah' ? 'selected' : ''; ?>>Sabah</option>
                            <option value="Sarawak" <?php echo $stateFilter === 'Sarawak' ? 'selected' : ''; ?>>Sarawak</option>
                            <option value="Selangor" <?php echo $stateFilter === 'Selangor' ? 'selected' : ''; ?>>Selangor</option>
                            <option value="Terengganu" <?php echo $stateFilter === 'Terengganu' ? 'selected' : ''; ?>>Terengganu</option>
                            <option value="Kuala Lumpur" <?php echo $stateFilter === 'Kuala Lumpur' ? 'selected' : ''; ?>>Kuala Lumpur</option>
                            <option value="Putrajaya" <?php echo $stateFilter === 'Putrajaya' ? 'selected' : ''; ?>>Putrajaya</option>
                            <option value="Labuan" <?php echo $stateFilter === 'Labuan' ? 'selected' : ''; ?>>Labuan</option>
                        </select>
                        <select name="category" id="categoryFilter">
                            <option value="">All Categories</option>
                            <option value="Public Holiday">Public Holidays</option>
                            <option value="Cultural">Cultural Festivals</option>
                            <option value="Food">Food Events</option>
                            <option value="Arts">Arts & Music</option>
                            <option value="Sports">Sports Events</option>
                            <option value="Traditional">Traditional Events</option>
                        </select>
                        <button type="submit">Apply Filter</button>
                    </form>
                </div>
            </div>

            <!-- Events Grid -->
            <div class="events-grid">
                <?php while ($event = $events->fetch_assoc()): ?>
                    <div class="event-card" data-date="<?php echo $event['event_date']; ?>"
                        data-state="<?php echo htmlspecialchars($event['location']); ?>">
                        <?php if (!empty($event['image_path'])): ?>
                            <div class="event-image">
                                <img src="<?php echo htmlspecialchars($event['image_path']); ?>"
                                    alt="<?php echo htmlspecialchars($event['event_name']); ?>">
                            </div>
                        <?php endif; ?>

                        <div class="event-content">
                            <div class="event-date">
                                <span class="month"><?php echo date('M', strtotime($event['event_date'])); ?></span>
                                <span class="day"><?php echo date('d', strtotime($event['event_date'])); ?></span>
                            </div>

                            <div class="event-details">
                                <h3><?php echo htmlspecialchars($event['event_name']); ?></h3>
                                <p class="location">
                                    <i class="fas fa-map-marker-alt"></i>
                                    <?php echo htmlspecialchars($event['location']); ?>
                                </p>
                                <p class="description"><?php echo htmlspecialchars($event['description']); ?></p>
                                <a href="event_details.php?id=<?php echo $event['id']; ?>" class="learn-more">Learn More</a>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>

            <!-- Pagination -->
            <?php if ($totalPages > 1): ?>
                <div class="pagination">
                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <a href="?page=<?php echo $i; ?>&state=<?php echo urlencode($stateFilter); ?>&month=<?php echo urlencode($monthFilter); ?>"
                            class="<?php echo $page === $i ? 'active' : ''; ?>">
                            <?php echo $i; ?>
                        </a>
                    <?php endfor; ?>
                </div>
            <?php endif; ?>
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




        <script src="assets/js/events.js"></script>
    </body>

    </html>
<?php
} catch (Exception $e) {
    error_log("Error in events.php: " . $e->getMessage());
    header("Location: error.php");
    exit();
} finally {
    // Close all statements and connection
    if (isset($stmt)) $stmt->close();
    if (isset($countStmt)) $countStmt->close();
    if (isset($eventStmt)) $eventStmt->close();
    if (isset($conn)) $conn->close();
}
?>