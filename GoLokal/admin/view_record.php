<?php
session_start();
if (!isset($_SESSION['user_role']) || ($_SESSION['user_role'] != 'admin' && $_SESSION['user_role'] != 'staff')) {
    header("Location: ../Login/login.html");
    exit;
}

// Include the database connection file
include 'config/config.php';

// Fetch user data from the session
if (!isset($_SESSION['user_id'])) {
    header("Location: ../Login/login.html");
    exit;
}

$user_id = $_SESSION['user_id'];

// Prepare a query to fetch user information from the database
$query = "SELECT name, profile_picture FROM users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Check if user data was found
if ($user) {
    $user_name = htmlspecialchars($user['name']);  // Fetch the user's name safely
    $profile_picture = htmlspecialchars($user['profile_picture']);  // Fetch the user's profile picture safely
} else {
    $user_name = 'User';  // Default to 'User' if no name is found
    $profile_picture = 'default_profile.png';  // Fallback profile picture
}

// Set profile picture path
$profile_picture_path = "../uploads/" . $profile_picture;

// Check if profile picture exists, else use default
if (!file_exists($profile_picture_path) || !is_file($profile_picture_path)) {
    $profile_picture_path = "../uploads/default_profile.png"; // Default image
}

// Fetch records from the challenges table with user details
$query = "SELECT c.*, u.username FROM challenges c JOIN users u ON c.user_id = u.id";
$result = $conn->query($query);

if (!$result) {
    die("Error fetching records: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="assets/css/view_record.css">
    <link rel="icon" type="image/png" href="assets/image/GoLokal Logo.png">
    <title>View Records</title>
</head>

<!-- Header Section -->
<header>
    <div class="container">
        <div class="logo">
            <a href="../admin/admin_dashboard.php">
                <img src="assets/image/GoLokal_try.png" alt="GoLokal Logo">
            </a>
        </div>

        <!-- User Dropdown Menu -->
        <div class="user-dropdown">
            <div class="user-image-container">
                <img src="<?php echo $profile_picture_path; ?>" alt="Profile Picture of <?php echo $user_name; ?>" id="profile-picture">
                <p><?php echo $user_name; ?></p>
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
</header>

<body>
    <h1>View Challenges Records</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>User ID</th>
                <th>Username</th>
                <th>Title</th>
                <th>Description</th>
                <th>Points</th>
                <th>Proof Image</th>
                <th>Submission Date</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['user_id']; ?></td>
                        <td><?php echo htmlspecialchars($row['username']); ?></td>
                        <td><?php echo htmlspecialchars($row['title']); ?></td>
                        <td><?php echo htmlspecialchars($row['description']); ?></td>
                        <td><?php echo $row['challenge_points']; ?></td>
                        <?php
                        $proof_image_path = htmlspecialchars($row['proof_image_path']);
                        if (!file_exists($proof_image_path) || !is_file($proof_image_path)) {
                            $proof_image_path = "../uploads/default_image.png"; // Fallback image
                        }
                        ?>
                        <td><img src="<?php echo $proof_image_path; ?>" alt="Proof" width="100"></td>
                        <td><?php echo $row['proof_submission_date']; ?></td>
                        <td><?php echo $row['proof_status']; ?></td>
                        <td class="actions">
                            <button class="approve-btn" data-id="<?php echo $row['id']; ?>">Approve</button>
                            <button class="delete-btn" data-id="<?php echo $row['id']; ?>">Delete</button>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="10">No records found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <<div class="back-to-dashboard-container">
        <a href="../admin/admin_dashboard.php" class="back-to-dashboard">Back to Dashboard</a>
        </div>


        <script src="assets/js/view_record.js"></script>
</body>

</html>

<?php
$conn->close();
?>