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
    <title>Explore Penang - GoLokal</title>
    <link rel="stylesheet" href="assets/css/Penang.css">
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
    <section class="penang-intro">
        <h1>Discover Penang</h1>
        <img src="assets/image/Pulau Pinang/Penang Flag.png" alt="Penang Flag">
        <p>Penang, known as the "Pearl of the Orient," offers a unique blend of modernity and history. Famous for its UNESCO-listed George Town, street food, and cultural diversity, Penang is the perfect spot for history buffs and food lovers alike.</p>
    </section>

    <!-- Top Attractions Section -->
    <section class="attractions">
        <h2>Top Attractions in Penang</h2>
        <div class="attraction-list">
            <div class="attraction-item">
                <img src="assets/image/Pulau Pinang/Pulau Pinang Penang Hill.jpg" alt="Penang Hill">
                <h3>Penang Hill</h3>
                <p>Enjoy stunning views of George Town and the surrounding area from the peak of Penang Hill, accessible by the famous funicular railway.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Pulau Pinang/Kek Lok Si Temple.jpg" alt="Kek Lok Si Temple">
                <h3>Kek Lok Si Temple</h3>
                <p>Kek Lok Si is one of the largest and most beautiful Buddhist temples in Southeast Asia, featuring a stunning pagoda and statue of the Goddess of Mercy.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Pulau Pinang/George Town.jpg" alt="George Town">
                <h3>George Town</h3>
                <p>Wander through the UNESCO World Heritage Site of George Town, known for its historical architecture, vibrant street art, and delicious food scene.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Pulau Pinang/ESCAPE Theme Park.jpg" alt="ESCAPE Theme Park">
                <h3>ESCAPE Theme Park</h3>
                <p>An eco-friendly adventure park offering activities like zip-lining, obstacle courses, and water slides, perfect for family fun in Penang.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Pulau Pinang/Penang National Park.jpg" alt="Penang National Park">
                <h3>Penang National Park</h3>
                <p>Discover the natural beauty of Penang National Park, home to pristine beaches, rainforests, and hiking trails leading to the famous Monkey Beach.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Pulau Pinang/Clan Jetties.jpg" alt="Clan Jetties">
                <h3>Clan Jetties</h3>
                <p>Explore the traditional Chinese stilt houses at the Clan Jetties, a historic waterfront village offering a glimpse into Penang's multicultural heritage.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Pulau Pinang/Pinang Peranakan Mansion.jpeg" alt="Pinang Peranakan Mansion">
                <h3>Pinang Peranakan Mansion</h3>
                <p>Step back in time at the Pinang Peranakan Mansion, a beautifully restored museum showcasing the opulent lifestyle of the Peranakan or Straits Chinese community.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Pulau Pinang/Penang Botanic Gardens.png" alt="Penang Botanic Gardens">
                <h3>Penang Botanic Gardens</h3>
                <p>Relax and unwind at the Penang Botanic Gardens, a lush green space offering walking trails, diverse plant species, and the famous Monkey Garden.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Pulau Pinang/Entopia Butterfly Farm.jpg" alt="Entopia Butterfly Farm">
                <h3>Entopia Butterfly Farm</h3>
                <p>Visit Entopia Butterfly Farm, an interactive sanctuary where you can walk among thousands of free-flying butterflies in a beautifully landscaped garden.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Pulau Pinang/Fort Cornwallis.jpg" alt="Fort Cornwallis">
                <h3>Fort Cornwallis</h3>
                <p>Learn about Penang’s colonial history at Fort Cornwallis, the largest standing fort in Malaysia, offering guided tours and cultural performances.</p>
            </div>
        </div>
    </section>


    <!-- Cultural Heritage Section -->
    <section class="culture">
        <h2>Cultural Heritage of Penang</h2>
        <div class="attraction-list">
            <div class="attraction-item">
                <img src="assets/image/Pulau Pinang/Pinang Peranakan Mansion.jpeg" alt="Pinang Peranakan Mansion">
                <h3>Pinang Peranakan Mansion</h3>
                <p>Step back in time at the Pinang Peranakan Mansion, a beautifully restored museum showcasing the opulent lifestyle of the Peranakan or Straits Chinese community.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Pulau Pinang/Khoo Kongsi.jpg" alt="Khoo Kongsi">
                <h3>Khoo Kongsi</h3>
                <p>Khoo Kongsi is one of the most famous clan houses in Malaysia, known for its intricate carvings and grand architecture, symbolizing the wealth and influence of the Khoo family.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Pulau Pinang/Cheong Fatt Tze Mansion (The Blue Mansion).jpg" alt="Cheong Fatt Tze Mansion">
                <h3>Cheong Fatt Tze Mansion (The Blue Mansion)</h3>
                <p>The Cheong Fatt Tze Mansion, also known as the Blue Mansion, is a beautifully preserved heritage building that reflects Penang’s colonial past and Chinese influences.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Pulau Pinang/George Town Street Art.jpg" alt="George Town Street Art">
                <h3>George Town Street Art</h3>
                <p>Explore the famous George Town street art, an open-air gallery featuring murals and installations that tell the story of Penang’s history, culture, and people.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Pulau Pinang/Sun Yat Sen Museum.jpeg" alt="Sun Yat Sen Museum">
                <h3>Sun Yat Sen Museum</h3>
                <p>Discover the historical significance of the Sun Yat Sen Museum, where the Chinese revolutionary leader lived and planned part of the 1911 Chinese Revolution, making it a vital piece of Penang’s cultural heritage.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Pulau Pinang/Snake Temple.jpg" alt="Snake Temple">
                <h3>Snake Temple</h3>
                <p>The Snake Temple is a unique cultural landmark in Penang, known for the venomous pit vipers that reside here, considered sacred by the temple’s followers.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Pulau Pinang/St. George's Church.webp" alt="St. George's Church">
                <h3>St. George's Church</h3>
                <p>St. George's Church is the oldest Anglican church in Southeast Asia, showcasing Penang’s British colonial heritage through its stunning architecture.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Pulau Pinang/Fort Cornwallis.jpg" alt="Fort Cornwallis">
                <h3>Fort Cornwallis</h3>
                <p>Fort Cornwallis is the largest standing fort in Malaysia, built by the British East India Company and an important symbol of Penang's colonial history.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Pulau Pinang/Kapitan Keling Mosque.jpg" alt="Kapitan Keling Mosque">
                <h3>Kapitan Keling Mosque</h3>
                <p>The Kapitan Keling Mosque is one of Penang’s most iconic religious landmarks, built by the Indian Muslim community in the 19th century.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Pulau Pinang/Wat Chaiya Mangkalaram.jpg" alt="Wat Chaiya Mangkalaram">
                <h3>Wat Chaiya Mangkalaram</h3>
                <p>Wat Chaiya Mangkalaram is a Thai Buddhist temple in Penang, famous for its large Reclining Buddha statue, one of the largest in the world.</p>
            </div>

        </div>
    </section>


    <!-- Adventure & Nature Section -->
    <section class="adventure">
        <h2>Adventure & Nature in Penang</h2>
        <div class="attraction-list">
            <div class="attraction-item">
                <img src="assets/image/Pulau Pinang/Pulau Pinang Penang Hill.jpg" alt="Penang Hill">
                <h3>Penang Hill</h3>
                <p>Take a funicular train ride up to Penang Hill and enjoy stunning panoramic views, cool breezes, and nature trails.</p>
                <h4>Activities: Hiking, bird watching, sightseeing</h4>
                <h4>Location: George Town, Penang</h4>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Pulau Pinang/Penang National Park.jpg" alt="Penang National Park">
                <h3>Penang National Park</h3>
                <p>Explore the biodiversity of Penang National Park, featuring jungle trekking trails, beautiful beaches, and the famous canopy walk.</p>
                <h4>Activities: Jungle trekking, bird watching, beach activities</h4>
                <h4>Location: Teluk Bahang, Penang</h4>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Pulau Pinang/Monkey Beach.jpg" alt="Monkey Beach">
                <h3>Monkey Beach</h3>
                <p>A pristine beach located within Penang National Park, famous for its white sands, clear waters, and playful monkeys.</p>
                <h4>Activities: Swimming, beach activities, jungle trekking</h4>
                <h4>Location: Teluk Bahang, Penang</h4>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Pulau Pinang/ESCAPE Theme Park.jpg" alt="Escape Theme Park">
                <h3>Escape Theme Park</h3>
                <p>A popular adventure park with thrilling outdoor activities, including zip-lining, obstacle courses, and water slides.</p>
                <h4>Activities: Zip-lining, water park, adventure activities</h4>
                <h4>Location: Teluk Bahang, Penang</h4>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Pulau Pinang/Teluk Bahang Dam.jpg" alt="Teluk Bahang Dam">
                <h3>Teluk Bahang Dam</h3>
                <p>Relax by the scenic Teluk Bahang Dam, a popular spot for picnics, nature walks, and outdoor photography.</p>
                <h4>Activities: Picnicking, photography, nature walks</h4>
                <h4>Location: Teluk Bahang, Penang</h4>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Pulau Pinang/Batu Ferringhi Beach.webp" alt="Batu Ferringhi Beach">
                <h3>Batu Ferringhi Beach</h3>
                <p>Famous for its golden sands and vibrant night market, Batu Ferringhi Beach is a perfect destination for water sports and beachside relaxation.</p>
                <h4>Activities: Jet skiing, parasailing, beach activities</h4>
                <h4>Location: Batu Ferringhi, Penang</h4>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Pulau Pinang/Entopia Butterfly Farm.jpg" alt="Entopia by Penang Butterfly Farm">
                <h3>Entopia by Penang Butterfly Farm</h3>
                <p>Discover over 15,000 free-flying butterflies in this interactive sanctuary that’s a must-visit for nature lovers.</p>
                <h4>Activities: Nature walks, photography, interactive exhibits</h4>
                <h4>Location: Teluk Bahang, Penang</h4>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Pulau Pinang/Adventure Zone.jpg" alt="Adventure Zone">
                <h3>Adventure Zone</h3>
                <p>An indoor adventure park offering fun slides, obstacle courses, and activities for both kids and adults.</p>
                <h4>Activities: Obstacle courses, slides, adventure activities</h4>
                <h4>Location: Batu Ferringhi, Penang</h4>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Pulau Pinang/Teluk Kampi.jpg" alt="Teluk Kampi">
                <h3>Teluk Kampi</h3>
                <p>Known as the longest beach in Penang National Park, Teluk Kampi offers a secluded paradise perfect for beach lovers and campers.</p>
                <h4>Activities: Camping, swimming, nature exploration</h4>
                <h4>Location: Teluk Bahang, Penang</h4>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Pulau Pinang/The Habitat Penang Hill.jpg" alt="The Habitat Penang Hill">
                <h3>The Habitat Penang Hill</h3>
                <p>Experience the beauty of Penang's rainforest with canopy walks, scenic views, and guided nature tours at The Habitat Penang Hill.</p>
                <h4>Activities: Canopy walks, guided tours, nature photography</h4>
                <h4>Location: Penang Hill, Penang</h4>
            </div>
        </div>
    </section>

    <!-- Food & Cuisine Section -->
    <section class="cuisine">
        <h2>Food & Cuisine in Penang</h2>
        <div class="attraction-list">
            <div class="attraction-item">
                <img src="assets/image/Pulau Pinang/Char Kway Teow.webp" alt="Char Kway Teow">
                <h3>Char Kway Teow</h3>
                <p>A famous Penang street food, Char Kway Teow is a stir-fried flat noodle dish with prawns, eggs, and bean sprouts, cooked over high heat for a smoky flavor.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Pulau Pinang/Penang Assam Laksa.JPG" alt="Penang Asam Laksa">
                <h3>Penang Asam Laksa</h3>
                <p>A tangy and spicy fish-based noodle soup, Asam Laksa is a must-try dish in Penang, made with mackerel, tamarind, and various herbs.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Pulau Pinang/Penang Hokkien Mee.webp" alt="Penang Hokkien Mee">
                <h3>Penang Hokkien Mee</h3>
                <p>A flavorful noodle soup made with a rich shrimp and pork broth, Hokkien Mee is served with egg noodles, prawns, pork slices, and a spicy sambal sauce.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Pulau Pinang/Roti Canai.jpeg" alt="Roti Canai">
                <h3>Roti Canai</h3>
                <p>A flaky flatbread commonly eaten for breakfast, Roti Canai is often served with dhal curry or a side of sugar.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Pulau Pinang/Penang Cendol.jpg" alt="Penang Cendol">
                <h3>Penang Cendol</h3>
                <p>A refreshing dessert made with shaved ice, coconut milk, green rice flour jelly, and palm sugar syrup. Penang Cendol is the perfect treat for a hot day.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Pulau Pinang/Nasi Kandar.jpeg" alt="Nasi Kandar">
                <h3>Nasi Kandar</h3>
                <p>A signature Penang dish, Nasi Kandar consists of steamed rice served with a variety of curries, meats, and vegetables, known for its rich and spicy flavors.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Pulau Pinang/Lor Bak.jpg" alt="Lor Bak">
                <h3>Lor Bak</h3>
                <p>Lor Bak is a deep-fried roll made of marinated minced pork wrapped in beancurd skin, served with a dipping sauce. It’s a popular Penang street food.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Pulau Pinang/Penang Rojak.jpg" alt="Penang Rojak">
                <h3>Penang Rojak</h3>
                <p>Penang Rojak is a fruit and vegetable salad mixed with a thick, sweet, and spicy shrimp paste, topped with crushed peanuts for added crunch.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Pulau Pinang/Ais Kacang.jpeg" alt="Ais Kacang">
                <h3>Ais Kacang</h3>
                <p>A popular shaved ice dessert topped with sweet syrup, red beans, corn, and jelly, Ais Kacang is a favorite in Penang for cooling down in the tropical heat.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Pulau Pinang/Oyster Omelette.jpg" alt="Oyster Omelette">
                <h3>Oyster Omelette</h3>
                <p>A crispy and savory omelette mixed with fresh oysters, this Penang specialty is known for its rich flavors and is often enjoyed at night markets.</p>
            </div>
        </div>
    </section>


    <!-- Travel Tips Section -->
    <section class="travel-tips">
        <h2>Travel Tips for Penang</h2>
        <div class="attraction-list">
            <div class="attraction-item">
                <h3>Best Time to Visit</h3>
                <p>The best time to visit Penang is between November and February when the weather is cool and less humid. Avoid visiting during the monsoon season (September to October).</p>
            </div>

            <div class="attraction-item">
                <h3>How to Get There</h3>
                <p>
                    <strong>Flights:</strong> Penang International Airport (PEN) connects the island to major cities in Malaysia and abroad.<br>
                    <strong>By Road:</strong> Penang Bridge and Sultan Abdul Halim Muadzam Shah Bridge connect the island to the mainland.<br>
                    <strong>Ferry:</strong> Ferries run from Langkawi and Butterworth to Penang.
                </p>
            </div>

            <div class="attraction-item">
                <h3>Currency</h3>
                <p>The official currency is the Malaysian Ringgit (MYR). While cards are accepted in many places, carry cash for smaller purchases at markets or street vendors.</p>
            </div>

            <div class="attraction-item">
                <h3>Language</h3>
                <p>The official language is Malay, but English is widely spoken, particularly in tourist areas. You’ll also hear Mandarin, Tamil, and Hokkien.</p>
            </div>

            <div class="attraction-item">
                <h3>Local Transportation</h3>
                <p>
                    <strong>Buses:</strong> Rapid Penang operates the island’s public bus network.<br>
                    <strong>Grab:</strong> E-hailing services like Grab are popular for getting around Penang.<br>
                    <strong>Bicycles and Scooters:</strong> Rent bicycles or scooters to explore the island at your own pace.
                </p>
            </div>

            <div class="attraction-item">
                <h3>Food Safety</h3>
                <p>Penang's street food is renowned, but it’s best to eat from busy stalls where the food is fresh. Drink bottled or boiled water to stay safe.</p>
            </div>

            <div class="attraction-item">
                <h3>Respecting Local Customs</h3>
                <p>
                    <strong>Modest Dress:</strong> Wear modest clothing when visiting temples or mosques.<br>
                    <strong>Shoes Off:</strong> Always remove your shoes before entering religious sites.<br>
                    <strong>Greetings:</strong> A nod or slight bow is common, and a gentle handshake is preferred with Muslims.
                </p>
            </div>

            <div class="attraction-item">
                <h3>Shopping & Bargaining</h3>
                <p>Bargaining is common in local markets but less so in malls. Be polite and respectful while negotiating at places like Batu Ferringhi Night Market.</p>
            </div>

            <div class="attraction-item">
                <h3>Safety</h3>
                <p>Penang is generally safe, but take precautions against pickpockets in crowded areas. Avoid walking alone late at night, especially in poorly lit places.</p>
            </div>

            <div class="attraction-item">
                <h3>Local Festivals</h3>
                <p>Penang hosts festivals such as George Town Festival, Thaipusam, and Chinese New Year. Visiting during these times allows for a deeper cultural experience.</p>
            </div>
        </div>
    </section>



    <!-- Map Section -->
    <section class="map">
        <h2>Map of Penang</h2>
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d254234.34581497626!2d100.19818842763364!3d5.353981927911573!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x304a9403095390dd%3A0x29c305a5f38f633f!2sPenang!5e0!3m2!1sen!2smy!4v1727602021433!5m2!1sen!2smy" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
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