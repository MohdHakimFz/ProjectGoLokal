<?php
session_start();
include 'config/config.php'; // Include the database connection file

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ensure required fields are set and not empty
    if (empty($_POST['name']) || empty($_POST['email']) || empty($_POST['password'])) {
        header("Location: signup.html?error=All fields are required.");
        exit();
    }

    // Get and sanitize form input values
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: ../Login/signup.html?error=Invalid email format.");
        exit();
    }

    // Check if the email already exists
    $query = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($query);

    if (!$stmt) {
        error_log("Database error: " . $conn->error); // Log the error
        header("Location: ../Login/signup.php?error=Database error. Please try again.");
        exit();
    }

    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // If email already exists, redirect with an error
        header("Location: ../Login/signup.html?error=Email already registered. Please use another email.");
        exit();
    } else {
        // Hash the password for security
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert the new user into the database
        $query = "INSERT INTO users (name, email, password) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($query);

        if (!$stmt) {
            error_log("Database error: " . $conn->error); // Log the error
            header("Location: ../Login/signup.html?error=Database error. Please try again.");
            exit();
        }

        $stmt->bind_param("sss", $name, $email, $hashed_password);

        if ($stmt->execute()) {
            // Automatically log in the user after successful registration
            $user_id = $stmt->insert_id; // Get the user ID of the newly registered user

            // Regenerate session ID for security
            session_regenerate_id(true);

            // Set session variables to log the user in
            $_SESSION['user_id'] = $user_id;
            $_SESSION['user_name'] = $name;

            // Redirect to the welcome.php page after successful login
            header("Location: ../Homepage/welcome.php");
            exit(); // Ensure no further script execution after redirection
        } else {
            error_log("Error: " . $stmt->error); // Log the error
            header("Location: signup.html?error=Error during registration. Please try again.");
            exit();
        }
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
