<?php
session_start();
if (!isset($_SESSION['user_role']) || ($_SESSION['user_role'] != 'admin' && $_SESSION['user_role'] != 'staff')) {
    header("Location: ../Login/login.html");
    exit;
}

include 'config/config.php';

if (!isset($_GET['challenge_id'])) {
    echo "<script>alert('No challenge selected.'); window.location.href = 'select_user.php';</script>";
    exit;
}

$challenge_id = intval($_GET['challenge_id']);

// Fetch challenge data for pre-filling the form
$query = "SELECT * FROM challenges WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $challenge_id);
$stmt->execute();
$result = $stmt->get_result();
$challenge = $result->fetch_assoc();

if (!$challenge) {
    echo "<script>alert('Challenge not found.'); window.location.href = '../admin/view_challenges.php?user_id={$user_id}';</script>";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $challenge_points = trim($_POST['challenge_points']);
    $plan_name = trim($_POST['plan_name']);

    // Update the challenge
    $query = "UPDATE challenges SET title = ?, description = ?, challenge_points = ?, plan_name = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssisi", $title, $description, $challenge_points, $plan_name, $challenge_id);

    if ($stmt->execute()) {
        // Redirect to admin_dashboard.php after successful update
        echo "<script>alert('Challenge updated successfully.'); window.location.href = '../admin/admin_dashboard.php';</script>";
    } else {
        echo "<script>alert('Error updating challenge: " . $stmt->error . "'); window.history.back();</script>";
    }
    $stmt->close();
    $conn->close();
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
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Challenge</title>
    <link rel="stylesheet" href="assets/css/update_challenge.css">
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

    <!-- Update Challenge Form -->
    <h1>Update Challenge</h1>
    <form action="../admin/update_challenge.php?challenge_id=<?php echo $challenge_id; ?>" method="POST">
        <label for="title">Title:</label>
        <input type="text" name="title" value="<?php echo htmlspecialchars($challenge['title']); ?>" required>

        <label for="description">Description:</label>
        <textarea name="description" required><?php echo htmlspecialchars($challenge['description']); ?></textarea>

        <label for="challenge_points">Challenge Points:</label>
        <input type="number" name="challenge_points" value="<?php echo htmlspecialchars($challenge['challenge_points']); ?>" required>

        <label for="plan_name">Plan Name:</label>
        <input type="text" name="plan_name" value="<?php echo htmlspecialchars($challenge['plan_name']); ?>" required>

        <button type="submit">Update Challenge</button>
    </form>
    <a href="../admin/view_challenges.php?user_id=<?php echo $challenge['user_id']; ?>" class="back-to-challenges">Back to Challenges</a>


    <!-- Footer and Scripts --><!-- Footer and Scripts -->
    <script src="assets/js/admin.js"></script>
    </script>

</body>

</html>