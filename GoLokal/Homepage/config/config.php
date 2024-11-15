<?php
// Database connection details
$servername = "localhost";  // Usually 'localhost' for local server
$username = "root";         // Your phpMyAdmin username, usually 'root'
$password = "";             // Your phpMyAdmin password (leave empty if not set)
$dbname = "GoLokal";        // The new database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
