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
    <title>Explore Johor - GoLokal</title>
    <link rel="stylesheet" href="assets/css/johor.css">
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
                        <li><a href="../Learn/Learn.php">Learn</a></li>
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
    <section class="johor-intro">
        <h1>Discover Johor</h1>
        <img src="assets/image/Johor/Flag Johor.png" alt="Johor Flag">
        <p>Johor is a beautiful state in southern Malaysia known for its pristine beaches, vibrant culture, and historical landmarks. Whether you're seeking adventure, relaxation, or a taste of Malaysian heritage, Johor has something for everyone.</p>
    </section>

    <!-- Top Attractions Section -->
    <section class="attractions">
        <h2>Top Attractions in Johor</h2>
        <div class="attraction-list">
            <div class="attraction-item">
                <img src="assets/image/Johor/Legoland.jpg" alt="Legoland">
                <h3>Legoland Malaysia</h3>
                <p>Experience a world of adventure and excitement at Legoland Malaysia, perfect for families and thrill-seekers alike.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Johor/Desaru Beach.jpg" alt="Desaru Beach">
                <h3>Desaru Beach</h3>
                <p>Relax on the golden sands of Desaru Beach, one of Johor's most picturesque coastal spots.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Johor/Johor Istana Bukit Serene.jpg" alt="Istana Bukit Serene">
                <h3>Istana Bukit Serene</h3>
                <p>Visit the royal palace, Istana Bukit Serene, home to the Sultan of Johor and a symbol of Johor's regal heritage.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Johor/Sultan Abu Bakar State Mosque.jpg" alt="Sultan Abu Bakar State Mosque">
                <h3>Sultan Abu Bakar State Mosque</h3>
                <p>A stunning blend of Victorian and Moorish architectural styles, this mosque is one of the most important religious landmarks in Johor.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Johor/Johor Bahru City Square.jpg" alt="Johor Bahru City Square">
                <h3>Johor Bahru City Square</h3>
                <p>One of the largest shopping complexes in Johor Bahru with a variety of retail outlets, dining options, and entertainment facilities.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Johor/Tanjung Piai National Park.jpg" alt="Tanjung Piai National Park">
                <h3>Tanjung Piai National Park</h3>
                <p> This park marks the southernmost tip of mainland Asia and offers mangrove forests, scenic views, and opportunities to observe unique flora and fauna.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Johor/Kota Tinggi Waterfalls.jpg" alt="Kota Tinggi Waterfalls">
                <h3>Kota Tinggi Waterfalls</h3>
                <p>A popular nature attraction with cascading waterfalls, perfect for picnics, swimming, and hiking.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Johor/Danga Bay.jpg" alt="Danga Bay">
                <h3>Danga Bay</h3>
                <p>A waterfront development offering shopping, dining, and entertainment options with beautiful views of the Straits of Johor.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Johor/Sultan Ibrahim Building.jpg" alt="Sultan Ibrahim Building">
                <h3>Sultan Ibrahim Building</h3>
                <p>An iconic historical building with unique architecture, formerly the seat of the Johor state government.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Johor/Pulau Rawa.jpg" alt="Pulau Rawa">
                <h3>Pulau Rawa</h3>
                <p> A pristine island off the coast of Johor, known for its clear waters, white sandy beaches, and vibrant coral reefs, ideal for snorkeling and diving.</p>
            </div>
        </div>
    </section>

    <!-- Cultural Heritage Section -->
    <section class="culture">
        <h2>Cultural Heritage of Johor</h2>
        <div class="attraction-list">
            <div class="attraction-item">
                <img src="assets/image/Johor/Muzium Tokoh Negara.jpeg" alt="Muzium Tokoh Johor">
                <h3>Muzium Tokoh Johor</h3>
                <p>Learn about Johor's notable figures and their contributions to Malaysian history.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Johor/Pasar Karat.jpg" alt="Pasar Karat">
                <h3>Pasar Karat</h3>
                <p>Explore the bustling night market in Johor Bahru and discover antiques, street food, and local handicrafts.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Johor/Johor Heritage Trail.jpg" alt="Johor Heritage Trail">
                <h3>Johor Heritage Trail</h3>
                <p>Walk through the city's historical landmarks and learn about Johor's royal and colonial history.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Johor/Sultan Abu Bakar Royal Museum.jpeg" alt="Sultan Abu Bakar Royal Museum">
                <h3>Sultan Abu Bakar Royal Museum</h3>
                <p> Housed in the Grand Palace, this museum showcases Johor’s royal history, displaying a vast collection of royal artifacts, including regalia, weaponry, and historical documents.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Johor/Sultan Abu Bakar State Mosque.jpg" alt="Sultan Abu Bakar State Mosque">
                <h3>Sultan Abu Bakar State Mosque</h3>
                <p>A stunning blend of Victorian and Moorish architectural styles, this mosque is one of the most important religious landmarks in Johor.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Johor/Istana Besar (The Grand Palace).jpg" alt="Istana Besar (The Grand Palace)">
                <h3>Istana Besar (The Grand Palace)</h3>
                <p> Built in 1866, this royal palace is an architectural marvel and houses the Royal Museum. The palace symbolizes Johor's royal lineage and history.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Johor/Festival Zapin Johor.jpg" alt="Festival Zapin Johor">
                <h3>Festival Zapin Johor</h3>
                <p> The Zapin dance is an integral part of Johor’s cultural heritage. The annual Festival Zapin Johor celebrates this traditional Malay dance, which was historically performed at royal gatherings.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Johor/Kampung Johor Lama.jpg" alt="Kampung Johor Lama">
                <h3>Kampung Johor Lama (Old Johor Village)</h3>
                <p>A historical village and former stronghold of the Johor Sultanate, this site is important for understanding Johor’s resistance against foreign invaders in the 16th century.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Johor/Laksamana Bentan Mausoleum.jpg" alt="Laksamana Bentan Mausoleum">
                <h3>Laksamana Bentan Mausoleum</h3>
                <p>The resting place of the legendary Malay warrior Laksamana Bentan, known for his bravery in defending Johor. The mausoleum is a site of historical significance for the Johor Sultanate.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Johor/Chinese Ancestral Temples.jpg" alt="Chinese Ancestral Temples">
                <h3>Chinese Ancestral Temples</h3>
                <p>Johor is home to several Chinese ancestral temples, which reflect the strong Chinese influence in the state. The Johor Old Chinese Temple in Johor Bahru is a famous landmark and a center for the annual Chingay parade.</p>
            </div>

        </div>
    </section>

    <!-- Adventure & Nature Section -->
    <section class="adventure">
        <h2>Adventure & Nature in Johor</h2>
        <div class="attraction-list">
            <div class="attraction-item">
                <img src="assets/image/Johor/Endau-Rompin National Park.jpg" alt="Endau-Rompin National Park">
                <h3>Endau-Rompin National Park</h3>
                <p>Hike through the lush rainforest of Endau-Rompin National Park, home to stunning waterfalls, diverse wildlife, and breathtaking landscapes.</p>
                <h4>Activities: Jungle trekking, camping, bird watching, and waterfall exploration</h4>
                <h4>Location: Border of Johor and Pahang</h4>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Johor/Gunung Ledang.jpg" alt="Gunung Ledang">
                <h3>Gunung Ledang</h3>
                <p>This legendary mountain is one of the most famous hiking spots in Malaysia, with challenging trails leading to breathtaking views from the summit.</p>
                <h4>Activities: Hiking, mountain climbing, and nature photography</h4>
                <h4>Location: Tangkak, Johor</h4>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Johor/Sultan Iskandar Marine Park.webp" alt="Sultan Iskandar Marine Park">
                <h3>Sultan Iskandar Marine Park</h3>
                <p>Explore the underwater world in Sultan Iskandar Marine Park, known for its coral reefs and marine life.</p>
                <h4>Activities: Snorkeling, scuba diving, kayaking, and marine exploration</h4>
                <h4>Location: Off the coast of Mersing, Johor</h4>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Johor/Tanjung Piai National Park.jpg" alt="Tanjung Piai National Park">
                <h3>Tanjung Piai National Park</h3>
                <p> This park marks the southernmost tip of mainland Asia and offers mangrove forests, scenic views, and opportunities to observe unique flora and fauna.</p>
                <h4>Activities: Boardwalk strolls, bird watching, and coastal exploration</h4>
                <h4>Location: Pontian, Johor</h4>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Johor/Pulai Waterfall.jpg" alt="Pulai Waterfall">
                <h3>Pulai Waterfall</h3>
                <p>A hidden gem in the Gunung Pulai Recreational Forest, Pulai Waterfall is popular for hiking, picnicking, and enjoying the serene natural environment.</p>
                <h4>Activities: Hiking, swimming, and picnicking</h4>
                <h4>Location: Kulai, Johor</h4>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Johor/Kota Tinggi Waterfalls.jpg" alt="Kota Tinggi Waterfalls">
                <h3>Kota Tinggi Waterfalls</h3>
                <p>One of Johor's most popular natural attractions, these waterfalls offer a refreshing escape into nature with cool, cascading waters, perfect for a day trip with family.</p>
                <h4>Activities: Waterfall picnics, swimming, and camping</h4>
                <h4>Location: Kota Tinggi, Johor</h4>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Johor/Desaru Coast.jpg" alt="Desaru Coast">
                <h3>Desaru Coast</h3>
                <p>Desaru is known for its pristine beaches, water sports, and adventure parks. You can enjoy beachside relaxation or adrenaline-pumping activities.</p>
                <h4>Activities: Surfing, jet skiing, parasailing, and beach activities</h4>
                <h4>Location: Desaru, Johor</h4>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Johor/Blue Lake Bukit Ibam.jpg" alt="Blue Lake at Bukit Ibam">
                <h3>Blue Lake at Bukit Ibam</h3>
                <p>A scenic turquoise lake formed from an abandoned iron mine, Blue Lake is surrounded by lush greenery, offering picturesque views and a tranquil escape.</p>
                <h4>Activities: Sightseeing and nature photography</h4>
                <h4>Location: Bukit Ibam, Johor</h4>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Johor/Gunung Arong Recreational Forest.webp" alt="Gunung Arong Recreational Forest">
                <h3>Gunung Arong Recreational Forest</h3>
                <p> A popular hiking destination for beginner to intermediate trekkers, Gunung Arong offers a rewarding hike to the summit with panoramic views of the South China Sea.</p>
                <h4>Activities: Hiking, bird watching, and camping</h4>
                <h4>Location: Mersing, Johor</h4>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Johor/Sungai Lebam Wetlands.jpg" alt="Sungai Lebam Wetlands">
                <h3>Sungai Lebam Wetlands</h3>
                <p>Famous for its firefly tours, the Sungai Lebam Wetlands offer a magical experience where you can witness thousands of fireflies lighting up the night.</p>
                <h4>Activities: Firefly boat tours and wildlife observation</h4>
                <h4>Location: Kota Tinggi, Johor</h4>
            </div>
        </div>
    </section>

    <!-- Food & Cuisine Section -->
    <section class="cuisine">
        <h2>Food & Cuisine in Johor</h2>
        <div class="attraction-list">
            <div class="attraction-item">
                <img src="assets/image/Johor/Laksa Johor.webp" alt="Laksa Johor">
                <h3>Laksa Johor</h3>
                <p>A local delicacy made with spaghetti in a rich fish broth.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Johor/Mee Bandung.jpg" alt="Mee Bandung">
                <h3>Mee Bandung</h3>
                <p>A popular noodle dish with a savory shrimp-based gravy.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Johor/Kacang Pool.JPG" alt="Kacang Pool">
                <h3>Kacang Pool</h3>
                <p>A unique Johor dish made with minced beef, beans, and spices.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Johor/Otak-Otak.jpg" alt="Otak-Otak">
                <h3>Otak-Otak</h3>
                <p>A unique Johor dish made with minced beef, beans, and spices.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Johor/Nasi Briyani Gam.jpg" alt="Nasi Briyani Gam">
                <h3>Nasi Briyani Gam</h3>
                <p>A delicious rice dish made with fragrant basmati rice, slow-cooked with spices, and served with tender pieces of mutton or chicken. Johor’s briyani is rich and aromatic.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Johor/Roti Kirai.webp" alt="Roti Kirai">
                <h3>Roti Kirai</h3>
                <p>Roti Kirai is a traditional lace-like pancake that is often served with curry, making it a delightful dish at Johor’s festive occasions or high teas.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Johor/Satay Telur.jpeg" alt="Satay Telur">
                <h3>Satay Telur</h3>
                <p>A unique variation of satay in Johor, Satay Telur uses eggs as the main ingredient, skewered and grilled over charcoal, often served with a flavorful peanut sauce.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Johor/Lontong Kering.jpeg" alt="Lontong Kering">
                <h3>Lontong Kering</h3>
                <p> Lontong Kering is a festive dish made of compressed rice cakes served with a rich coconut-based gravy, sambal, boiled eggs, and a side of spicy, crispy beef rendang.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Johor/Keropok Lekor.png" alt="Keropok Lekor">
                <h3>Keropok Lekor</h3>
                <p>Although originally from Terengganu, Keropok Lekor (a deep-fried fish cracker) is very popular in Johor. Made from fish and sago, it's served as a crunchy snack with spicy dipping sauce.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Johor/Kacang Pool.JPG" alt="Asam Pedas Johorl">
                <h3>Asam Pedas Johor</h3>
                <p>A tangy and spicy fish stew made with tamarind, chilies, and local herbs, Asam Pedas is one of Johor’s most beloved traditional dishes. It’s typically served with white rice.</p>
            </div>
        </div>
    </section>

    <!-- Travel Tips Section -->
    <section class="travel-tips">
        <h2>Travel Tips for Johor</h2>
        <div class="attraction-list">
            <div class="attraction-item">
                <h3>Best Time to Visit</h3>
                <p>The ideal time to visit Johor is between March and October, as the weather is warm and dry. The monsoon season, which typically runs from November to February, brings heavy rainfall and may disrupt outdoor activities, particularly along the east coast.</p>
            </div>

            <div class="attraction-item">
                <h3>How to Get There</h3>
                <p>
                    <strong>Flights:</strong> Johor's main airport is Senai International Airport (JHB), located about 30 km from Johor Bahru. It offers flights to/from major Malaysian cities and some international destinations like Singapore, Indonesia, and Thailand.<br>
                    <strong>By Road:</strong> Johor is well-connected by bus and car from Kuala Lumpur (about 4-5 hours drive) and Singapore (only 30 minutes from Johor Bahru via the Causeway).<br>
                    <strong>Trains:</strong> The KTM train service connects Johor Bahru with other parts of Malaysia, offering a scenic route into the state.
                </p>
            </div>

            <div class="attraction-item">
                <h3>Currency</h3>
                <p>The official currency is the Malaysian Ringgit (MYR). While credit cards are widely accepted in shopping malls and hotels, it's always a good idea to carry some cash for small purchases at local markets and street food stalls.</p>
            </div>

            <div class="attraction-item">
                <h3>Language</h3>
                <p>The official language is Bahasa Malaysia, but English is widely spoken, especially in tourist areas, hotels, and larger cities like Johor Bahru. You won’t have much trouble communicating with locals in English.</p>
            </div>

            <div class="attraction-item">
                <h3>Local Transportation</h3>
                <p>
                    <strong>Taxis & E-Hailing Services:</strong> Taxis are readily available, but make sure they use the meter. You can also use e-hailing services like Grab, which are more reliable and usually cheaper.<br>
                    <strong>Public Buses:</strong> Johor Bahru and other major towns have public bus networks, but they can be slow and infrequent. If you're planning to visit more remote areas, renting a car is more convenient.<br>
                    <strong>Driving:</strong> Road conditions in Johor are generally good, with well-maintained highways. However, traffic in Johor Bahru can be congested during peak hours.
                </p>
            </div>

            <div class="attraction-item">
                <h3>Safety</h3>
                <p>Johor Bahru is generally safe for tourists, but like any city, there are areas where petty crime, like pickpocketing, can occur. Be cautious when visiting crowded markets or tourist attractions.</p>
                <p><strong>Travel Insurance:</strong> It's always a good idea to have travel insurance that covers medical emergencies and trip cancellations.</p>
            </div>

            <div class="attraction-item">
                <h3>Shopping & Bargaining</h3>
                <p>Johor has many shopping options, from high-end malls like Johor Premium Outlets to night markets and local bazaars. When shopping in markets or at smaller stalls, bargaining is acceptable, but do so politely.</p>
            </div>

            <div class="attraction-item">
                <h3>Food Safety</h3>
                <p>Johor is known for its street food, and most vendors practice good hygiene. However, to be on the safe side, stick to stalls that appear busy, as the food turnover is higher, ensuring freshness.</p>
                <p><strong>Tap Water:</strong> It’s best to drink bottled or boiled water, as tap water is not always safe for consumption.</p>
            </div>

            <div class="attraction-item">
                <h3>Respecting Local Customs</h3>
                <p>
                    <strong>Modest Dress:</strong> While Johor is generally more relaxed, it is advisable to dress modestly, especially when visiting religious sites like mosques. Ensure that your shoulders and knees are covered.<br>
                    <strong>Mosques:</strong> Visitors are welcome at mosques, but ensure to remove your shoes before entering, and women may need to wear a headscarf.<br>
                    <strong>Greetings:</strong> When meeting locals, a friendly smile and a slight nod are customary. When shaking hands with Muslims, use both hands but do not grip too firmly.
                </p>
            </div>

            <div class="attraction-item">
                <h3>Tipping</h3>
                <p>Tipping is not a common practice in Malaysia, but it is appreciated in tourist areas and at restaurants. Rounding up the bill or leaving some small change is a nice gesture.</p>
            </div>

            <div class="attraction-item">
                <h3>Local Festivals</h3>
                <p>Festival of Lights (Deepavali), Hari Raya Aidilfitri, and the Chinese New Year are major celebrations in Johor. Visiting during these times offers a great opportunity to experience local customs, food, and traditions.</p>
            </div>

            <div class="attraction-item">
                <h3>Nearby Islands</h3>
                <p>Johor is a gateway to several beautiful islands like Pulau Rawa, Pulau Tioman, and Pulau Sibu. If you're interested in island hopping, be sure to book your ferry tickets in advance, especially during peak seasons.</p>
            </div>
        </div>
    </section>


    <!-- Map Section -->
    <section class="map">
        <h2>Map of Johor</h2>
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1020740.338373767!2d102.85047652004901!3d2.0491381660022383!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31c4cc3289eddb9f%3A0x7b6b329bbf0cadb4!2sJohor!5e0!3m2!1sen!2smy!4v1727602092894!5m2!1sen!2smy" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
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