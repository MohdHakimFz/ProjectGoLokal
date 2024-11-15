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
    <title>Explore Kedah - GoLokal</title>
    <link rel="stylesheet" href="assets/css/kedah.css">
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
                        <a href="../Account Settings/Edit_profile.php">Account Settings</a>
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
    <section class="kedah-intro">
        <h1>Discover Kedah</h1>
        <img src="assets/image/Kedah/Flag Kedah.png" alt="Kedah Flag">
        <p>Kedah, often called the "Rice Bowl of Malaysia," is known for its lush paddy fields and beautiful Langkawi islands. Whether you're exploring its natural landscapes or its historical sites, Kedah offers a mix of rural charm and tropical island getaways.</p>
    </section>

    <!-- Top Attractions Section -->
    <section class="attractions">
        <h2>Top Attractions in Kedah</h2>
        <div class="attraction-list">
            <div class="attraction-item">
                <img src="assets/image/Kedah/Langkawi.webp" alt="Langkawi Island">
                <h3>Langkawi Island</h3>
                <p>Known as the Jewel of Kedah, Langkawi is a stunning archipelago with pristine beaches, clear waters, and lush forests. Popular spots include Pantai Cenang, Langkawi Sky Bridge, and the Langkawi Cable Car.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Kedah/Gunung Jerai.webp" alt="Gunung Jerai">
                <h3>Gunung Jerai</h3>
                <p>A scenic mountain offering breathtaking views of Kedah's landscape. It's a popular spot for hiking, and the cool, misty air makes it an ideal retreat for nature lovers.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Kedah/Kuala Kedah Fort.jpg" alt="Kota Kuala Kedah (Kuala Kedah Fort)">
                <h3>Kota Kuala Kedah (Kuala Kedah Fort)</h3>
                <p>A historical fortress built to defend Kedah from foreign invaders. It's an important cultural and historical site, offering insights into the state's past.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Kedah/Alor Setar.webp" alt="Alor Setar Tower">
                <h3>Alor Setar Tower</h3>
                <p>One of Malaysia’s tallest communication towers, offering panoramic views of Alor Setar and the surrounding countryside. There’s also a revolving restaurant at the top.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Kedah/Masjid Zahir.jpg" alt="Masjid Zahir">
                <h3>Masjid Zahir</h3>
                <p>One of the oldest and most beautiful mosques in Malaysia, Zahir Mosque is known for its striking architecture and rich history. It’s a symbol of Kedah’s Islamic heritage.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Kedah/Kedah Paddy Museum.jpg" alt="Kedah Paddy Museum">
                <h3>Kedah Paddy Museum</h3>
                <p>This unique museum showcases the history and techniques of rice cultivation, which is central to Kedah’s identity as the "Rice Bowl of Malaysia."</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Kedah/Pulau Payar.jpg" alt="Pulau Payar Marine Park">
                <h3>Pulau Payar Marine Park</h3>
                <p>A beautiful marine park located off the coast of Kedah, popular for snorkeling and diving, where visitors can explore vibrant coral reefs and marine life.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Kedah//Bukit Hijau Waterfall.jpg" alt="Bukit Hijau Waterfall">
                <h3>Bukit Hijau Waterfall</h3>
                <p>A serene nature spot with cascading waterfalls surrounded by lush greenery. It's perfect for picnics, swimming, and nature walks.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Kedah/Lembah Bujang.jpg" alt="Lembah Bujang Archaeological Museum">
                <h3>Lembah Bujang Archaeological Museum</h3>
                <p>This museum preserves the artifacts and ruins from the ancient Bujang Valley civilization, one of the earliest recorded civilizations in Southeast Asia, making it a must-visit for history buffs.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Kedah//taman jubli emas.jpg" alt="Taman Jubli Emas">
                <h3>Taman Jubli Emas</h3>
                <p>A popular recreational park in Alor Setar, featuring well-maintained gardens, walking paths, and a beautiful lake. It’s a peaceful spot for relaxation and leisure activities.</p>
            </div>
        </div>
    </section>

    <!-- Cultural Heritage Section -->
    <section class="culture">
        <h2>Cultural Heritage of Kedah</h2>
        <div class="attraction-list">
            <div class="attraction-item">
                <img src="assets/image/Kedah/Balai Nobat.jpg" alt="Balai Nobat">
                <h3>Balai Nobat</h3>
                <p>A royal ceremonial tower in Alor Setar, this structure is where royal musical instruments, including the nobat (a traditional royal orchestra), are stored. It’s a symbol of Kedah’s monarchy and traditions.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Kedah/Masjid Zahir.jpg" alt="Masjid Zahir">
                <h3>Masjid Zahir</h3>
                <p>One of the oldest and most beautiful mosques in Malaysia, located in Alor Setar. Built in 1912, it is a prominent symbol of Islamic architecture and Kedah’s religious heritage.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Kedah/Istana Anak Bukit.jpg" alt="Istana Anak Bukit">
                <h3>Istana Anak Bukit</h3>
                <p>The official residence of the Sultan of Kedah, this palace showcases traditional Malay royal architecture and plays a key role in the state's royal ceremonies.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Kedah/Balai Nobat.jpg" alt="Lembah Bujang">
                <h3>Lembah Bujang</h3>
                <p>This archaeological site is a treasure trove of Malaysia’s early civilization, dating back to the 2nd century. It features ancient Hindu-Buddhist temples and ruins, highlighting Kedah’s role as a trading hub in Southeast Asia.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Kedah//Pekan Rabu.jpg" alt="Pekan Rabu">
                <h3>Pekan Rabu</h3>
                <p>A traditional marketplace in Alor Setar, where locals sell handicrafts, traditional attire, and food. It’s a cultural hub for the people of Kedah, offering insight into the local Malay way of life.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Kedah/Rumah Tok Su.jpg" alt="Rumah Tok Su">
                <h3>Rumah Tok Su</h3>
                <p>A traditional Malay house that has been restored and preserved as part of the Kedah Heritage Village in Alor Setar. It’s an example of traditional Malay architecture and cultural heritage.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Kedah/Gunung Jerai.webp" alt="Gunung Jerai">
                <h3>Gunung Jerair</h3>
                <p>Known for its cultural and historical significance, this mountain was once a navigational point for ancient traders. It is also associated with local myths and legends, reflecting Kedah’s connection to nature and history.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Kedah/Muzium Negeri Kedah.jpeg" alt="Muzium Negeri Kedah">
                <h3>Muzium Negeri Kedah</h3>
                <p>The Kedah State Museum offers a glimpse into the state's history, culture, and heritage. It showcases artifacts related to the Kedah Sultanate, traditional Malay lifestyle, and archaeological finds from the Bujang Valley.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Kedah//Wan Mat Saman Canal.jpg" alt="Wan Mat Saman Canal">
                <h3>Wan Mat Saman Canal</h3>
                <p>The longest canal in Malaysia, built during the 19th century under the reign of Sultan Abdul Hamid Halim. It’s a symbol of the state’s agricultural heritage, as it was constructed to boost rice cultivation.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Kedah/Kota Kuala Kedah.jpeg" alt="Kota Kuala Kedah">
                <h3>Kota Kuala Kedah</h3>
                <p>Also known as Fort Kuala Kedah, this historical site dates back to the 17th century. It played a pivotal role in defending Kedah from foreign invaders and showcases the state's military history and strategic importance.</p>
            </div>

        </div>
    </section>

    <!-- Adventure & Nature Section -->
    <section class="adventure">
        <h2>Adventure & Nature in Kedah</h2>
        <div class="attraction-list">
            <div class="attraction-item">
                <img src="assets/image/Kedah/Gunung Jerai.webp" alt="Gunung Jerai">
                <h3>Gunung Jerai</h3>
                <p>Gunung Jerai offers breathtaking views and a cool climate, making it a perfect spot for hiking and nature photography.</p>
                <h4>Activities: Hiking, nature walks, and photography</h4>
                <h4>Location: Yan, Kedah</h4>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Kedah/Langkawi Sky Bridge.avif" alt="Langkawi Sky Bridge">
                <h3>Langkawi Sky Bridge</h3>
                <p>Take a thrilling walk across the Langkawi Sky Bridge, a curved pedestrian bridge with stunning views of the Langkawi islands.</p>
                <h4>Activities: Sightseeing, walking, and photography</h4>
                <h4>Location: Langkawi, Kedah</h4>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Kedah/Kilim Geoforest Park.jpg" alt="Kilim Geoforest Park">
                <h3>Kilim Geoforest Park</h3>
                <p>Explore the rich mangrove forests and limestone formations of Kilim Geoforest Park, a UNESCO Global Geopark.</p>
                <h4>Activities: Boating, wildlife watching, and cave exploration</h4>
                <h4>Location: Langkawi, Kedah</h4>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Kedah/Telaga Tujuh Waterfalls.jpg" alt="Telaga Tujuh Waterfalls">
                <h3>Telaga Tujuh Waterfalls</h3>
                <p>Also known as Seven Wells, this beautiful waterfall is a popular spot for swimming and picnicking amidst lush greenery.</p>
                <h4>Activities: Swimming, hiking, and picnicking</h4>
                <h4>Location: Langkawi, Kedah</h4>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Kedah/Bukit Hijau Waterfall.jpg" alt="Bukit Hijau Waterfall">
                <h3>Bukit Hijau Waterfall</h3>
                <p>Located within a forest reserve, Bukit Hijau Waterfall is a serene retreat with cool, crystal-clear waters and scenic trails.</p>
                <h4>Activities: Swimming, hiking, and camping</h4>
                <h4>Location: Baling, Kedah</h4>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Kedah/Tree Top Walk Sungai Sedim.png" alt="Tree Top Walk Sungai Sedim">
                <h3>Tree Top Walk Sungai Sedim</h3>
                <p>Walk among the treetops on this canopy walkway, offering a unique perspective of the forest and its wildlife.</p>
                <h4>Activities: Canopy walking, bird watching, and nature exploration</h4>
                <h4>Location: Kulim, Kedah</h4>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Kedah/Pulau Payar.jpg" alt="Pulau Payar Marine Park">
                <h3>Pulau Payar Marine Park</h3>
                <p>Dive into the underwater wonders of Pulau Payar Marine Park, known for its vibrant coral reefs and rich marine life.</p>
                <h4>Activities: Snorkeling, scuba diving, and marine exploration</h4>
                <h4>Location: Langkawi, Kedah</h4>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Kedah/Ulu Muda Eco Park.jpg" alt="Ulu Muda Eco Park">
                <h3>Ulu Muda Eco Park</h3>
                <p>An off-the-beaten-path adventure spot, Ulu Muda offers dense jungle treks, wildlife watching, and river safaris.</p>
                <h4>Activities: Jungle trekking, wildlife watching, and river safaris</h4>
                <h4>Location: Sik, Kedah</h4>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Kedah/Langkawi Cable Car.jpg" alt="Langkawi Cable Car">
                <h3>Langkawi Cable Car</h3>
                <p>Enjoy panoramic views of Langkawi from the Langkawi Cable Car, which takes you to the top of Gunung Mat Cincang.</p>
                <h4>Activities: Cable car rides, sightseeing, and photography</h4>
                <h4>Location: Langkawi, Kedah</h4>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Kedah/Tasik Pedu.jpg" alt="Tasik Pedu">
                <h3>Tasik Pedu</h3>
                <p>One of Kedah's largest lakes, Tasik Pedu offers serene views and opportunities for fishing, boating, and bird watching.</p>
                <h4>Activities: Fishing, boating, and nature observation</h4>
                <h4>Location: Padang Terap, Kedah</h4>
            </div>
        </div>
    </section>


    <!-- Food & Cuisine Section -->
    <section class="cuisine">
        <h2>Food & Cuisine in Kedah</h2>
        <div class="attraction-list">
            <div class="attraction-item">
                <img src="assets/image/Kedah/Nasi Ulam.webp" alt="Nasi Ulam">
                <h3>Nasi Ulam</h3>
                <p>A traditional Kedah dish, Nasi Ulam is rice mixed with various local herbs, served with salted fish, sambal, and ulam (fresh herbs).</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Kedah/Gulai Nangka.jpg" alt="Gulai Nangka">
                <h3>Gulai Nangka</h3>
                <p>Gulai Nangka is a traditional coconut-based curry made with young jackfruit, commonly enjoyed with rice in Kedah.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Kedah/Nasi Lemuni.jpg" alt="Nasi Lemuni">
                <h3>Nasi Lemuni</h3>
                <p>A unique herbal rice dish made with lemuni leaves, commonly eaten for breakfast in Kedah, often served with boiled eggs and sambal.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Kedah/Ayam Masak Merah.jpg" alt="Ayam Masak Merah">
                <h3>Ayam Masak Merah</h3>
                <p>A sweet and spicy tomato-based chicken dish, Ayam Masak Merah is a staple in Kedah's traditional cuisine, often served at weddings and festivals.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Kedah/Pek Nga.webp" alt="Pek Nga">
                <h3>Pek Nga</h3>
                <p>A popular Kedah snack, Pek Nga is a type of coconut pancake, typically served with curry or sambal, making it a savory treat.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Kedah/Laksa Kedah.jpg" alt="Laksa Kedah">
                <h3>Laksa Kedah</h3>
                <p>Laksa Kedah is a favorite in the state, made with thick rice noodles served in a spicy and tangy fish-based broth, topped with fresh herbs and vegetables.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Kedah/Pulut Kuning.jpg" alt="Pulut Kuning">
                <h3>Pulut Kuning</h3>
                <p>A traditional glutinous rice dish dyed yellow with turmeric, Pulut Kuning is often served during special occasions with beef rendang or chicken curry.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Kedah/Ikan Bakar Petai.jpg" alt="Ikan Bakar Petai">
                <h3>Ikan Bakar Petai</h3>
                <p>Ikan Bakar Petai is grilled fish marinated with sambal and petai beans (bitter beans), offering a strong and flavorful combination enjoyed by many in Kedah.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Kedah/Rendang Tok.jpg" alt="Rendang Tok">
                <h3>Rendang Tok</h3>
                <p>Rendang Tok is a slow-cooked dry beef curry, rich in spices and herbs, traditionally served during festive occasions in Kedah.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Kedah/Serabai.jpg" alt="Serabai">
                <h3>Serabai</h3>
                <p>Serabai is a traditional Kedah pancake made from rice flour, typically served with a sweet or savory coconut-based sauce.</p>
            </div>
        </div>
    </section>


    <!-- Travel Tips Section -->
    <section class="travel-tips">
        <h2>Travel Tips for Kedah</h2>
        <div class="attraction-list">
            <div class="attraction-item">
                <h3>Best Time to Visit</h3>
                <p>The best time to visit Kedah is from December to March, as the weather is cooler and more pleasant for outdoor activities. Avoid the rainy season from April to October when heavy downpours can occur.</p>
            </div>

            <div class="attraction-item">
                <h3>How to Get There</h3>
                <p>
                    <strong>Flights:</strong> Kedah's main airport is Sultan Abdul Halim Airport (AOR) in Alor Setar, and Langkawi International Airport (LGK) serves Langkawi. Both airports offer flights to/from major Malaysian cities.<br>
                    <strong>By Road:</strong> Kedah is accessible by car from Penang (1-2 hours) and Kuala Lumpur (about 5-6 hours). Buses and taxis are also available for long-distance travel.<br>
                    <strong>Ferries:</strong> For Langkawi, you can take a ferry from Kuala Kedah or Penang, making it a scenic option for reaching the island.
                </p>
            </div>

            <div class="attraction-item">
                <h3>Currency</h3>
                <p>The currency in Kedah is Malaysian Ringgit (MYR). Credit cards are accepted in most hotels and restaurants, but it's recommended to carry cash for local markets, food stalls, and rural areas.</p>
            </div>

            <div class="attraction-item">
                <h3>Language</h3>
                <p>Bahasa Malaysia is the official language, but English is widely spoken in tourist spots, especially in Langkawi and Alor Setar. You'll find it easy to communicate in English for general travel needs.</p>
            </div>

            <div class="attraction-item">
                <h3>Local Transportation</h3>
                <p>
                    <strong>Public Buses:</strong> Local buses operate in major towns like Alor Setar, but they can be slow. Langkawi has a limited public transport network.<br>
                    <strong>Taxis & E-Hailing Services:</strong> Grab is available in larger towns and on Langkawi, offering a convenient way to travel.<br>
                    <strong>Car Rentals:</strong> Renting a car is the most convenient way to explore Kedah, especially in rural areas and Langkawi, where public transport is scarce.
                </p>
            </div>

            <div class="attraction-item">
                <h3>Safety</h3>
                <p>Kedah is generally safe for tourists, but it's always a good idea to stay cautious of petty crimes like pickpocketing in crowded areas. On Langkawi, always be aware of your surroundings while hiking or visiting remote beaches.</p>
                <p><strong>Travel Insurance:</strong> Ensure you have travel insurance covering health emergencies and trip cancellations, especially if you're planning adventure activities like hiking or island hopping.</p>
            </div>

            <div class="attraction-item">
                <h3>Shopping & Bargaining</h3>
                <p>Kedah offers a range of shopping experiences, from modern malls in Alor Setar to traditional markets and night bazaars. Bargaining is common in local markets, so feel free to negotiate politely.</p>
            </div>

            <div class="attraction-item">
                <h3>Food Safety</h3>
                <p>Food stalls and street vendors in Kedah are generally safe, but it's best to choose busy stalls to ensure fresh food. In Langkawi, beachfront eateries are popular but check for cleanliness.</p>
                <p><strong>Tap Water:</strong> Tap water is not recommended for drinking in Kedah. Always drink bottled or filtered water to avoid any health issues.</p>
            </div>

            <div class="attraction-item">
                <h3>Respecting Local Customs</h3>
                <p>
                    <strong>Modest Dress:</strong> Dress modestly when visiting rural areas, mosques, or religious sites, particularly in Kedah’s mainland. In Langkawi, the atmosphere is more relaxed, but it's still a good idea to dress respectfully.<br>
                    <strong>Mosques:</strong> If visiting mosques, remove your shoes before entering, and women should wear a headscarf. Always be respectful of local religious practices.<br>
                    <strong>Greetings:</strong> When greeting locals, a simple smile or nod is appreciated. Handshakes are acceptable, but always use both hands for extra respect.
                </p>
            </div>

            <div class="attraction-item">
                <h3>Tipping</h3>
                <p>Tipping is not customary in Kedah, but it’s becoming more common in tourist areas like Langkawi. Rounding up the bill or leaving small tips at restaurants is appreciated but not expected.</p>
            </div>

            <div class="attraction-item">
                <h3>Local Festivals</h3>
                <p>Kedah hosts many cultural and religious festivals throughout the year, such as Hari Raya Aidilfitri, Deepavali, and Chinese New Year. The Langkawi International Maritime and Aerospace Exhibition (LIMA) is a major event attracting tourists and professionals.</p>
            </div>
        </div>
    </section>


    <!-- Map Section -->
    <section class="map">
        <h2>Map of Kedah</h2>
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2032296.001489955!2d99.05550720099777!3d5.809250823684342!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x304976135f4045a1%3A0x6ce483110aab4ea4!2sKedah!5e0!3m2!1sen!2smy!4v1727543899544!5m2!1sen!2smy" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
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