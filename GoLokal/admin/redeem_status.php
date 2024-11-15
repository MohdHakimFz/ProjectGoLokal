<?php
session_start();
include('config/config.php');

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
    $profile_picture_path = "uploads/default.png"; // Fallback to default image if not found or invalid image
}


// Fetch all redemption requests from the database
$query = "SELECT r.id, r.item_name, r.name, r.address, r.phone, r.email, r.redemption_status, r.redemption_date, u.points, u.name AS user_name 
          FROM redemptions r
          JOIN users u ON r.user_id = u.id
          ORDER BY r.redemption_date DESC";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Redemption Status</title>
    <link rel="stylesheet" href="assets/css/redeem_status.css">
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

    <div class="status-container">
        <h1>Manage Redemption Status</h1>

        <?php if ($result->num_rows > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Item</th>
                        <th>Points</th>
                        <th>Shipping Address</th>
                        <th>Status</th>
                        <th>Redemption Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['user_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['item_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['points']); ?></td>
                            <td><?php echo htmlspecialchars($row['address']); ?></td>
                            <td>
                                <form action="../admin/update_status.php" method="post">
                                    <input type="hidden" name="redemption_id" value="<?php echo $row['id']; ?>">
                                    <select name="redemption_status">
                                        <option value="Pending" <?php if ($row['redemption_status'] == 'Pending') echo 'selected'; ?>>Pending</option>
                                        <option value="Completed" <?php if ($row['redemption_status'] == 'Completed') echo 'selected'; ?>>Completed</option>
                                        <option value="Cancelled" <?php if ($row['redemption_status'] == 'Cancelled') echo 'selected'; ?>>Cancelled</option>
                                    </select>
                            </td>
                            <td><?php echo date("F j, Y, g:i a", strtotime($row['redemption_date'])); ?></td>
                            <td>
                                <button type="submit" class="update-btn">Update</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No redemption requests found.</p>
        <?php endif; ?>

        <a href="../admin/admin_dashboard.php" class="back-dashboard-button">Back to Dashboard</a>
    </div>
    <script src="assets/js/redeem_status.js"></script>
</body>

</html>