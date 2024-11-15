<?php
session_start();
require_once 'config/config.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../../Login/login.html");
    exit();
}

// Initialize variables
$weatherData = null;
$error = null;
$defaultCity = "Kuala Lumpur";

try {
    // Fetch user data
    $user_id = $_SESSION['user_id'];
    $query = "SELECT profile_picture, name, role FROM users WHERE id = ?";
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

    // Handle profile picture path
    $profile_picture_path = "../../uploads/" . htmlspecialchars($profile_picture);
    if (!file_exists($profile_picture_path) || !is_file($profile_picture_path)) {
        $profile_picture_path = "assets/image/default-avatar.png";
    }

    // Weather API Configuration
    $rapidApiKey = "426d4f17c5mshb2af5c94cfe2b55p17627ajsnfccfaa8bb151"; // Replace with your actual API key

    // Function to fetch weather data
    function getWeatherData($city, $apiKey)
    {
        try {
            $curl = curl_init();
            curl_setopt_array($curl, [
                CURLOPT_URL => "https://weatherapi-com.p.rapidapi.com/current.json?q=" . urlencode($city),
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => [
                    "X-RapidAPI-Host: weatherapi-com.p.rapidapi.com",
                    "X-RapidAPI-Key: " . $apiKey
                ],
            ]);

            $response = curl_exec($curl);
            $err = curl_error($curl);

            if ($err) {
                throw new Exception("Curl Error: " . $err);
            }

            $data = json_decode($response, true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new Exception("JSON decode error: " . json_last_error_msg());
            }

            return $data;
        } catch (Exception $e) {
            error_log("Weather API Error: " . $e->getMessage());
            return null;
        } finally {
            if (isset($curl) && is_resource($curl)) {
                curl_close($curl);
            }
        }
    }

    // Handle weather data fetch
    if (isset($_POST['search'])) {
        $searchCity = trim($_POST['city']);
        if (!empty($searchCity)) {
            $weatherData = getWeatherData($searchCity, $rapidApiKey);
            if (!isset($weatherData['current'])) {
                $error = "Location not found. Please try again.";
            }
        }
    } else {
        // Load default city weather
        $weatherData = getWeatherData($defaultCity, $rapidApiKey);
    }
} catch (Exception $e) {
    error_log("Error in weather.php: " . $e->getMessage());
    $error = "An error occurred. Please try again later.";
} finally {
    if (isset($conn)) {
        $conn->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weather Information - GoLokal</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/weather.css">
    <link rel="icon" type="image/png" href="assets/image/GoLokal Logo.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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

    <!-- Main Content -->
    <div class="weather-container">
        <div class="search-section">
            <h1>Malaysia Weather Information</h1>
            <form method="POST" class="search-form">
                <div class="search-box">
                    <input type="text"
                        name="city"
                        placeholder="Search for a city..."
                        list="malaysian-cities"
                        required>
                    <datalist id="malaysian-cities">
                        <option value="Kuala Lumpur">
                        <option value="Johor Bahru">
                        <option value="Penang">
                        <option value="Ipoh">
                        <option value="Malacca">
                        <option value="Kota Kinabalu">
                        <option value="Kuching">
                    </datalist>
                    <button type="submit" name="search">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </form>
        </div>

        <?php if ($error): ?>
            <div class="error-message">
                <i class="fas fa-exclamation-circle"></i>
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <?php if ($weatherData && isset($weatherData['current'])): ?>
            <div class="weather-widget">
                <div class="weather-card">
                    <div class="weather-header">
                        <h2><?php echo htmlspecialchars($weatherData['location']['name']); ?></h2>
                        <p class="location-info">
                            <?php echo htmlspecialchars($weatherData['location']['region']); ?>,
                            <?php echo htmlspecialchars($weatherData['location']['country']); ?>
                        </p>
                    </div>

                    <div class="weather-main">
                        <img src="<?php echo $weatherData['current']['condition']['icon']; ?>"
                            alt="Weather icon"
                            class="weather-icon">
                        <div class="temperature-display">
                            <span class="temperature">
                                <?php echo round($weatherData['current']['temp_c']); ?>°C
                            </span>
                            <span class="condition">
                                <?php echo $weatherData['current']['condition']['text']; ?>
                            </span>
                        </div>
                    </div>

                    <div class="weather-details">
                        <div class="detail-item">
                            <i class="fas fa-tint"></i>
                            <div class="detail-info">
                                <span class="label">Humidity</span>
                                <span class="value"><?php echo $weatherData['current']['humidity']; ?>%</span>
                            </div>
                        </div>
                        <div class="detail-item">
                            <i class="fas fa-wind"></i>
                            <div class="detail-info">
                                <span class="label">Wind</span>
                                <span class="value"><?php echo round($weatherData['current']['wind_kph']); ?> km/h</span>
                            </div>
                        </div>
                        <div class="detail-item">
                            <i class="fas fa-temperature-high"></i>
                            <div class="detail-info">
                                <span class="label">Feels Like</span>
                                <span class="value"><?php echo round($weatherData['current']['feelslike_c']); ?>°C</span>
                            </div>
                        </div>
                        <div class="detail-item">
                            <i class="fas fa-cloud-rain"></i>
                            <div class="detail-info">
                                <span class="label">Precipitation</span>
                                <span class="value"><?php echo $weatherData['current']['precip_mm']; ?> mm</span>
                            </div>
                        </div>
                    </div>

                    <div class="last-updated">
                        Last updated: <?php echo date('H:i', strtotime($weatherData['current']['last_updated'])); ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>
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

    <!-- JavaScript -->
    <script src="assets/js/navbar.js"></script>
    <script src="assets/js/weather.js"></script>
</body>

</html>