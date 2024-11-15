<?php
session_start();
require 'config/config.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
  header("Location: ../Login/login.html");
  exit();
}

try {
  // Fetch user data
  $user_id = $_SESSION['user_id'];
  $query = "SELECT profile_picture, name, role FROM users WHERE id = ?";
  $stmt = $conn->prepare($query);
  $stmt->bind_param("i", $user_id);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows === 0) {
    header("Location: ../Login/login.html");
    exit();
  }

  $user = $result->fetch_assoc();
  $stmt->close();

  // Set user data with defaults
  $profile_picture = $user['profile_picture'] ?? 'default.png';
  $user_name = $user['name'] ?? 'My Account';
  $user_role = $user['role'] ?? 'user';

  // Handle profile picture path
  $profile_picture_path = "../uploads/" . htmlspecialchars($profile_picture);
  if (!file_exists($profile_picture_path) || !is_file($profile_picture_path)) {
    $profile_picture_path = "assets/image/default-avatar.png";
  }

  // Handle review submission
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate input
    $destination = trim($_POST['destination'] ?? '');
    $rating = filter_var($_POST['rating'] ?? 0, FILTER_VALIDATE_INT);
    $review = trim($_POST['review'] ?? '');

    $errors = [];

    if (empty($destination)) {
      $errors[] = "Destination is required.";
    }

    if ($rating < 1 || $rating > 5) {
      $errors[] = "Rating must be between 1 and 5.";
    }

    if (empty($review)) {
      $errors[] = "Review text is required.";
    }

    // If no errors, proceed with submission
    if (empty($errors)) {
      $reviewStmt = $conn->prepare("
                INSERT INTO reviews (
                    user_id, 
                    destination_name, 
                    rating, 
                    review_text, 
                    status, 
                    created_at
                ) VALUES (?, ?, ?, ?, 'pending', NOW())
            ");

      $reviewStmt->bind_param(
        "isis",
        $user_id,
        $destination,
        $rating,
        $review
      );

      if ($reviewStmt->execute()) {
        $_SESSION['success_message'] = "Review submitted successfully! It will be visible after approval.";
        header("Location: ../Homepage/Review/all_reviews.php");
        exit();
      } else {
        $errors[] = "Error submitting review. Please try again.";
      }
      $reviewStmt->close();
    }
  }
} catch (Exception $e) {
  error_log("Error in welcome.php: " . $e->getMessage());
  $_SESSION['error_message'] = "An error occurred. Please try again later.";
  header("Location: error.php");
  exit();
} finally {
  if (isset($conn)) {
    $conn->close();
  }
}

// HTML content starts here
?>

<!-- HTML Structure for Welcome Page -->
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>GoLokal Malaysia</title>
  <link rel="stylesheet" href="assets/css/welcome1.css">
  <link rel="icon" type="image/png" href="assets/image/GoLokal Logo.png">
</head>

