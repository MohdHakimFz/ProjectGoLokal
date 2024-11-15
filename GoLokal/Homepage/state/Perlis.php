<?php
session_start();
require 'config/config.php'; // Include your database connection file

if (!isset($_SESSION['user_id'])) {
    header("Location: ../../Login/login.html"); // Redirect to login if the user is not logged in
    exit();
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
$profile_picture = $user['profile_picture'] ?? 'default.png';
$user_name = $user['name'] ?? 'My Account';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Explore Perlis - GoLokal</title>
    <link rel="stylesheet" href="assets/css/perlis.css">
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
                        <li><a href="../learn/Learn.php">Learn</a></li>
                        <li><a href="../Tour/Tour.php">Tour</a></li>
                        <li><a href="../Review/all_reviews.php">Reviews</a></li>
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


    <!-- Introduction Section -->
    <section class="perlis-intro">
        <h1>Discover Perlis</h1>
        <img src="assets/image/Perlis/Flag Perlis.png" alt="Perlis Flag">
        <p>Perlis, Malaysia’s smallest state, offers a peaceful escape with its scenic paddy fields and quiet countryside. Known for its laid-back atmosphere, Perlis is perfect for those looking to explore local life and enjoy tranquil landscapes.</p>
    </section>

    <!-- Top Attractions Section -->
    <section class="attractions">
        <h2>Top Attractions in Perlis</h2>
        <div class="attraction-list">
            <div class="attraction-item">
                <img src="assets/image/Perlis/Perlis State Park.jpg" alt="Perlis State Park">
                <h3>Perlis State Park</h3>
                <p>Explore the Perlis State Park, a beautiful nature reserve filled with limestone hills, caves, and diverse wildlife. It's perfect for hiking and bird watching.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Perlis/Wang Kelian Viewpoint.jpeg" alt="Wang Kelian Viewpoint">
                <h3>Wang Kelian Viewpoint</h3>
                <p>Enjoy panoramic views of the surrounding countryside at Wang Kelian Viewpoint, a must-visit for nature lovers.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Perlis/Tasik Melati.png" alt="Tasik Melati">
                <h3>Tasik Melati</h3>
                <p>Tasik Melati is a small but scenic lake surrounded by floating islands, perfect for a relaxing stroll or a picnic by the water.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Perlis/Gua Kelam.jpg" alt="Gua Kelam">
                <h3>Gua Kelam</h3>
                <p>Gua Kelam, or the Cave of Darkness, is a 370-meter long limestone cave that offers an exciting walkway adventure through its natural formations.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Perlis/Kota Kayang Museum.jpg" alt="Kota Kayang Museum">
                <h3>Kota Kayang Museum</h3>
                <p>Learn about the history and culture of Perlis at the Kota Kayang Museum, featuring exhibits on archaeology, royal artifacts, and traditional customs.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Perlis/Arau Palace.webp" alt="Arau Palace">
                <h3>Arau Palace</h3>
                <p>Arau Palace is the royal residence of the Raja of Perlis. Though the palace is not open to the public, its impressive architecture is worth admiring from the outside.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Perlis/Padang Besar.jpg" alt="Padang Besar">
                <h3>Padang Besar</h3>
                <p>Padang Besar is a bustling border town known for its markets, where you can shop for a variety of goods, from local produce to imported items.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Perlis/Perlis Vineyard.jpg" alt="Perlis Vineyard">
                <h3>Perlis Vineyard (Ladang Anggur Perlis)</h3>
                <p>Visit the Perlis Vineyard and enjoy a tour of the vineyard, where you can taste locally produced grapes and wines.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Perlis/Bukit Keteri.webp" alt="Bukit Keteri">
                <h3>Bukit Keteri</h3>
                <p>Bukit Keteri is a popular rock climbing destination, with challenging limestone cliffs that attract climbers from all over the world.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Perlis/Timah Tasoh Lake.jpg" alt="Timah Tasoh Lake">
                <h3>Timah Tasoh Lake</h3>
                <p>Timah Tasoh Lake is a serene man-made lake surrounded by hills, ideal for a peaceful day out, bird watching, or a boat ride.</p>
            </div>
        </div>
    </section>

    <!-- Cultural Heritage Section -->
    <section class="culture">
        <h2>Cultural Heritage of Perlis</h2>
        <div class="attraction-list">
            <div class="attraction-item">
                <img src="assets/image/Perlis/Kota Kayang Museum.jpg" alt="Muzium Kota Kayang">
                <h3>Muzium Kota Kayang</h3>
                <p>Muzium Kota Kayang is a historical museum that houses various exhibits on Perlis’ history, archaeology, and the royal family of the state.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Perlis/Gua Kelam.jpg" alt="Gua Kelam">
                <h3>Gua Kelam</h3>
                <p>Gua Kelam is an ancient limestone cave used as a tin mining tunnel. Today, it’s a historical site offering insight into Perlis’ mining history.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Perlis/Wang Kelian Border Market.jpg" alt="Wang Kelian Border Market">
                <h3>Wang Kelian Border Market</h3>
                <p>Wang Kelian Border Market reflects Perlis' heritage as a trading hub. The market offers goods from both Malaysia and Thailand, celebrating the cultural exchange between the two nations.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Perlis/Masjid Alwi.jpg" alt="Masjid Alwi">
                <h3>Masjid Alwi</h3>
                <p>Masjid Alwi, located in Kangar, is one of the oldest mosques in Perlis and is recognized for its historical and architectural significance.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Perlis/Syed Hussein Royal Mausoleum.jpg" alt="Syed Hussein Royal Mausoleum">
                <h3>Syed Hussein Royal Mausoleum</h3>
                <p>Syed Hussein Royal Mausoleum is the final resting place of the former Raja of Perlis, highlighting the royal history and heritage of the state.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Perlis/Kota Sarang Semut.jpg" alt="Kota Sarang Semut">
                <h3>Kota Sarang Semut</h3>
                <p>Kota Sarang Semut is an ancient fort that once played a crucial role in the defense of Perlis, showcasing the state's military history.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Perlis/Padang Besar.jpg" alt="Padang Besar">
                <h3>Padang Besar</h3>
                <p>Padang Besar is a well-known cross-border trading town that has played a key role in the commerce and cultural heritage of Perlis.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Perlis/Kuala Perlis Jetty.jpg" alt="Kuala Perlis Jetty">
                <h3>Kuala Perlis Jetty</h3>
                <p>Kuala Perlis Jetty is an iconic historical location that serves as the main port, playing a significant role in the maritime history of the state.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Perlis/Perlis State Park.jpg" alt="Perlis State Park">
                <h3>Perlis State Park</h3>
                <p>Perlis State Park not only offers nature trails but also reflects Perlis' natural heritage, preserving the history of the area's flora and fauna.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Perlis/Arau Palace.webp" alt="Arau Royal Palace">
                <h3>Arau Royal Palace</h3>
                <p>Arau Royal Palace is the residence of the Raja of Perlis, symbolizing the state’s royal legacy and its role in Malaysian history.</p>
            </div>
        </div>
    </section>


    <!-- Adventure & Nature Section -->
    <section class="adventure">
        <h2>Adventure & Nature in Perlis</h2>
        <div class="attraction-list">
            <div class="attraction-item">
                <img src="assets/image/Perlis/Perlis State Park.jpg" alt="Perlis State Park">
                <h3>Perlis State Park</h3>
                <p>Explore the scenic beauty of Perlis State Park, offering forest trails, limestone caves, and rich biodiversity, perfect for nature lovers and adventure seekers.</p>
                <h4>Activities: Jungle trekking, bird watching, caving</h4>
                <h4>Location: Wang Kelian, Perlis</h4>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Perlis/Gua Kelam.jpg" alt="Gua Kelam">
                <h3>Gua Kelam</h3>
                <p>Walk through this mystical limestone cave, known for its fascinating rock formations and an underground river that runs through it.</p>
                <h4>Activities: Caving, hiking, photography</h4>
                <h4>Location: Kaki Bukit, Perlis</h4>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Perlis/Bukit Ayer Recreational Park.webp" alt="Bukit Ayer Recreational Park">
                <h3>Bukit Ayer Recreational Park</h3>
                <p>A serene getaway surrounded by waterfalls and lush greenery, ideal for family picnics and outdoor fun.</p>
                <h4>Activities: Swimming, picnicking, hiking</h4>
                <h4>Location: Kangar, Perlis</h4>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Perlis/Tasik Melati.png" alt="Tasik Melati">
                <h3>Tasik Melati</h3>
                <p>Tasik Melati is a tranquil lake surrounded by over 150 small islands, making it a great spot for relaxing and bird watching.</p>
                <h4>Activities: Boating, nature walks, photography</h4>
                <h4>Location: Kangar, Perlis</h4>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Perlis/Wang Kelian Viewpoint.jpeg" alt="Wang Kelian Viewpoint">
                <h3>Wang Kelian Viewpoint</h3>
                <p>A scenic viewpoint offering panoramic views of the mountainous border between Malaysia and Thailand, ideal for photography and sightseeing.</p>
                <h4>Activities: Sightseeing, hiking</h4>
                <h4>Location: Wang Kelian, Perlis</h4>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Perlis/Padang Besar.jpg" alt="Padang Besar">
                <h3>Padang Besar</h3>
                <p>Explore the bustling border town of Padang Besar, known for its vibrant markets, offering local produce and goods from Thailand.</p>
                <h4>Activities: Shopping, local cuisine, sightseeing</h4>
                <h4>Location: Padang Besar, Perlis</h4>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Perlis/Gunung Perlis.jpeg" alt="Gunung Perlis">
                <h3>Gunung Perlis</h3>
                <p>Hike the challenging trails of Gunung Perlis and enjoy the breathtaking views of the surrounding limestone hills and forests.</p>
                <h4>Activities: Hiking, bird watching, photography</h4>
                <h4>Location: Perlis State Park, Perlis</h4>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Perlis/Taman Bunga Kertas.webp" alt="Taman Bunga Kertas">
                <h3>Taman Bunga Kertas</h3>
                <p>Visit this flower garden known for its vibrant Bougainvillea collection, offering a peaceful spot for nature lovers.</p>
                <h4>Activities: Garden walks, photography, relaxation</h4>
                <h4>Location: Kangar, Perlis</h4>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Perlis/Kuala Perlis.jpeg" alt="Kuala Perlis">
                <h3>Kuala Perlis</h3>
                <p>A coastal town known for its seafood and stunning sunsets, offering opportunities for fishing and boat rides to Langkawi.</p>
                <h4>Activities: Fishing, boating, local dining</h4>
                <h4>Location: Kuala Perlis, Perlis</h4>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Perlis/Perlis Vineyard.jpg" alt="Perlis Vineyard">
                <h3>Perlis Vineyard</h3>
                <p>Discover Perlis' vineyard and taste local grapes and fresh produce, offering a unique agricultural experience in Malaysia.</p>
                <h4>Activities: Vineyard tours, grape picking, photography</h4>
                <h4>Location: Titi Tinggi, Perlis</h4>
            </div>
        </div>
    </section>


    <!-- Food & Cuisine Section -->
    <section class="cuisine">
        <h2>Food & Cuisine in Perlis</h2>
        <div class="attraction-list">
            <div class="attraction-item">
                <img src="assets/image/Perlis/Laksa Perlis.jpg" alt="Laksa Perlis">
                <h3>Laksa Perlis</h3>
                <p>A local favorite, Laksa Perlis is made with rice noodles in a flavorful fish-based broth, garnished with cucumber, boiled eggs, and herbs.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Perlis/Pulut Ikan Bakar.jpg" alt="Pulut Ikan Bakar">
                <h3>Pulut Ikan Bakar</h3>
                <p>A traditional dish in Perlis, this meal consists of grilled fish served with sticky rice, offering a rich and smoky flavor.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Perlis/Harum Manis Mango.jpg" alt="Harum Manis Mango">
                <h3>Harum Manis Mango</h3>
                <p>Perlis is famous for its Harum Manis mangoes, known for their sweet taste and fragrant aroma, available during the fruiting season.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Perlis/Pek Nga.webp" alt="Pek Nga">
                <h3>Pek Nga</h3>
                <p>Pek Nga is a simple yet delicious coconut pancake, often served with a side of fish curry or sambal.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Perlis/Bubur Asyura.jpg" alt="Bubur Asyura">
                <h3>Bubur Asyura</h3>
                <p>Bubur Asyura is a thick porridge made with a variety of ingredients like meat, beans, and vegetables, prepared during the Islamic month of Muharram.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Perlis/Karipap Gergasi.jpg" alt="Karipap Gergasi">
                <h3>Karipap Gergasi</h3>
                <p>These giant curry puffs, filled with flavorful spiced potato or meat, are a popular snack in Perlis.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Perlis/Nasi Ulam.jpeg" alt="Nasi Ulam">
                <h3>Nasi Ulam</h3>
                <p>Nasi Ulam is a traditional rice dish mixed with various herbs and vegetables, offering a fresh and aromatic flavor.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Perlis/Sira Labu.jpg" alt="Sira Labu">
                <h3>Sira Labu</h3>
                <p>Sira Labu is a dessert made from cooked pumpkin in syrup, providing a sweet and soft texture that is well-loved in Perlis.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Perlis/Sambal Nyok.jpeg" alt="Sambal Nyok">
                <h3>Sambal Nyok</h3>
                <p>This unique dish uses young coconut meat cooked in spicy sambal, offering a mix of sweet and spicy flavors.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Perlis/Ikan Bakar.webp" alt="Ikan Bakar">
                <h3>Ikan Bakar</h3>
                <p>A staple in Perlis, grilled fish (Ikan Bakar) is served with sambal and rice, perfect for seafood lovers.</p>
            </div>
        </div>
    </section>

    <!-- Travel Tips Section -->
    <section class="travel-tips">
        <h2>Travel Tips for Perlis</h2>
        <div class="attraction-list">
            <div class="attraction-item">
                <h3>Best Time to Visit</h3>
                <p>The best time to visit Perlis is during the dry season from December to April, when the weather is pleasant for outdoor activities like hiking and exploring nature parks.</p>
            </div>

            <div class="attraction-item">
                <h3>How to Get There</h3>
                <p>
                    <strong>Flights:</strong> The nearest airport is in Alor Setar, Kedah, about 45 minutes' drive from Kangar, Perlis. You can also fly into Langkawi and take a ferry to Kuala Perlis.<br>
                    <strong>By Road:</strong> Perlis is accessible by car or bus from Kuala Lumpur (about 6-7 hours' drive). Regular buses and taxis operate from Alor Setar to Perlis.<br>
                    <strong>Trains:</strong> KTM’s Electric Train Service (ETS) connects Kuala Lumpur to Arau, Perlis, offering a scenic and convenient route.
                </p>
            </div>

            <div class="attraction-item">
                <h3>Currency</h3>
                <p>The official currency is the Malaysian Ringgit (MYR). It’s advisable to carry some cash, especially when visiting rural areas, as not all places accept cards.</p>
            </div>

            <div class="attraction-item">
                <h3>Language</h3>
                <p>The official language is Bahasa Malaysia, but English is commonly spoken, especially in tourist areas. Basic phrases in Malay may be helpful when interacting with locals in rural regions.</p>
            </div>

            <div class="attraction-item">
                <h3>Local Transportation</h3>
                <p>
                    <strong>Taxis & E-Hailing Services:</strong> Taxis are available, and e-hailing services like Grab are useful in major areas. However, in smaller towns, taxis or car rentals are recommended.<br>
                    <strong>Public Buses:</strong> Perlis has limited bus services, mainly connecting Kangar, Arau, and Kuala Perlis. Renting a car or using taxis is more convenient for exploring the state.
                </p>
            </div>

            <div class="attraction-item">
                <h3>Safety</h3>
                <p>Perlis is generally safe for tourists, with low crime rates. As with any destination, it’s wise to stay alert, especially when traveling to remote areas or markets.</p>
                <p><strong>Travel Insurance:</strong> Consider purchasing travel insurance that covers medical emergencies and trip cancellations for added peace of mind.</p>
            </div>

            <div class="attraction-item">
                <h3>Shopping & Bargaining</h3>
                <p>When shopping in local markets, bargaining is acceptable but always done respectfully. Popular items include handicrafts, local snacks, and souvenirs.</p>
            </div>

            <div class="attraction-item">
                <h3>Food Safety</h3>
                <p>Street food in Perlis is generally safe, and locals maintain high hygiene standards. Stick to food stalls that appear busy for fresher dishes. Bottled water is recommended over tap water.</p>
            </div>

            <div class="attraction-item">
                <h3>Respecting Local Customs</h3>
                <p>
                    <strong>Modest Dress:</strong> It is recommended to dress modestly, particularly when visiting religious or rural areas. Covering your shoulders and knees is appreciated.<br>
                    <strong>Mosques:</strong> Visitors can enter mosques, but proper attire is required. Women should cover their heads with a scarf when entering.
                </p>
            </div>

            <div class="attraction-item">
                <h3>Tipping</h3>
                <p>Tipping is not obligatory in Perlis, but small tips for good service at restaurants or when hiring guides are appreciated.</p>
            </div>

            <div class="attraction-item">
                <h3>Local Festivals</h3>
                <p>Key festivals in Perlis include Hari Raya Aidilfitri, Deepavali, and the Perlis East-West Highway Festival, where you can experience local culture and traditions through food, music, and performances.</p>
            </div>
        </div>
    </section>



    <!-- Map Section -->
    <section class="map">
        <h2>Map of Perlis</h2>
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d253712.06512627364!2d100.08027331848207!3d6.489865828829128!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x304c7916f2d4bdf9%3A0x675ec9fc75fcfb6f!2sPerlis!5e0!3m2!1sen!2smy!4v1727598576368!5m2!1sen!2smy" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </section>

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

    <script src="assets/js/johor.js"></script>
</body>

</html>