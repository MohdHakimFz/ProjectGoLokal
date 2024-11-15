<?php
session_start();
require 'config/config.php'; // Include the database connection


// Check if the user is logged in and has the appropriate role
if (!isset($_SESSION['user_role']) || ($_SESSION['user_role'] != 'admin' && $_SESSION['user_role'] != 'staff')) {
    header("Location: ../Login/login.html");
    exit;
}

// Fetch user data from the database based on the user_id stored in the session
$user_id = $_SESSION['user_id'];
$query = "SELECT profile_picture, name FROM users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Default to 'default.png' if no profile picture is set
$profile_picture = isset($user['profile_picture']) ? $user['profile_picture'] : 'default.png';
$user_name = isset($user['name']) ? $user['name'] : 'My Account';

// Construct the full path for the profile picture
$profile_picture_path = "../uploads/" . htmlspecialchars($profile_picture);

// Check if the profile picture file exists and is a valid image
if (!file_exists($profile_picture_path) || exif_imagetype($profile_picture_path) === false) {
    $profile_picture_path = "../uploads/default.png"; // Fallback to default image if not found or invalid image
}

// Fetch dynamic stats from the database

// Get total challenges
$challenges_query = "SELECT COUNT(*) as total_challenges FROM challenges";
$challenges_result = $conn->query($challenges_query);
$total_challenges = $challenges_result->fetch_assoc()['total_challenges'];

// Get total completed payments
$completed_payments_query = "SELECT COUNT(*) as completed_payments FROM payments WHERE payment_status = 'Successful'";
$completed_payments_result = $conn->query($completed_payments_query);
$completed_payments = $completed_payments_result->fetch_assoc()['completed_payments'];

// Get total users
$total_users_query = "SELECT COUNT(*) as total_users FROM users";
$total_users_result = $conn->query($total_users_query);
$total_users = $total_users_result->fetch_assoc()['total_users'];

$stmt->close();
$conn->close(); // Close the database connection
?>

<!DOCTYPE html>
<html lang="en">
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Dashboard | GoLokal Malaysia</title>
<link rel="stylesheet" href="assets/css/admin.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
<link rel="icon" type="image/png" href="assets/image/GoLokal Logo.png">

<head>
    <!-- Meta and CSS includes -->
</head>

<body>
    <!-- Header Section -->
    <header>
        <div class="container">
            <div class="logo">
                <a href="admin_dashboard.php">
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

    <!-- Main Section -->
    <main>
        <h1>Admin Dashboard</h1>
        <div class="dashboard-container">
            <nav>
                <!-- Sidebar Navigation -->
                <h2>Navigation</h2>
                <ul class="dashboard-nav">
                    <div class="navigation">
                        <a href="add_record.php"><i class="fas fa-plus-circle"></i>Add Record</a>
                        <a href="select_user.php"><i class="fas fa-user-bill"></i>Update Record</a>
                        <a href="view_record.php"><i class="fas fa-eye"></i>View Records</a>
                        <a href="search_record.php"><i class="fas fa-search"></i>Search Records</a>
                        <a href="redeem_status.php"><i class="fas fa-gift"></i>Redeem Records</a>
                        <a href="review_approve.php"><i class="fas fa-check"></i>Review & Approve</a>
                    </div>
                </ul>
            </nav>

            <section class="dashboard-stats">
                <h2>Quick Stats</h2>
                <div class="stats-grid">
                    <div class="stat-card">
                        <h3>Total Challenges</h3>
                        <p><?php echo $total_challenges; ?></p>
                    </div>
                    <div class="stat-card">
                        <h3>Completed Payments</h3>
                        <p><?php echo $completed_payments; ?></p>
                    </div>
                    <div class="stat-card">
                        <h3>Total Users</h3>
                        <p><?php echo $total_users; ?></p>
                    </div>
                </div>
            </section>
        </div>
    </main>


    <!-- Footer and Scripts -->
    <script src="assets/js/admin.js"></script>
    </script>
</body>

</html>