<body>

  <!-- Header Section -->
  <header>
    <div class="container">
      <div class="logo">
        <!-- GoLokal Logo -->
        <a href="welcome.php">
          <img src="assets/image/GoLokal_try.png" alt="GoLokal Logo">
        </a>
        <nav class="nav-menu" id="navMenu">
          <ul>
            <li><a href="../Homepage/welcome.php">Home</a></li>
            <li><a href="../Homepage/state/explore.php">Explore</a></li>
            <li><a href="../Homepage/Learn/Learn.php">Learn</a></li>
            <li><a href="../Homepage/Tour/Tour.php">Tour</a></li>
            <li><a href="../Homepage/Review/all_reviews.php">Reviews</a></li>
            <li><a href="../Homepage/Events/events.php">Events</a></li>
          </ul>
        </nav>

        <!-- user dropdown menu -->
        <div class="user-dropdown">
          <div class="user-image-container">
            <img src="../uploads/<?php echo htmlspecialchars($profile_picture); ?>" alt="User Image" id="profile-picture">
            <p><?php echo htmlspecialchars($user_name); ?></p>
          </div>
          <button class="dropdown-toggle" id="dropdownToggle">
            <span class="dropdown-arrow">▼</span>
          </button>

          <div class="dropdown-menu" id="dropdownMenu">
            <a href="../Homepage/Account Settings/Edit_profile.php">Account Settings</a>
            <a href="../Homepage/Account Settings/Transaction.php">Transactions</a>
            <a href="../Homepage/Account Settings/Earn.php">Earn</a>
            <a href="../Homepage/Account Settings/Redeem.php">Redeem</a>
            <a href="../Homepage/Account Settings/redemption_status.php">Redemption Status</a>
            <a href="../Homepage/Account Settings/review_form.php">Form Reviews</a>
            <a href="../Homepage/Account Settings/weather.php">Weather</a>
            <a href="../LogOut/logout.php">Logout</a>
          </div>
        </div>
      </div>
    </div>
  </header>

  <!-- Image Slider Section -->
  <div class="slider">
    <div class="slides">
      <!-- Slide 1 -->
      <div class="slide">
        <img src="assets/image/Johor/Johor Istana Bukit Serene.jpg" alt="Image 1">
        <div class="slide-content">
          <h2>Johor</h2>
          <p>Discover the beauty of Johor, home to the Istana Bukit Serene.</p>
          <a href="../Homepage/state/johor.php" class="slide-button">Learn More</a>
        </div>

        <!-- Destination Info Box with Popular Location Header -->
        <div class="destination-box">
          <div class="destination-header">
            <p>DESTINATION</p>
          </div>
          <h4>Johor, Malaysia</h4>
          <p>Starting at RM1100</p>
        </div>
      </div>

      <!-- Slide 2 -->
      <div class="slide">
        <img src="assets/image/Kedah/Kedah.jpg" alt="Image 2">
        <div class="slide-content">
          <h2>Kedah</h2>
          <p>Explore the culture and nature of Kedah.</p>
          <a href="../Homepage/state/kedah.php" class="slide-button">Learn More</a>
        </div>

        <!-- Destination Info Box with Popular Location Header -->
        <div class="destination-box">
          <div class="destination-header">
            <p>DESTINATION</p>
          </div>
          <h4>Kedah, Malaysia</h4>
          <p>Starting at RM1050</p>
        </div>
      </div>

      <!-- Slide 3 -->
      <div class="slide">
        <img src="assets/image/Kelantan/Kelantan.webp" alt="Image 3">
        <div class="slide-content">
          <h2>Kelantan</h2>
          <p>Experience the vibrant traditions of Kelantan.</p>
          <a href="../Homepage/state/kelantan.php" class="slide-button">Learn More</a>
        </div>

        <!-- Destination Info Box with Popular Location Header -->
        <div class="destination-box">
          <div class="destination-header">
            <p>DESTINATION</p>
          </div>
          <h4>Kelantan, Malaysia</h4>
          <p>Starting at RM1000</p>
        </div>
      </div>

      <!-- Slide 4 -->
      <div class="slide">
        <img src="assets/image/Melaka/Melaka.jpg" alt="Image 4">
        <div class="slide-content">
          <h2>Melaka</h2>
          <p>Step into history with the rich heritage of Melaka.</p>
          <a href="../Homepage/state/Melaka.php" class="slide-button">Learn More</a>
        </div>

        <!-- Destination Info Box with Popular Location Header -->
        <div class="destination-box">
          <div class="destination-header">
            <p>DESTINATION</p>
          </div>
          <h4>Melaka, Malaysia</h4>
          <p>Starting at RM1150</p>
        </div>
      </div>

      <!-- Slide 5 -->
      <div class="slide">
        <img src="assets/image/Negeri Sembilan/Negeri Sembilan.jpg" alt="Image 5">
        <div class="slide-content">
          <h2>Negeri Sembilan</h2>
          <p>The serene landscapes of Negeri Sembilan await you.</p>
          <a href="../Homepage/state/NegeriSembilan.php" class="slide-button">Learn More</a>
        </div>

        <!-- Destination Info Box with Popular Location Header -->
        <div class="destination-box">
          <div class="destination-header">
            <p>DESTINATION</p>
          </div>
          <h4>Negeri Sembilan, Malaysia</h4>
          <p>Starting at RM1200</p>
        </div>
      </div>

      <!-- Slide 6 -->
      <div class="slide">
        <img src="assets/image/Pahang/Pahang.jpg" alt="Image 6">
        <div class="slide-content">
          <h2>Pahang</h2>
          <p>Explore Pahang’s natural beauty and wildlife.</p>
          <a href="../Homepage/state/Pahang.php" class="slide-button">Learn More</a>
        </div>

        <!-- Destination Info Box with Popular Location Header -->
        <div class="destination-box">
          <div class="destination-header">
            <p>DESTINATION</p>
          </div>
          <h4>Pahang, Malaysia</h4>
          <p>Starting at RM1250</p>
        </div>
      </div>

      <!-- Slide 7 -->
      <div class="slide">
        <img src="assets/image/Perak/Perak.jpg" alt="Image 7">
        <div class="slide-content">
          <h2>Perak</h2>
          <p>Discover the treasures of Perak.</p>
          <a href="../Homepage/state/Perak.php" class="slide-button">Learn More</a>
        </div>

        <!-- Destination Info Box with Popular Location Header -->
        <div class="destination-box">
          <div class="destination-header">
            <p>DESTINATION</p>
          </div>
          <h4>Perak, Malaysia</h4>
          <p>Starting at RM1200</p>
        </div>
      </div>

      <!-- Slide 8 -->
      <div class="slide">
        <img src="assets/image/Perlis/Perlis.jpg" alt="Image 8">
        <div class="slide-content">
          <h2>Perlis</h2>
          <p>Small state, big heart: Experience Perlis.</p>
          <a href="../Homepage/state/Perlis.php" class="slide-button">Learn More</a>
        </div>

        <!-- Destination Info Box with Popular Location Header -->
        <div class="destination-box">
          <div class="destination-header">
            <p>DESTINATION</p>
          </div>
          <h4>Perlis, Malaysia</h4>
          <p>Starting at RM1050</p>
        </div>
      </div>

      <!-- Slide 9 -->
      <div class="slide">
        <img src="assets/image/Pulau Pinang/Pulau Pinang Penang Hill.jpg" alt="Image 9">
        <div class="slide-content">
          <h2>Pulau Pinang</h2>
          <p>Visit the iconic Penang Hill and enjoy a panoramic view.</p>
          <a href="../Homepage/state/Penang.php" class="slide-button">Learn More</a>
        </div>

        <!-- Destination Info Box with Popular Location Header -->
        <div class="destination-box">
          <div class="destination-header">
            <p>DESTINATION</p>
          </div>
          <h4>Pulau Pinang, Malaysia</h4>
          <p>Starting at RM1300</p>
        </div>
      </div>

      <!-- Slide 10 -->
      <div class="slide">
        <img src="assets/image/Sabah/Sabah.jpg" alt="Image 10">
        <div class="slide-content">
          <h2>Sabah</h2>
          <p>Sabah: A land of adventures and beautiful landscapes.</p>
          <a href="../Homepage/state/Sabah.php" class="slide-button">Learn More</a>
        </div>

        <!-- Destination Info Box with Popular Location Header -->
        <div class="destination-box">
          <div class="destination-header">
            <p>DESTINATION</p>
          </div>
          <h4>Sabah, Malaysia</h4>
          <p>Starting at RM1700</p>
        </div>
      </div>

      <!-- Slide 11 -->
      <div class="slide">
        <img src="assets/image/Sarawak/Sarawak.jpg" alt="Image 11">
        <div class="slide-content">
          <h2>Sarawak</h2>
          <p>Discover the mysteries of Borneo in Sarawak.</p>
          <a href="../Homepage/state/Sarawak.php" class="slide-button">Learn More</a>
        </div>

        <!-- Destination Info Box with Popular Location Header -->
        <div class="destination-box">
          <div class="destination-header">
            <p>DESTINATION</p>
          </div>
          <h4>Sarawak, Malaysia</h4>
          <p>Starting at RM1750</p>
        </div>
      </div>

      <!-- Slide 12 -->
      <div class="slide">
        <img src="assets/image/Selangor/Malawati_Hill_Birds_Eye_View_Tourism_Selangor.png" alt="Image 12">
        <div class="slide-content">
          <h2>Selangor</h2>
          <p>Explore the rich culture and nature of Selangor.</p>
          <a href="../Homepage/state/Selangor.php" class="slide-button">Learn More</a>
        </div>

        <!-- Destination Info Box with Popular Location Header -->
        <div class="destination-box">
          <div class="destination-header">
            <p>DESTINATION</p>
          </div>
          <h4>Selangor, Malaysia</h4>
          <p>Starting at RM1150</p>
        </div>
      </div>

      <!-- Slide 13 -->
      <div class="slide">
        <img src="assets/image/Terengganu/Terengganu.jpg" alt="Image 13">
        <div class="slide-content">
          <h2>Terengganu</h2>
          <p>Relax on the pristine beaches of Terengganu.</p>
          <a href="../Homepage/state/Terengganu.php" class="slide-button">Learn More</a>
        </div>

        <!-- Destination Info Box with Popular Location Header -->
        <div class="destination-box">
          <div class="destination-header">
            <p>DESTINATION</p>
          </div>
          <h4>Terengganu, Malaysia</h4>
          <p>Starting at RM1100</p>
        </div>
      </div>


    </div>
    <!-- Slider Navigation Buttons -->
    <button class="prev">❮</button>
    <button class="next">❯</button>
  </div>

  <!-- Pagination Dots -->
  <div class="pagination-dots">
    <span class="dot"></span>
    <span class="dot"></span>
    <span class="dot"></span>
    <span class="dot"></span>
    <span class="dot"></span>
    <span class="dot"></span>
    <span class="dot"></span>
    <span class="dot"></span>
    <span class="dot"></span>
    <span class="dot"></span>
    <span class="dot"></span>
    <span class="dot"></span>
    <span class="dot"></span>
  </div>


  <!-- Info Cards -->
  <section class="info-section fade-in-up">
    <h2>Why We're Different</h2>
    <div class="info-cards">
      <div class="info-card fade-in-up">
        <img src="assets/image/feedback/experience.png" alt="Icon 1">
        <div class="info-text">
          <h3>Personalized Travel Experiences</h3>
          <p>We create unique, tailor-made itineraries just for you. Whether it's adventure, relaxation, or cultural exploration, we’ve got you covered.</p>
        </div>
      </div>

      <div class="info-card fade-in-up">
        <img src="assets/image/feedback/exclusive.png" alt="Icon 2">
        <div class="info-text">
          <h3>Exclusive Deals</h3>
          <p>Get access to exclusive travel deals and discounts that are not available anywhere else, ensuring you get the best value for your money.</p>
        </div>
      </div>

      <div class="info-card fade-in-up">
        <img src="assets/image/feedback/24-hours-support.png" alt="Icon 3">
        <div class="info-text">
          <h3>24/7 Customer Support</h3>
          <p>Travel worry-free with our 24/7 customer support. Wherever you are in the world, we're just a message or call away.</p>
        </div>
      </div>

      <div class="info-card fade-in-up">
        <img src="assets/image/feedback/tour-guide.png" alt="Icon 4">
        <div class="info-text">
          <h3>Expert Local Guides</h3>
          <p>Explore hidden gems with the help of our experienced local guides who know the destination inside and out.</p>
        </div>
      </div>
    </div>
  </section>




  <!-- Customer Reviews Section -->
  <section class="customer-reviews fade-in-up">
    <h2>What Our Travelers Say</h2>
    <div class="reviews-container">

      <!-- Review 1 -->
      <div class="review-card fade-in-up">
        <p>"GoLokal made my trip to Penang so much easier. The tour was well-organized, and the guide was incredibly knowledgeable about the local culture and history. I'll definitely use GoLokal again for my next trip!"</p>
        <div class="reviewer-info">
          <img src="assets/image/feedback/women 1.png" alt="Reviewer 1 Picture">
          <div>
            <h4>Maria</h4>
            <p>Traveler from USA</p>
          </div>
        </div>
      </div>

      <!-- Review 2 -->
      <div class="review-card fade-in-up">
        <p>"I booked a trip to Johor with GoLokal, and the experience was fantastic! From hotel bookings to guided tours, everything was taken care of. They even helped me discover hidden gems I wouldn't have found on my own."</p>
        <div class="reviewer-info">
          <img src="assets/image/feedback/man.png" alt="Reviewer 2 Picture">
          <div>
            <h4>Aaron</h4>
            <p>Traveler from Australia</p>
          </div>
        </div>
      </div>

      <!-- Review 3 -->
      <div class="review-card fade-in-up">
        <p>"We had an amazing time touring Sabah with GoLokal. The personalized itinerary and attention to detail were impressive. The whole process was smooth, and the customer service was excellent."</p>
        <div class="reviewer-info">
          <img src="assets/image/feedback/boy.png" alt="Reviewer 3 Picture">
          <div>
            <h4>Henry</h4>
            <p>Traveler from UK</p>
          </div>
        </div>
      </div>

      <!-- Review 4 -->
      <div class="review-card fade-in-up">
        <p>"Booking through GoLokal was the best decision we made for our vacation in Langkawi. The travel plan was customized to our needs, and we loved every bit of the journey. Highly recommended!"</p>
        <div class="reviewer-info">
          <img src="assets/image/feedback/woman.png" alt="Reviewer 4 Picture">
          <div>
            <h4>Kenneth</h4>
            <p>Traveler from Singapore</p>
          </div>
        </div>
      </div>

      <!-- Review 5 (New) -->
      <div class="review-card fade-in-up">
        <p>"The cultural experiences arranged by GoLokal in Melaka were outstanding! From traditional cooking classes to heritage walks, everything was authentic and engaging. It was a perfect blend of learning and fun."</p>
        <div class="reviewer-info">
          <img src="assets/image/feedback/women 2.png" alt="Reviewer 5 Picture">
          <div>
            <h4>Sophie</h4>
            <p>Traveler from Canada</p>
          </div>
        </div>
      </div>

      <!-- Review 6 (New) -->
      <div class="review-card fade-in-up">
        <p>"Our family trip to Terengganu was made exceptional by GoLokal's attention to detail. The beach activities, local food tours, and cultural visits were perfectly balanced. The kids especially loved the turtle sanctuary visit!"</p>
        <div class="reviewer-info">
          <img src="assets/image/feedback/men 1.png" alt="Reviewer 6 Picture">
          <div>
            <h4>David</h4>
            <p>Traveler from New Zealand</p>
          </div>
        </div>
      </div>

    </div>
  </section>

  <!-- Reviews Widget -->
  <section class="reviews-widget fade-in-up">
    <div class="section-header fade-in-up">
      <h2>What Our Visitors Say</h2>
      <a href="../Homepage/Review/all_reviews.php" class="view-all">View All Reviews</a>
    </div>
    <div class="reviews-container fade-in-up">
      <?php
      try {
        require 'config/config.php';

        // Get current user's ID from session
        $current_user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;

        // Modified query to include approved reviews and user's pending/approved reviews
        $reviewQuery = "SELECT r.*, u.name, u.username, u.profile_picture 
                          FROM reviews r 
                          JOIN users u ON r.user_id = u.id 
                          WHERE r.status IN ('approved') 
                          OR (r.user_id = ? AND r.status IN ('pending', 'approved'))
                          ORDER BY r.created_at DESC 
                          LIMIT 6";

        $stmt = $conn->prepare($reviewQuery);
        $stmt->bind_param("i", $current_user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
          while ($review = $result->fetch_assoc()) {
            // Check if this is the current user's review
            $isUserReview = ($review['user_id'] == $current_user_id);

            // Sanitize data
            $name = htmlspecialchars($review['name']);
            $destination = htmlspecialchars($review['destination_name']);
            $reviewText = htmlspecialchars($review['review_text']);

            // Fix profile picture path
            $profilePic = 'assets/image/default-avatar.png'; // Default image
            if (!empty($review['profile_picture'])) {
              $picturePath = '../uploads/' . htmlspecialchars($review['profile_picture']);
              if (file_exists($picturePath)) {
                $profilePic = $picturePath;
              }
            }
      ?>
            <div class="review-card fade-in-up <?php echo $isUserReview ? 'user-review' : ''; ?>">
              <?php if ($isUserReview): ?>
                <div class="review-status-badge <?php echo $review['status']; ?>">
                  <?php echo ucfirst($review['status']); ?>
                </div>
              <?php endif; ?>

              <div class="reviewer-info fade-in-up">
                <div class="reviewer-profile">
                  <img src="<?php echo $profilePic; ?>"
                    alt="<?php echo $name; ?>"
                    class="reviewer-image"
                    onerror="this.src='assets/image/default-avatar.png'">
                  <div class="reviewer-details">
                    <h4><?php echo $name; ?></h4>
                    <p class="destination">
                      <i class="fas fa-map-marker-alt"></i>
                      <?php echo $destination; ?>
                    </p>
                  </div>
                </div>
              </div>

              <div class="rating fade-in-up">
                <?php
                $rating = (int)$review['rating'];
                for ($i = 1; $i <= 5; $i++) {
                  echo '<span class="star ' . ($i <= $rating ? 'filled' : '') . '">★</span>';
                }
                ?>
              </div>

              <p class="review-text fade-in-up"><?php echo $reviewText; ?></p>

              <div class="review-footer fade-in-up">
                <div class="review-date">
                  <i class="far fa-calendar-alt"></i>
                  <?php echo date('M d, Y', strtotime($review['created_at'])); ?>
                </div>
              </div>
            </div>
          <?php
          }
        } else {
          ?>
          <div class="no-reviews fade-in-up">
            <p>No reviews available yet. Be the first to share your experience!</p>
          </div>
        <?php
        }
        $stmt->close();
      } catch (Exception $e) {
        error_log("Error in reviews widget: " . $e->getMessage());
        ?>
        <div class="error-message fade-in-up">
          <p>Unable to load reviews at this time. Please try again later.</p>
        </div>
      <?php
      }
      ?>
    </div>
  </section>

  <main class="review-form-container fade-in-up">
    <h2>Write a Review</h2>

    <?php
    // Display error messages if any
    if (isset($errors) && !empty($errors)): ?>
      <div class="error-messages fade-in-up">
        <?php foreach ($errors as $error): ?>
          <div class="error-message fade-in-up">
            <i class="fas fa-exclamation-circle"></i>
            <?php echo htmlspecialchars($error); ?>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

    <?php
    // Display success message if any
    if (isset($_SESSION['success_message'])): ?>
      <div class="success-message fade-in-up">
        <i class="fas fa-check-circle"></i>
        <?php
        echo htmlspecialchars($_SESSION['success_message']);
        unset($_SESSION['success_message']);
        ?>
      </div>
    <?php endif; ?>

    <form method="POST" class="review-form fade-in-up" id="reviewForm">
      <div class="form-group fade-in-up">
        <label for="destination">Destination Name <span class="required">*</span></label>
        <input type="text"
          id="destination"
          name="destination"
          required
          maxlength="100"
          placeholder="Enter destination name"
          value="<?php echo isset($_POST['destination']) ? htmlspecialchars($_POST['destination']) : ''; ?>"
          class="form-control">
        <small class="form-text">Maximum 100 characters</small>
      </div>

      <div class="form-group fade-in-up">
        <label>Rating <span class="required">*</span></label>
        <div class="rating-input">
          <?php
          $selectedRating = isset($_POST['rating']) ? (int)$_POST['rating'] : 0;
          for ($i = 5; $i >= 1; $i--):
          ?>
            <input type="radio"
              id="star<?php echo $i; ?>"
              name="rating"
              value="<?php echo $i; ?>"
              <?php echo ($selectedRating === $i) ? 'checked' : ''; ?>
              required>
            <label for="star<?php echo $i; ?>" title="<?php echo $i; ?> stars">★</label>
          <?php endfor; ?>
        </div>
        <small class="form-text">Click to rate from 1 to 5 stars</small>
      </div>

      <div class="form-group fade-in-up">
        <label for="review">Your Review <span class="required">*</span></label>
        <textarea id="review"
          name="review"
          required
          maxlength="1000"
          placeholder="Share your experience..."
          class="form-control"><?php echo isset($_POST['review']) ? htmlspecialchars($_POST['review']) : ''; ?></textarea>
        <small class="form-text">
          <span id="charCount">0</span>/1000 characters
        </small>
      </div>

      <div class="form-actions fade-in-up">
        <button type="submit" class="submit-btn">
          <i class="fas fa-paper-plane"></i> Submit Review
        </button>
      </div>
    </form>
  </main>


  <!-- About Us Section -->
  <section class="about-us fade-in-up">
    <div class="about-us-content fade-in-up">
      <h2>About Us</h2>
      <p>At GoLokal, we believe travel is about creating unforgettable memories and experiencing new cultures. Founded by passionate travelers, our mission is to help you discover Malaysia’s hidden gems, from lively cities to peaceful countryside.</p>

      <p>We offer personalized travel experiences tailored to your interests. Whether you’re looking for adventure, history, or delicious local food, we have something for everyone. Our itineraries are designed to ensure your trip is unique and memorable.</p>

      <p>When you choose GoLokal, you’re accessing the best travel deals and accommodations. Our local experts work hard to find unique experiences that fit your budget, making your trip enjoyable without overspending.</p>

      <p>Our commitment to excellent customer service sets us apart. Our support team is available 24/7 to help with any questions or changes to your plans, ensuring a smooth travel experience.</p>

      <p>Join us as we explore Malaysia’s beautiful beaches, vibrant markets, and rich history. Whether you’re traveling alone, with a partner, or with family, we’re here to make your journey unforgettable. Let GoLokal turn your travel dreams into reality!</p>
  </section>

  <!-- Newsletter Section -->
  <section class="newsletter">
    <div class="newsletter-container">
      <h3>Subscribe to Our Newsletter</h3>
      <p>Stay updated with our latest news and updates</p>
      <form id="newsletterForm" class="newsletter-form">
        <input type="email" name="email" placeholder="Enter your email" required>
        <button type="submit">Subscribe</button>
      </form>
      <div id="newsletterMessage" class="newsletter-message"></div>
    </div>
  </section>

  <!-- Back to Top Button -->
  <button id="backToTop" aria-label="Back to Top">↑</button>

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

  <script src="assets/js/welcome1.js"></script>
  <script src="assets/js/newsletter.js"></script>
</body>

</html>