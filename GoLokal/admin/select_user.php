<?php
session_start();
if (!isset($_SESSION['user_role']) || ($_SESSION['user_role'] != 'admin' && $_SESSION['user_role'] != 'staff')) {
    header("Location: ../Login/login.html");
    exit;
}

include 'config/config.php';

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
    <title>Select User</title>
    <link rel="stylesheet" href="assets/css/select_user.css">
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

    <h1>Select User to Update Challenges</h1>
    <form action="../admin/view_challenges.php" method="GET">
        <label for="user_id">Choose a User:</label>
        <select name="user_id" required>
            <?php while ($row = $user_result->fetch_assoc()): ?>
                <option value="<?php echo $row['id']; ?>"><?php echo htmlspecialchars($row['name']); ?></option>
            <?php endwhile; ?>
        </select>
        <button type="submit">View Challenges</button>
    </form>

    <!-- Footer and Scripts -->
    <script src="assets/js/admin.js"></script>
    </script>
</body>

</html>