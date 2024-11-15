<?php
session_start();
require_once 'config/config.php';

// Authentication check
if (!isset($_SESSION['user_role']) || ($_SESSION['user_role'] != 'admin' && $_SESSION['user_role'] != 'staff')) {
    header("Location: login.html");
    exit;
}

// Get user data
$user_id = $_SESSION['user_id'];
$user = getUserData($user_id);
$profile_picture_path = getProfilePicturePath($user['profile_picture']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?> | Admin Dashboard</title>
    <link rel="stylesheet" href="assets/css/admin.css">
    <?php if (isset($additional_css)) echo $additional_css; ?>
</head>

<body>
    <header>
        <!-- Common header content -->
    </header>
</body>

</html>