<?php
header('Content-Type: application/json');

try {
    // Database connection
    $db = new PDO('mysql:host=localhost;dbname=GoLokal', 'root', '');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Get and validate email
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    if (!$email) {
        throw new Exception('Invalid email address');
    }

    // Check if email already exists
    $stmt = $db->prepare('SELECT email FROM newsletter_subscriptions WHERE email = ?');
    $stmt->execute([$email]);
    if ($stmt->rowCount() > 0) {
        echo json_encode([
            'status' => 'success',
            'message' => 'This email is already subscribed!'
        ]);
        exit;
    }

    // Insert new subscriber with active status
    $stmt = $db->prepare('INSERT INTO newsletter_subscriptions(email, subscription_date, status) VALUES (?, NOW(), "active")');
    $stmt->execute([$email]);

    echo json_encode([
        'status' => 'success',
        'message' => 'Thank you for subscribing to our newsletter!'
    ]);
} catch (Exception $e) {
    echo json_encode([
        'status' => 'error',
        'message' => 'An error occurred. Please try again later.'
    ]);
}
