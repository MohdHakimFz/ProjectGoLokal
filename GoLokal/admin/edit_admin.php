<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require 'config/config.php';

// Check if user is logged in and has admin/staff role
if (!isset($_SESSION['user_id']) || ($_SESSION['user_role'] != 'admin' && $_SESSION['user_role'] != 'staff')) {
    header("Location: ../Login/login.html");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch user details
$query = "SELECT profile_picture, name, email, phone, dob, username FROM users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Handle profile picture path
$profile_picture_url = '../uploads/default.png'; // Default image
if (!empty($user['profile_picture'])) {
    $profile_picture_path = "../uploads/" . $user['profile_picture'];
    if (file_exists($profile_picture_path) && is_readable($profile_picture_path)) {
        $profile_picture_url = $profile_picture_path;
    }
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_profile'])) {
    // Validate and sanitize input
    $full_name = trim(filter_input(INPUT_POST, 'full_name', FILTER_SANITIZE_STRING));
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $phone = trim(filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_STRING));
    $dob = trim(filter_input(INPUT_POST, 'dob', FILTER_SANITIZE_STRING));
    $username = trim(filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING));

    // Validate required fields
    if (empty($full_name) || empty($email) || empty($phone) || empty($username)) {
        $_SESSION['error_message'] = "All required fields must be filled out";
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }

    // Check email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error_message'] = "Invalid email format";
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }

    // Handle profile picture upload
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        $max_size = 2 * 1024 * 1024; // 2MB
        $upload_dir = "../uploads/";

        // Validate file
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mime_type = $finfo->file($_FILES['profile_picture']['tmp_name']);

        if (!in_array($mime_type, $allowed_types)) {
            $_SESSION['error_message'] = "Only JPG, PNG and GIF files are allowed";
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        }

        if ($_FILES['profile_picture']['size'] > $max_size) {
            $_SESSION['error_message'] = "File size must be less than 2MB";
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        }

        // Generate unique filename and save file
        $ext = pathinfo($_FILES['profile_picture']['name'], PATHINFO_EXTENSION);
        $new_filename = $user_id . '_' . time() . '.' . $ext;
        $filepath = $upload_dir . $new_filename;

        if (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $filepath)) {
            // Delete old profile picture if exists
            if (!empty($user['profile_picture']) && $user['profile_picture'] != 'default.png') {
                $old_file = $upload_dir . $user['profile_picture'];
                if (file_exists($old_file)) {
                    unlink($old_file);
                }
            }
            $user['profile_picture'] = $new_filename;
        }
    }

    // Handle password update
    if (!empty($_POST['new_password'])) {
        if ($_POST['new_password'] !== $_POST['confirm_password']) {
            $_SESSION['error_message'] = "New passwords do not match";
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        }

        // Verify current password
        $verify_query = "SELECT password FROM users WHERE id = ?";
        $stmt = $conn->prepare($verify_query);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $current_user = $result->fetch_assoc();

        if (!password_verify($_POST['current_password'], $current_user['password'])) {
            $_SESSION['error_message'] = "Current password is incorrect";
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        }

        $password_hash = password_hash($_POST['new_password'], PASSWORD_DEFAULT);

        // Update password
        $update_password_query = "UPDATE users SET password = ? WHERE id = ?";
        $stmt = $conn->prepare($update_password_query);
        $stmt->bind_param("si", $password_hash, $user_id);
        $stmt->execute();
    }

    // Update user profile
    $update_query = "UPDATE users SET name = ?, email = ?, phone = ?, dob = ?, username = ?, profile_picture = ? WHERE id = ?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("ssssssi", $full_name, $email, $phone, $dob, $username, $user['profile_picture'], $user_id);

    if ($stmt->execute()) {
        $_SESSION['success_message'] = "Profile updated successfully";
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } else {
        $_SESSION['error_message'] = "Error updating profile";
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile | GoLokal</title>
    <link rel="stylesheet" href="assets/css/edit_admin.css">
    <link rel="icon" type="image/png" href="assets/image/GoLokal Logo.png">
</head>

<body>
    <header>
        <div class="container">
            <div class="logo">
                <a href="../admin/admin_dashboard.php">
                    <img src="assets/image/GoLokal_try.png" alt="GoLokal Logo">
                </a>
                <nav class="nav-menu">
                    <ul>
                        <li><a href="../admin/admin_dashboard.php">Dashboard</a></li>
                    </ul>
                </nav>

                <div class="user-dropdown">
                    <div class="user-image-container">
                        <img src="<?php echo htmlspecialchars($profile_picture_url); ?>" alt="Profile Picture" id="profile-picture">
                        <p><?php echo htmlspecialchars($user['name']); ?></p>
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

    <div class="form-container">
        <h2>Edit Profile</h2>

        <?php if (isset($_SESSION['error_message'])): ?>
            <div class="alert alert-danger">
                <?php
                echo htmlspecialchars($_SESSION['error_message']);
                unset($_SESSION['error_message']);
                ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['success_message'])): ?>
            <div class="alert alert-success">
                <?php
                echo htmlspecialchars($_SESSION['success_message']);
                unset($_SESSION['success_message']);
                ?>
            </div>
        <?php endif; ?>

        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label>Profile Picture</label>
                <input type="file" name="profile_picture" accept="image/*" onchange="previewImage(event)">
                <img id="preview" src="<?php echo htmlspecialchars($profile_picture_url); ?>" alt="Profile Picture" class="profile-pic">
            </div>

            <div class="form-group">
                <label>Full Name</label>
                <input type="text" name="full_name" value="<?php echo htmlspecialchars($user['name']); ?>" required>
            </div>

            <div class="form-group">
                <label>Email Address</label>
                <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
            </div>

            <div class="form-group">
                <label>Phone Number</label>
                <input type="tel" name="phone" value="<?php echo htmlspecialchars($user['phone']); ?>" required>
            </div>

            <div class="form-group">
                <label>Date of Birth</label>
                <input type="date" name="dob" value="<?php echo htmlspecialchars($user['dob']); ?>">
            </div>

            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>
            </div>

            <h3>Password Management</h3>
            <div class="form-group">
                <label>Current Password</label>
                <input type="password" name="current_password">
            </div>

            <div class="form-group">
                <label>New Password</label>
                <input type="password" name="new_password" minlength="8">
            </div>

            <div class="form-group">
                <label>Confirm New Password</label>
                <input type="password" name="confirm_password">
            </div>

            <button type="submit" name="update_profile">Save Changes</button>
        </form>
    </div>

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

    <script src="assets/js/edit_admin.js"></script>
</body>

</html>