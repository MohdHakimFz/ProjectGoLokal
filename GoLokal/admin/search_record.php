<?php
session_start();
if (!isset($_SESSION['user_role']) || ($_SESSION['user_role'] != 'admin' && $_SESSION['user_role'] != 'staff')) {
    header("Location: ../Login/login.html");
    exit;
}

// Include the database connection file
include 'config/config.php';

// Initialize variables
$search_title = '';
$search_user_id = '';
$search_results = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $search_title = trim($_POST['title']);
    $search_user_id = trim($_POST['user_id']);

    // Prepare the search query
    $query = "SELECT c.*, u.username FROM challenges c JOIN users u ON c.user_id = u.id WHERE 1=1";

    if (!empty($search_title)) {
        $query .= " AND c.title LIKE ?";
    }
    if (!empty($search_user_id)) {
        $query .= " AND c.user_id = ?";
    }

    $stmt = $conn->prepare($query);

    // Bind parameters
    $params = [];
    if (!empty($search_title)) {
        $params[] = '%' . $search_title . '%';
    }
    if (!empty($search_user_id)) {
        $params[] = $search_user_id;
    }

    if ($params) {
        $types = str_repeat('s', count($params)); // assuming all params are strings
        $stmt->bind_param($types, ...$params);
    }

    $stmt->execute();
    $result = $stmt->get_result();
    $search_results = $result->fetch_all(MYSQLI_ASSOC);
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

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="assets/css/search_record.css">
    <link rel="icon" type="image/png" href="assets/image/GoLokal Logo.png">
    <title>Search Records</title>
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
                <a href="../edit_admin.php">Account Settings</a>
                <a href="../LogOut/logout.php">Logout</a>
            </div>
        </div>
    </div>
</header>

<body>
    <h1>Search Challenge Records</h1>
    <form action="../admin/search_record.php" method="POST">
        <label for="title">Title:</label>
        <input type="text" name="title" value="<?php echo htmlspecialchars($search_title); ?>">

        <label for="user_id">User ID:</label>
        <input type="text" name="user_id" value="<?php echo htmlspecialchars($search_user_id); ?>">

        <button type="submit">Search</button>
    </form>

    <?php if (!empty($search_results)): ?>
        <h2>Search Results</h2>
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
                </tr>
            </thead>
            <tbody>
                <?php foreach ($search_results as $row): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['user_id']; ?></td>
                        <td><?php echo $row['username']; ?></td>
                        <td><?php echo $row['title']; ?></td>
                        <td><?php echo $row['description']; ?></td>
                        <td><?php echo $row['challenge_points']; ?></td>
                        <td><img src="<?php echo $row['proof_image_path']; ?>" alt="Proof" width="100"></td>
                        <td><?php echo $row['proof_submission_date']; ?></td>
                        <td><?php echo $row['proof_status']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php elseif ($_SERVER["REQUEST_METHOD"] == "POST"): ?>
        <p>No records found.</p>
    <?php endif; ?>

    <div class="back-to-dashboard-container">
        <a href="../admin/admin_dashboard.php" class="back-to-dashboard">Back to Dashboard</a>
    </div>
</body>

</html>
<script src="assets/js/search_record.js"></script>
<?php
$conn->close();
?>