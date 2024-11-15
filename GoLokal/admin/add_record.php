<?php
session_start();
if (!isset($_SESSION['user_role']) || ($_SESSION['user_role'] != 'admin' && $_SESSION['user_role'] != 'staff')) {
    // Redirect non-admin/staff users to the login page
    header("Location: ../Login/login.html");
    exit;
}

// Include the database connection file
include 'config/config.php';

// Fetch user data from the session or database based on user ID
$user_id = $_SESSION['user_id']; // Assuming user_id is stored in the session

// Prepare a query to fetch user information from the database
$query = "SELECT name, profile_picture FROM users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Check if user data was found
if ($user) {
    $user_name = $user['name'];  // Fetch the user's name
    $profile_picture = $user['profile_picture'];  // Fetch the user's profile picture
} else {
    $user_name = 'User';  // Default to 'User' if no name is found
    $profile_picture = 'default_profile.png';  // Fallback profile picture
}

// Set profile picture path
$profile_picture_path = "../uploads/" . htmlspecialchars($profile_picture);

// Check if profile picture exists, else use default
if (!file_exists($profile_picture_path) || !is_file($profile_picture_path)) {
    $profile_picture_path = "../uploads/default_profile.png"; // Default image
}

// Handle the form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $challenge_points = trim($_POST['challenge_points']);
    $plan_name = trim($_POST['plan_name']);
    $user_id = $_POST['user_id']; // This is selected from the dropdown by admin
    $proof_submission_date = date('Y-m-d H:i:s'); // Current date and time
    $proof_status = 'pending'; // Default status for user submission

    // Prepare and execute the insert query for a new challenge
    $query = "INSERT INTO challenges (title, description, challenge_points, proof_submission_date, proof_status, plan_name, user_id)
              VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssisssi", $title, $description, $challenge_points, $proof_submission_date, $proof_status, $plan_name, $user_id);

    if ($stmt->execute()) {
        echo "<script>alert('Challenge assigned successfully.'); window.location.href = 'admin_dashboard.php';</script>";
    } else {
        echo "<script>alert('Error assigning challenge: " . $stmt->error . "'); window.history.back();</script>";
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Assign Challenge</title>
    <link rel="stylesheet" href="assets/css/add_record.css">
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
            </div>

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
    </header>

    <main>
        <h1>Assign New Challenge</h1>
        <form action="add_record.php" method="POST">
            <!-- Form fields here -->
            <label for="title">Title:</label>
            <input type="text" name="title" required>

            <label for="description">Description:</label>
            <textarea name="description" required></textarea>

            <label for="challenge_points">Challenge Points:</label>
            <input type="number" name="challenge_points" required>

            <label for="plan_name">Plan Name:</label>
            <input type="text" name="plan_name" required>

            <label for="user_id">Assign to User:</label>
            <select name="user_id" required>
                <?php
                // Fetch all users to assign the challenge
                $user_query = "SELECT id, name FROM users";
                $user_result = $conn->query($user_query);
                while ($row = $user_result->fetch_assoc()) {
                    echo "<option value='{$row['id']}'>{$row['name']}</option>";
                }
                ?>
            </select>

            <button type="submit">Assign Challenge</button>
        </form>

        <a href="admin_dashboard.php" class="back-to-dashboard">Back to Dashboard</a>
    </main>

    <script src="assets/js/add_record.js"></script>

</body>

</html>