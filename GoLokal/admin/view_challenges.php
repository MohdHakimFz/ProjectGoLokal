<?php
session_start();
if (!isset($_SESSION['user_role']) || ($_SESSION['user_role'] != 'admin' && $_SESSION['user_role'] != 'staff')) {
    header("Location: ../Login/login.html");
    exit;
}

include 'config/config.php';

if (!isset($_GET['user_id'])) {
    echo "<script>alert('No user selected.'); window.location.href = '../admin/select_user.php';</script>";
    exit;
}

$user_id = intval($_GET['user_id']);

// Fetch user name
$user_query = "SELECT name FROM users WHERE id = ?";
$stmt = $conn->prepare($user_query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user_result = $stmt->get_result();
$user = $user_result->fetch_assoc();

// Fetch all challenges for the selected user
$challenge_query = "SELECT id, title, description, challenge_points, plan_name FROM challenges WHERE user_id = ?";
$stmt = $conn->prepare($challenge_query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$challenge_result = $stmt->get_result();

// Fetch all users
$user_query = "SELECT id, name FROM users";
$user_result = $conn->query($user_query);

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
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Challenges for <?php echo htmlspecialchars($user['name']); ?></title>
    <link rel="stylesheet" href="assets/css/view_challenge.css">
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

    <!-- Main Content -->
    <main>
        <h1>Edit Challenges for User</h1>
        <div class="challenge-list">
            <?php if ($challenge_result->num_rows > 0): ?>
                <?php while ($challenge = $challenge_result->fetch_assoc()): ?>
                    <div class="challenge-card">
                        <h2><?php echo htmlspecialchars($challenge['title']); ?></h2>
                        <p><strong>Description:</strong> <?php echo htmlspecialchars($challenge['description']); ?></p>
                        <p><strong>Points:</strong> <?php echo htmlspecialchars($challenge['challenge_points']); ?></p>
                        <p><strong>Plan:</strong> <?php echo htmlspecialchars($challenge['plan_name']); ?></p>
                        <a href="../admin/update_challenge.php?challenge_id=<?php echo $challenge['id']; ?>" class="edit-button">Edit Challenge</a>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>No challenges assigned to this user.</p>
            <?php endif; ?>
        </div>
        <a href="../admin/select_user.php" class="back-button">Back to Select User</a>
    </main>

    <!-- Footer and Scripts -->
    <script src="assets/js/admin.js"></script>
    </script>

</body>

</html>