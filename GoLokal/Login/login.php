<?php
session_start();
include 'config/config.php'; // Include the database connection file

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Ensure the $conn object is available from config.php
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Check if email and password are provided
    if (empty($email) || empty($password)) {
        header("Location: ../Login/login.html?error=emptyfields");
        exit();
    }

    // Prepare and execute the query to check the email
    $query = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($query);

    // Check if the statement preparation was successful
    if (!$stmt) {
        die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
    }

    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Fetch the user data
        $user = $result->fetch_assoc();

        // Verify the password
        if (password_verify($password, $user['password'])) {
            // Regenerate session ID for security
            session_regenerate_id(true);

            // Set the session variables for the logged-in user
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_role'] = $user['role']; // Store the user's role in the session

            // Redirect based on the user's role
            if ($user['role'] == 'admin' || $user['role'] == 'staff') {
                // Redirect to admin dashboard
                header("Location: ../admin/admin_dashboard.php");
            } else {
                // Redirect to user dashboard (or welcome page)
                header("Location: ../Homepage/welcome.php");
            }
            exit(); // Ensure no further code is executed
        } else {
            // Invalid password
            header("Location: ../Login/login.html?error=invalidpassword");
            exit();
        }
    } else {
        // Email not found
        header("Location: ../Login/signup.php?error=emailnotfound");
        exit();
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
