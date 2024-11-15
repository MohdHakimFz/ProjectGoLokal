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
    <title>Explore Kelantan - GoLokal</title>
    <link rel="stylesheet" href="assets/css/kelantan.css">
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
    <section class="kelantan-intro">
        <h1>Discover Kelantan</h1>
        <img src="assets/image/Kelantan/Flag Kelantan.png" alt="Kelantan Flag">
        <p>Kelantan, located in northeastern Malaysia, is a stronghold of Malay culture and Islamic traditions. With its traditional arts, crafts, and architecture, Kelantan offers visitors a glimpse into the heart of Malaysia’s cultural heritage.</p>
    </section>

    <!-- Top Attractions Section -->
    <section class="attractions">
        <h2>Top Attractions in Kelantan</h2>
        <div class="attraction-list">
            <div class="attraction-item">
                <img src="assets/image/Kelantan/Istana Jahar.jpg" alt="Istana Jahar">
                <h3>Istana Jahar</h3>
                <p>A former royal residence turned museum, Istana Jahar showcases Kelantanese culture, heritage, and traditional craftsmanship.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Kelantan/Kampung Laut Mosque.jpg" alt="Kampung Laut Mosque">
                <h3>Kampung Laut Mosque</h3>
                <p>One of the oldest mosques in Malaysia, this wooden mosque reflects traditional Malay architecture and serves as a spiritual landmark.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Kelantan/Rantau Panjang Duty-Free Zone.jpg" alt="Rantau Panjang Duty-Free Zone">
                <h3>Rantau Panjang Duty-Free Zone</h3>
                <p>A popular shopping destination along the Malaysian-Thai border, offering duty-free products ranging from clothes to electronics.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Kelantan/Siti Khadijah Market.jpg" alt="Siti Khadijah Market">
                <h3>Siti Khadijah Market</h3>
                <p>Explore the bustling Siti Khadijah Market, where local traders, mostly women, sell a variety of fresh produce, traditional snacks, and handmade crafts.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Kelantan/Gua Ikan.jpg" alt="Gua Ikan">
                <h3>Gua Ikan</h3>
                <p>An ancient limestone cave with legends tied to Kelantanese folklore, Gua Ikan offers scenic surroundings and a fascinating cave system to explore.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Kelantan/Wakaf Che Yeh Night Market.jpg" alt="Wakaf Che Yeh Night Market">
                <h3>Wakaf Che Yeh Night Market</h3>
                <p>A lively night market offering everything from clothing, souvenirs, and local delicacies, making it a must-visit spot for shopaholics.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Kelantan/Pantai Cahaya Bulan.png" alt="Pantai Cahaya Bulan">
                <h3>Pantai Cahaya Bulan</h3>
                <p>A beautiful beach popular among locals and tourists for its golden sands, offering activities like kite-flying and leisurely picnics.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Kelantan/Gunung Stong State Park.jpg" alt="Gunung Stong State Park">
                <h3>Gunung Stong State Park</h3>
                <p>Known for its majestic seven-tiered waterfall, Jelawang Waterfall, this state park offers challenging hikes, stunning views, and rich wildlife.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Kelantan/Muzium Kelantan.png" alt="Muzium Kelantan">
                <h3>Muzium Kelantan</h3>
                <p>This museum is a treasure trove of Kelantan's history, housing exhibits on traditional arts, culture, and the state's royal heritage.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Kelantan/Merdeka Square, Kota Bharu.jpg" alt="Merdeka Square, Kota Bharu">
                <h3>Merdeka Square, Kota Bharu</h3>
                <p>A historical landmark in Kota Bharu, Merdeka Square is where important national celebrations take place, surrounded by significant buildings such as the Sultan's Palace.</p>
            </div>
        </div>
    </section>


    <!-- Cultural Heritage Section -->
    <section class="culture">
        <h2>Cultural Heritage of Kelantan</h2>
        <div class="attraction-list">
            <div class="attraction-item">
                <img src="assets/image/Kelantan/Muzium Kelantan.png" alt="Kelantan State Museum">
                <h3>Kelantan State Museum</h3>
                <p>Discover the rich history and cultural heritage of Kelantan through exhibits on traditional crafts, performing arts, and the state’s royal lineage.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Kelantan/Wayang Kulit.jpg" alt="Wayang Kulit Performance">
                <h3>Wayang Kulit (Shadow Puppet Theatre)</h3>
                <p>Experience the traditional shadow puppet theatre of Kelantan, where intricately designed puppets bring ancient stories to life with music and narration.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Kelantan/Muzium Islam Kelantan.jpg" alt="Muzium Islam Kelantan">
                <h3>Muzium Islam Kelantan</h3>
                <p>Explore Kelantan's Islamic heritage at this museum, which highlights the influence of Islam on the state's culture, architecture, and history.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Kelantan/Balai Getam Guri.jpg" alt="Balai Getam Guri">
                <h3>Balai Getam Guri</h3>
                <p>A center for traditional Kelantanese arts, Balai Getam Guri preserves the heritage of handicrafts such as batik, songket weaving, and wood carving.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Kelantan/Pantai Seri Tujuh.jpeg" alt="Pantai Seri Tujuh">
                <h3>Pantai Seri Tujuh (Seven Lagoons Beach)</h3>
                <p>Not only a beautiful beach, Pantai Seri Tujuh is also famous for hosting the annual International Kite Festival, celebrating Kelantan’s kite-flying tradition.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Kelantan/Rebana Ubi.jpg" alt="Rebana Ubi Drum Festival">
                <h3>Rebana Ubi (Giant Drum) Festival</h3>
                <p>Rebana Ubi is a traditional Kelantanese drum, and the annual festival showcases the art of drum-making and performances that date back centuries.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Kelantan/Siti Khadijah Market.jpg" alt="Siti Khadijah Market">
                <h3>Siti Khadijah Market</h3>
                <p>A vibrant cultural marketplace where local traders, mostly women, sell traditional Kelantanese food, handicrafts, and clothing, showcasing the state’s commercial heritage.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Kelantan/Wat Photivihan.jpg" alt="Wat Photivihan">
                <h3>Wat Photivihan</h3>
                <p>Home to Southeast Asia's largest reclining Buddha statue, Wat Photivihan reflects the significant influence of the Thai-Buddhist community in Kelantan.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Kelantan/Makam Tok Janggut.webp" alt="Makam Tok Janggut">
                <h3>Makam Tok Janggut</h3>
                <p>The burial site of Tok Janggut, a Malay nationalist and freedom fighter, this mausoleum is an important historical site for understanding Kelantan's resistance against British colonialism.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Kelantan/Wau Bulan.jpg" alt="Wau Bulan">
                <h3>Wau Bulan (Moon Kite)</h3>
                <p>Kelantan is famous for Wau Bulan, a traditional kite that’s flown in local festivals. The intricate designs and cultural significance make it a symbol of Kelantan's heritage.</p>
            </div>
        </div>
    </section>

    <!-- Adventure & Nature Section -->
    <section class="adventure">
        <h2>Adventure & Nature in Kelantan</h2>
        <div class="attraction-list">
            <div class="attraction-item">
                <img src="assets/image/Kelantan/Gunung Stong State Park.jpg" alt="Gunung Stong State Park">
                <h3>Gunung Stong State Park</h3>
                <p>Explore the stunning Gunung Stong State Park, home to one of the highest waterfalls in Southeast Asia, the Jelawang Waterfall, and offering challenging hikes and abundant wildlife.</p>
                <h4>Activities: Hiking, waterfall exploration, wildlife observation</h4>
                <h4>Location: Dabong, Kelantan</h4>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Kelantan/Pantai Irama.jpg" alt="Pantai Irama">
                <h3>Pantai Irama</h3>
                <p>Pantai Irama, known as "The Beach of Melody," is a popular spot for locals and tourists alike, offering calm waters and scenic views.</p>
                <h4>Activities: Swimming, picnicking, beach activities</h4>
                <h4>Location: Bachok, Kelantan</h4>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Kelantan/Kuala Koh National Park.jpg" alt="Kuala Koh National Park">
                <h3>Kuala Koh National Park</h3>
                <p>Part of the larger Taman Negara, Kuala Koh is a gateway to exploring Malaysia's oldest rainforest, offering opportunities for bird watching and river cruises.</p>
                <h4>Activities: Jungle trekking, bird watching, river cruises</h4>
                <h4>Location: Gua Musang, Kelantan</h4>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Kelantan/Pantai Cahaya Bulan.png" alt="Pantai Cahaya Bulan">
                <h3>Pantai Cahaya Bulan</h3>
                <p>A picturesque beach popular for kite flying and leisurely walks, Pantai Cahaya Bulan offers a relaxing escape with stunning coastal views.</p>
                <h4>Activities: Beach activities, kite flying, walking</h4>
                <h4>Location: Kota Bharu, Kelantan</h4>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Kelantan/Bukit Bakar.jpg" alt="Bukit Bakar">
                <h3>Bukit Bakar</h3>
                <p>Bukit Bakar Recreational Forest is a lush green retreat offering hiking trails, waterfalls, and picnic areas for nature lovers and families.</p>
                <h4>Activities: Hiking, picnicking, nature walks</h4>
                <h4>Location: Machang, Kelantan</h4>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Kelantan/Rafflesia Park.webp" alt="Rafflesia Park">
                <h3>Rafflesia Park</h3>
                <p>Located within Lojing Highlands, this park is known for housing the rare Rafflesia flower, the largest flower in the world. A must-visit for nature enthusiasts.</p>
                <h4>Activities: Trekking, flower viewing, wildlife photography</h4>
                <h4>Location: Lojing Highlands, Kelantan</h4>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Kelantan/Sungai Nenggiri.jpg" alt="Sungai Nenggiri">
                <h3>Sungai Nenggiri</h3>
                <p>Sungai Nenggiri offers thrilling whitewater rafting adventures for those seeking excitement amidst Kelantan's lush rainforest surroundings.</p>
                <h4>Activities: Whitewater rafting, river cruises, wildlife watching</h4>
                <h4>Location: Gua Musang, Kelantan</h4>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Kelantan/Gunung Ayam.jpg" alt="Gunung Ayam">
                <h3>Gunung Ayam</h3>
                <p>Gunung Ayam is the highest peak in Gunung Stong State Park, offering a rewarding but challenging hike with panoramic views at the summit.</p>
                <h4>Activities: Hiking, bird watching, camping</h4>
                <h4>Location: Dabong, Kelantan</h4>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Kelantan/Pantai Bisikan Bayu.jpeg" alt="Pantai Bisikan Bayu">
                <h3>Pantai Bisikan Bayu</h3>
                <p>Also known as the "Beach of Whispering Breeze," Pantai Bisikan Bayu is a serene beach ideal for picnics, fishing, and enjoying the peaceful sounds of the ocean.</p>
                <h4>Activities: Fishing, beach picnics, relaxing walks</h4>
                <h4>Location: Pasir Puteh, Kelantan</h4>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Kelantan/Lata Beringin Waterfall.jpg" alt="Lata Beringin Waterfall">
                <h3>Lata Beringin Waterfall</h3>
                <p>This 120-meter-high waterfall is one of the tallest in Kelantan, surrounded by dense rainforest, perfect for swimming and nature photography.</p>
                <h4>Activities: Swimming, hiking, nature photography</h4>
                <h4>Location: Kuala Krai, Kelantan</h4>
            </div>
        </div>
    </section>

    <!-- Food & Cuisine Section -->
    <section class="cuisine">
        <h2>Food & Cuisine in Kelantan</h2>
        <div class="attraction-list">
            <div class="attraction-item">
                <img src="assets/image/Kelantan/Nasi Kerabu.jpg" alt="Nasi Kerabu">
                <h3>Nasi Kerabu</h3>
                <p>A traditional Kelantanese rice dish, Nasi Kerabu features blue-colored rice (dyed with butterfly pea flowers) and is served with various herbs, fish or chicken, and savory condiments.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Kelantan/Ayam Percik.jpg" alt="Ayam Percik">
                <h3>Ayam Percik</h3>
                <p>Ayam Percik is grilled chicken marinated in coconut milk and spices, served with a rich, creamy sauce. It’s a popular dish in Kelantan, especially during Ramadan.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Kelantan/Nasi Dagang.jpg" alt="Nasi Dagang">
                <h3>Nasi Dagang</h3>
                <p>Nasi Dagang is a fragrant rice dish served with fish curry, coconut milk, pickled vegetables, and hard-boiled eggs. It’s a Kelantanese favorite, often eaten for breakfast.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Kelantan/Kuih Akok.jpg" alt="Kuih Akok">
                <h3>Kuih Akok</h3>
                <p>A traditional Kelantanese dessert, Kuih Akok is made with eggs, coconut milk, and palm sugar, resulting in a soft, caramelized texture that’s rich and sweet.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Kelantan/Budu.jpeg" alt="Budu">
                <h3>Budu</h3>
                <p>Budu is a fermented anchovy sauce, often served as a condiment with rice and raw vegetables. It’s a staple in Kelantanese cuisine and offers a distinctive, tangy flavor.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Kelantan/Laksam.avif" alt="Laksam">
                <h3>Laksam</h3>
                <p>Laksam is a unique Kelantanese noodle dish made from rolled rice noodles served in a thick, creamy fish-based gravy, typically garnished with fresh vegetables and herbs.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Kelantan/Somtam Kelantan.jpg" alt="Somtam Kelantan">
                <h3>Somtam Kelantan</h3>
                <p>This spicy Thai-inspired salad, made with shredded papaya, chili, lime, and peanuts, is popular in the Thai-influenced regions of Kelantan.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Kelantan/Tepung Pelita.jpg" alt="Tepung Pelita">
                <h3>Tepung Pelita</h3>
                <p>A popular dessert in Kelantan, Tepung Pelita is made from rice flour, coconut milk, and palm sugar, steamed in banana leaf containers for a soft, sweet treat.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Kelantan/Ketupat Sotong.png" alt="Ketupat Sotong">
                <h3>Ketupat Sotong</h3>
                <p>Ketupat Sotong is a unique dish where glutinous rice is stuffed inside squid and cooked in a creamy coconut milk sauce. It’s a must-try for adventurous food lovers in Kelantan.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Kelantan/Daging Bakar.jpg" alt="Daging Bakar">
                <h3>Daging Bakar</h3>
                <p>Daging Bakar is grilled marinated beef, served with a tangy dipping sauce. This dish is a Kelantanese favorite, often enjoyed at festive occasions and special gatherings.</p>
            </div>
        </div>
    </section>


    <!-- Travel Tips Section -->
    <section class="travel-tips">
        <h2>Travel Tips for Kelantan</h2>
        <div class="attraction-list">
            <div class="attraction-item">
                <h3>Best Time to Visit</h3>
                <p>The best time to visit Kelantan is between March and October when the weather is dry. The monsoon season, from November to February, brings heavy rain which may affect outdoor activities.</p>
            </div>

            <div class="attraction-item">
                <h3>How to Get There</h3>
                <p>
                    <strong>Flights:</strong> You can fly into Sultan Ismail Petra Airport in Kota Bharu, which offers flights from Kuala Lumpur and other cities.<br>
                    <strong>By Road:</strong> Kelantan is accessible by bus or car from Kuala Lumpur, taking approximately 7-8 hours.<br>
                    <strong>Trains:</strong> The East Coast Railway Line connects Kelantan to other parts of Malaysia, offering scenic views along the way.
                </p>
            </div>

            <div class="attraction-item">
                <h3>Currency</h3>
                <p>The official currency is the Malaysian Ringgit (MYR). Credit cards are accepted in larger establishments, but it’s advisable to carry some cash for smaller purchases, especially at markets.</p>
            </div>

            <div class="attraction-item">
                <h3>Language</h3>
                <p>Bahasa Malaysia is the official language, but many locals speak Kelantanese Malay, a dialect unique to the state. English is understood in tourist areas.</p>
            </div>

            <div class="attraction-item">
                <h3>Local Transportation</h3>
                <p>
                    <strong>Taxis & E-Hailing:</strong> Taxis are available, but it’s recommended to use e-hailing services like Grab for more accurate pricing.<br>
                    <strong>Public Buses:</strong> Kota Bharu has a network of buses, though they may be infrequent. Renting a car is a more convenient option for exploring remote areas.
                </p>
            </div>

            <div class="attraction-item">
                <h3>Cultural Respect</h3>
                <p>Kelantan is one of the more conservative states in Malaysia. Visitors should dress modestly, especially when visiting mosques or rural areas. Women are advised to cover their shoulders and wear long skirts or pants.</p>
            </div>

            <div class="attraction-item">
                <h3>Food Safety</h3>
                <p>Street food in Kelantan is generally safe, but choose vendors with high turnover to ensure freshness. Be cautious with tap water; bottled or boiled water is recommended.</p>
            </div>

            <div class="attraction-item">
                <h3>Respecting Local Traditions</h3>
                <p>Friday is a day of rest in Kelantan, and many shops and businesses will be closed for the afternoon. Be mindful of prayer times and avoid loud or disruptive behavior near mosques.</p>
            </div>

            <div class="attraction-item">
                <h3>Shopping & Bargaining</h3>
                <p>Kelantan is known for its markets, especially the Siti Khadijah Market in Kota Bharu. Bargaining is common in markets, so feel free to haggle politely for a better price.</p>
            </div>

            <div class="attraction-item">
                <h3>Safety</h3>
                <p>Kelantan is generally safe for tourists, but as with any place, be mindful of petty crime such as pickpocketing in busy areas. Avoid walking alone late at night.</p>
            </div>
        </div>
    </section>


    <!-- Map Section -->
    <section class="map">
        <h2>Map of Kelantan</h2>
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1016867.0174007043!2d101.3404564318902!3d5.396119433907319!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31b5d97264fa1a59%3A0x6ec97bbb4a9fbcf0!2sKelantan!5e0!3m2!1sen!2smy!4v1727602238291!5m2!1sen!2smy" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
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