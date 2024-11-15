<?php
session_start();
require_once 'config/config.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../../Login/login.html");
    exit();
}

try {
    // Fetch user data
    $user_id = $_SESSION['user_id'];
    $query = "SELECT * FROM users WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        header("Location: ../../Login/login.html");
        exit();
    }

    $user = $result->fetch_assoc();
    $stmt->close();

    // Set user data with defaults
    $profile_picture = $user['profile_picture'] ?? 'default.png';
    $user_name = $user['name'] ?? 'My Account';
    $user_role = $user['role'] ?? 'user';
    $user_email = $user['email'] ?? '';
    $user_phone = $user['phone'] ?? '';
    $user_dob = $user['dob'] ?? '';
    $user_username = $user['username'] ?? '';

    // Handle profile picture path
    $profile_picture_path = "uploads/" . htmlspecialchars($profile_picture);
    if (!file_exists($profile_picture_path) || !is_file($profile_picture_path)) {
        $profile_picture_path = "assets/image/default-avatar.png";
    }

    // Handle profile update
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $errors = [];

        // Validate inputs
        $new_name = trim($_POST['full_name'] ?? '');
        $new_email = trim($_POST['email'] ?? '');
        $new_phone = trim($_POST['phone'] ?? '');
        $new_username = trim($_POST['username'] ?? '');
        $new_dob = trim($_POST['dob'] ?? '');

        // Validation
        if (empty($new_name)) {
            $errors[] = "Name is required";
        }
        if (empty($new_email) || !filter_var($new_email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Valid email is required";
        }
        if (empty($new_phone)) {
            $errors[] = "Phone number is required";
        }
        if (empty($new_username)) {
            $errors[] = "Username is required";
        }

        // Handle profile picture upload
        if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
            $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
            $file_type = $_FILES['profile_picture']['type'];
            $file_size = $_FILES['profile_picture']['size'];
            $max_size = 5 * 1024 * 1024; // 5MB

            if (!in_array($file_type, $allowed_types)) {
                $errors[] = "Invalid file type. Only JPG, PNG and GIF are allowed.";
            }
            if ($file_size > $max_size) {
                $errors[] = "File size too large. Maximum size is 5MB.";
            }

            if (empty($errors)) {
                $upload_dir = "../../uploads/";
                $file_extension = pathinfo($_FILES['profile_picture']['name'], PATHINFO_EXTENSION);
                $new_filename = uniqid('profile_') . '.' . $file_extension;
                $upload_path = $upload_dir . $new_filename;

                if (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $upload_path)) {
                    // Delete old profile picture if it exists and is not the default
                    if ($profile_picture !== 'default.png' && file_exists("../../uploads/" . $profile_picture)) {
                        unlink("../../uploads/" . $profile_picture);
                    }
                    $profile_picture = $new_filename;
                } else {
                    $errors[] = "Failed to upload profile picture";
                }
            }
        }

        // Handle password update
        if (!empty($_POST['new_password'])) {
            if ($_POST['new_password'] !== $_POST['confirm_password']) {
                $errors[] = "New passwords do not match";
                // Don't redirect here, let the errors array handle it
            }

            // Verify current password
            $verify_query = "SELECT password FROM users WHERE id = ?";
            $stmt = $conn->prepare($verify_query);
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $current_user = $result->fetch_assoc();

            if (!password_verify($_POST['current_password'], $current_user['password'])) {
                $errors[] = "Current password is incorrect";
                // Don't redirect here, let the errors array handle it
            }

            if (empty($errors)) {
                $password_hash = password_hash($_POST['new_password'], PASSWORD_DEFAULT);

                // Update password
                $update_password_query = "UPDATE users SET password = ? WHERE id = ?";
                $stmt = $conn->prepare($update_password_query);
                $stmt->bind_param("si", $password_hash, $user_id);
                $stmt->execute();
            }
        }

        // If no errors, update the user data
        if (empty($errors)) {
            $conn->begin_transaction();
            try {
                // Check if email already exists for another user
                $email_check = $conn->prepare("SELECT id FROM users WHERE email = ? AND id != ?");
                $email_check->bind_param("si", $new_email, $user_id);
                $email_check->execute();
                if ($email_check->get_result()->num_rows > 0) {
                    throw new Exception("Email already exists");
                }

                // Update user data
                $update_query = "UPDATE users SET 
                    name = ?, 
                    email = ?, 
                    phone = ?, 
                    username = ?, 
                    dob = ?, 
                    profile_picture = ? 
                    WHERE id = ?";
                $update_stmt = $conn->prepare($update_query);
                $update_stmt->bind_param(
                    "ssssssi",
                    $new_name,
                    $new_email,
                    $new_phone,
                    $new_username,
                    $new_dob,
                    $profile_picture,
                    $user_id
                );
                $update_stmt->execute();

                $conn->commit();
                $_SESSION['success_message'] = "Profile updated successfully!";
                header("Location: edit_profile.php");
                exit();
            } catch (Exception $e) {
                $conn->rollback();
                $errors[] = $e->getMessage();
            }
        } else {
            // Store errors in session to display them
            $_SESSION['error_message'] = implode("<br>", $errors);
        }
    }
} catch (Exception $e) {
    error_log("Error in Edit_profile.php: " . $e->getMessage());
    $_SESSION['error_message'] = "An error occurred. Please try again later.";
    header("Location: ../welcome.php");
    exit();
} finally {
    if (isset($conn)) {
        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Edit Profile</title>
    <link rel="stylesheet" href="assets/css/edit_profile.css">
    <link rel="icon" type="image/png" href="assets/image/GoLokal Logo.png">
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

    <!-- Profile Form Section -->
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
            <!-- Profile Picture -->
            <div class="form-group">
                <label>Profile Picture</label>
                <input type="file" name="profile_picture" accept="image/*" onchange="previewImage(event)">
                <img id="preview" src="uploads/<?php echo isset($user['profile_picture']) ? $user['profile_picture'] : 'default.png'; ?>" alt="Profile Picture" class="profile-pic">
            </div>

            <!-- Full Name -->
            <div class="form-group">
                <label>Full Name</label>
                <input type="text" name="full_name" value="<?php echo htmlspecialchars($user['name']); ?>" required>
            </div>

            <!-- Email Address -->
            <div class="form-group">
                <label>Email Address</label>
                <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
            </div>

            <!-- Phone Number -->
            <div class="form-group">
                <label>Phone Number</label>
                <input type="text" name="phone" value="<?php echo htmlspecialchars($user['phone']); ?>" required>
            </div>

            <!-- Date of Birth -->
            <div class="form-group">
                <label>Date of Birth</label>
                <input type="date" name="dob" value="<?php echo htmlspecialchars($user['dob']); ?>">
            </div>

            <!-- Username -->
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>
            </div>

            <!-- Password Management -->
            <h3>Password Management</h3>

            <!-- Current Password -->
            <div class="form-group">
                <label>Current Password</label>
                <input type="password" name="current_password">
            </div>

            <!-- New Password -->
            <div class="form-group">
                <label>New Password</label>
                <input type="password" name="new_password">
            </div>

            <!-- Confirm New Password -->
            <div class="form-group">
                <label>Confirm New Password</label>
                <input type="password" name="confirm_password">
            </div>

            <button type="submit" name="update_profile">Save Changes</button>
        </form>
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

    <script src="assets/js/edit_profile.js"></script>
</body>

</html>