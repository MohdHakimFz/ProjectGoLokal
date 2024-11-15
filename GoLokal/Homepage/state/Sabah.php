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
    <title>Explore Sabah - GoLokal</title>
    <link rel="stylesheet" href="assets/css/sabah.css">
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
    <section class="sabah-intro">
        <h1>Discover Sabah</h1>
        <img src="assets/image/Sabah/Flag Sabah.png" alt="Sabah Flag">
        <p>Sabah, located on the island of Borneo, is renowned for its stunning natural wonders, including Mount Kinabalu and pristine islands. With its diverse wildlife, indigenous cultures, and beautiful beaches, Sabah is a paradise for adventurers and nature lovers.</p>
    </section>

    <!-- Top Attractions Section -->
    <section class="attractions">
        <h2>Top Attractions in Sabah</h2>
        <div class="attraction-list">
            <div class="attraction-item">
                <img src="assets/image/Sabah/Mount Kinabalu.jpg" alt="Mount Kinabalu">
                <h3>Mount Kinabalu</h3>
                <p>One of Southeast Asia’s highest peaks, Mount Kinabalu offers a breathtaking climb and spectacular views, attracting adventurers from all over the world.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Sabah/Sipadan Island.jpg" alt="Sipadan Island">
                <h3>Sipadan Island</h3>
                <p>Famed for its rich marine biodiversity, Sipadan Island is a diving paradise, offering stunning underwater experiences with turtles, sharks, and vibrant coral reefs.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Sabah/Manukan Island.jpg" alt="Manukan Island">
                <h3>Manukan Island</h3>
                <p>Located in Tunku Abdul Rahman Marine Park, Manukan Island is known for its crystal-clear waters, perfect for snorkeling, scuba diving, and beach relaxation.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Sabah/Sepilok Orangutan Rehabilitation Centre.jpg" alt="Sepilok Orangutan Rehabilitation Centre">
                <h3>Sepilok Orangutan Rehabilitation Centre</h3>
                <p>Visit the Sepilok Orangutan Rehabilitation Centre to witness these endangered primates in their natural habitat and support conservation efforts.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Sabah/Kota Kinabalu City Mosque.jpg" alt="Kota Kinabalu City Mosque">
                <h3>Kota Kinabalu City Mosque</h3>
                <p>This stunning mosque, known as the "Floating Mosque," is a beautiful example of modern Islamic architecture and offers serene views over a man-made lagoon.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Sabah/Danum Valley.jpg" alt="Danum Valley">
                <h3>Danum Valley</h3>
                <p>Experience the untouched beauty of Borneo’s rainforests in Danum Valley, a premier spot for wildlife watching and nature exploration.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Sabah/Tip of Borneo.jpeg" alt="Tip of Borneo">
                <h3>Tip of Borneo</h3>
                <p>Located at the northernmost tip of Borneo, this scenic spot offers panoramic views of the South China Sea and the Sulu Sea.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Sabah/Poring Hot Springs.webp" alt="Poring Hot Springs">
                <h3>Poring Hot Springs</h3>
                <p>Relax in the therapeutic hot springs at Poring, surrounded by lush rainforest, or explore the nearby canopy walk for a unique treetop experience.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Sabah/Kinabatangan River.jpg" alt="Kinabatangan River">
                <h3>Kinabatangan River</h3>
                <p>The Kinabatangan River is a wildlife haven, offering river cruises where you can spot rare animals such as pygmy elephants, proboscis monkeys, and exotic birds.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Sabah/Tunku Abdul Rahman Marine Park.jpg" alt="Tunku Abdul Rahman Marine Park">
                <h3>Tunku Abdul Rahman Marine Park</h3>
                <p>This marine park consists of five islands, perfect for snorkeling, diving, and beachside relaxation, all located just a short boat ride from Kota Kinabalu.</p>
            </div>
        </div>
    </section>

    <!-- Cultural Heritage Section -->
    <section class="culture">
        <h2>Cultural Heritage of Sabah</h2>
        <div class="attraction-list">
            <div class="attraction-item">
                <img src="assets/image/Sabah/Sabah State Museum.jpg" alt="Sabah State Museum">
                <h3>Sabah State Museum</h3>
                <p>Learn about Sabah’s rich history and cultural heritage at the Sabah State Museum, which showcases a variety of exhibits including archaeology, natural history, and local art.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Sabah/Mari Mari Cultural Village.jpg" alt="Mari Mari Cultural Village">
                <h3>Mari Mari Cultural Village</h3>
                <p>Explore the traditional lifestyles of Sabah’s indigenous groups at Mari Mari Cultural Village, where you can experience authentic cultural performances and traditional crafts.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Sabah/Kota Belud Tamu.jpg" alt="Kota Belud Tamu">
                <h3>Kota Belud Tamu</h3>
                <p>Visit Kota Belud’s Tamu, a vibrant traditional market where locals gather to trade goods and showcase the unique culture of the Bajau, Dusun, and Rungus communities.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Sabah/Bajau Laut Stilt Houses.jpg" alt="Bajau Laut Stilt Houses">
                <h3>Bajau Laut Stilt Houses</h3>
                <p>The Bajau Laut, also known as "Sea Gypsies," live in stilt houses over the water. Their floating villages offer a glimpse into a unique, seafaring lifestyle.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Sabah/Gombunan Ceremonial Site.jpg" alt="Gombunan Ceremonial Site">
                <h3>Gombunan Ceremonial Site</h3>
                <p>Located in Tambunan, the Gombunan Ceremonial Site is a sacred space used by the Dusun people for rituals and ceremonies, reflecting the importance of spirituality in their culture.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Sabah/Tun Mustapha Gallery.jpeg" alt="Tun Mustapha Gallery">
                <h3>Tun Mustapha Gallery</h3>
                <p>The Tun Mustapha Gallery in Kota Kinabalu celebrates the legacy of Sabah’s first Chief Minister, with exhibits on his contributions to the state’s development and heritage.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Sabah/Linangkit Cultural Village.jpg" alt="Linangkit Cultural Village">
                <h3>Linangkit Cultural Village</h3>
                <p>This cultural village offers visitors a chance to experience the traditional weaving, crafts, and lifestyle of the Lotud people in Tuaran.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Sabah/Kiulu Farmstay.jpg" alt="Kiulu Farmstay">
                <h3>Kiulu Farmstay</h3>
                <p>Located in a rural village, Kiulu Farmstay offers visitors a chance to experience local Sabahan culture, including farming activities, traditional food, and community-based tourism.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Sabah/Rungus Longhouse.jpg" alt="Rungus Longhouse">
                <h3>Rungus Longhouse</h3>
                <p>Visit a traditional Rungus longhouse in Kudat to see how these indigenous people live in communal harmony, with longhouses serving as both homes and community centers.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Sabah/Agop Batu Tulang.jpg" alt="Agop Batu Tulang">
                <h3>Agop Batu Tulang</h3>
                <p>Agop Batu Tulang is a significant archaeological site in the Kinabatangan area, featuring ancient burial caves used by early human inhabitants of Sabah.</p>
            </div>
        </div>
    </section>

    <!-- Adventure & Nature Section -->
    <section class="adventure">
        <h2>Adventure & Nature in Sabah</h2>
        <div class="attraction-list">
            <div class="attraction-item">
                <img src="assets/image/Sabah/Mount Kinabalu.jpg" alt="Mount Kinabalu">
                <h3>Mount Kinabalu</h3>
                <p>Climb the majestic Mount Kinabalu, Southeast Asia’s highest peak, offering breathtaking views and unique alpine flora.</p>
                <h4>Activities: Mountain climbing, hiking, and photography</h4>
                <h4>Location: Kinabalu Park, Sabah</h4>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Sabah/Kinabatangan River.jpg" alt="Kinabatangan River">
                <h3>Kinabatangan River</h3>
                <p>Explore the wildlife-rich Kinabatangan River, where you can spot orangutans, pygmy elephants, and a variety of bird species.</p>
                <h4>Activities: River cruises, wildlife spotting, and nature photography</h4>
                <h4>Location: Sandakan, Sabah</h4>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Sabah/Danum Valley.jpg" alt="Danum Valley Conservation Area">
                <h3>Danum Valley Conservation Area</h3>
                <p>Experience pristine rainforest in Danum Valley, home to rare species like the clouded leopard and Bornean orangutan.</p>
                <h4>Activities: Jungle trekking, wildlife observation, and canopy walks</h4>
                <h4>Location: Lahad Datu, Sabah</h4>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Sabah/Sipadan Island.jpg" alt="Sipadan Island">
                <h3>Sipadan Island</h3>
                <p>Dive into the crystal-clear waters of Sipadan Island, one of the world’s top dive sites, known for its rich marine biodiversity.</p>
                <h4>Activities: Scuba diving, snorkeling, and underwater photography</h4>
                <h4>Location: Off the coast of Semporna, Sabah</h4>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Sabah/Maliau Basin.jpg" alt="Maliau Basin">
                <h3>Maliau Basin</h3>
                <p>Discover the "Lost World of Sabah" in Maliau Basin, a remote and untouched wilderness area filled with stunning waterfalls and unique biodiversity.</p>
                <h4>Activities: Jungle trekking, bird watching, and waterfall exploration</h4>
                <h4>Location: Southern Sabah</h4>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Sabah/Tabin Wildlife Reserve.jpg" alt="Tabin Wildlife Reserve">
                <h3>Tabin Wildlife Reserve</h3>
                <p>Visit Tabin Wildlife Reserve, a sanctuary for endangered species like the Bornean pygmy elephant and Sumatran rhinoceros.</p>
                <h4>Activities: Wildlife safari, trekking, and bird watching</h4>
                <h4>Location: Lahad Datu, Sabah</h4>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Sabah/Tunku Abdul Rahman Marine Park.jpg" alt="Tunku Abdul Rahman Marine Park">
                <h3>Tunku Abdul Rahman Marine Park</h3>
                <p>Explore the islands of Tunku Abdul Rahman Marine Park, known for their white sandy beaches, crystal-clear waters, and coral reefs.</p>
                <h4>Activities: Snorkeling, scuba diving, and kayaking</h4>
                <h4>Location: Off the coast of Kota Kinabalu, Sabah</h4>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Sabah/Sabah Tea Garden.jpg" alt="Sabah Tea Garden">
                <h3>Sabah Tea Garden</h3>
                <p>Enjoy a peaceful retreat at Sabah Tea Garden, the only organic tea farm in Borneo, surrounded by the stunning views of Mount Kinabalu.</p>
                <h4>Activities: Tea tours, trekking, and camping</h4>
                <h4>Location: Ranau, Sabah</h4>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Sabah/Imbak Canyon.jpg" alt="Imbak Canyon">
                <h3>Imbak Canyon</h3>
                <p>Immerse yourself in the biodiversity of Imbak Canyon, a conservation area rich with unique plants, animals, and waterfalls.</p>
                <h4>Activities: Jungle trekking, wildlife observation, and conservation programs</h4>
                <h4>Location: Central Sabah</h4>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Sabah/Crocker Range Park.jpg" alt="Crocker Range Park">
                <h3>Crocker Range Park</h3>
                <p>Explore the Crocker Range, home to rugged mountains, rich biodiversity, and traditional villages of the Kadazan-Dusun people.</p>
                <h4>Activities: Hiking, bird watching, and cultural tours</h4>
                <h4>Location: Southwestern Sabah</h4>
            </div>
        </div>
    </section>


    <!-- Food & Cuisine Section -->
    <section class="cuisine">
        <h2>Food & Cuisine in Sabah</h2>
        <div class="attraction-list">
            <div class="attraction-item">
                <img src="assets/image/Sabah/Hinava.avif" alt="Hinava">
                <h3>Hinava</h3>
                <p>Hinava is a traditional Kadazan-Dusun dish made from raw fish marinated in lime juice, mixed with chili, ginger, onions, and grated bambangan seed.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Sabah/Latok.jpg" alt="Latok">
                <h3>Latok</h3>
                <p>Latok, also known as sea grapes, is a type of edible seaweed commonly eaten fresh in Sabah, often served with sambal and lime.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Sabah/Ambuyat.jpeg" alt="Ambuyat">
                <h3>Ambuyat</h3>
                <p>Ambuyat is a traditional starchy dish made from the interior trunk of the sago palm, typically served with a variety of dipping sauces.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Sabah/Nasi Kuning.jpg" alt="Nasi Kuning">
                <h3>Nasi Kuning</h3>
                <p>Nasi Kuning is a popular Sabahan dish made of fragrant yellow rice, usually served with chicken, sambal, and a hard-boiled egg.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Sabah/Sinalau Bakas.jpg" alt="Sinalau Bakas">
                <h3>Sinalau Bakas</h3>
                <p>Sinalau Bakas is a traditional Kadazan-Dusun dish of smoked wild boar meat, marinated and smoked for hours, giving it a rich flavor.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Sabah/Tuhau.jpg" alt="Tuhau">
                <h3>Tuhau</h3>
                <p>Tuhau is a traditional Kadazan-Dusun dish made from wild ginger, finely chopped and mixed with chili, lime, and salt, often eaten as a side dish.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Sabah/Bambangan.jpg" alt="Bambangan">
                <h3>Bambangan</h3>
                <p>Bambangan is a type of wild mango, preserved or eaten fresh with a tangy taste, commonly served with rice in Sabahan cuisine.</p>
            </div>

            <div class="attraction-item">
                <img src="image/Sabah/Pinasakan.jpg" alt="Pinasakan">
                <h3>Pinasakan</h3>
                <p>Pinasakan is a traditional dish made from fish simmered with takob-akob (wild fruit) and other herbs, giving it a sour and savory flavor.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Sabah/Tuaran Mee.jpg" alt="Tuaran Mee">
                <h3>Tuaran Mee</h3>
                <p>Tuaran Mee is a famous noodle dish from the town of Tuaran in Sabah, made with egg noodles that are fried to perfection and served with pork, eggs, and vegetables.</p>
            </div>


            <div class="attraction-item">
                <img src="assets/image/Sabah/Ubi Tumbuk.jpg" alt="Ubi Tumbuk">
                <h3>Ubi Tumbuk</h3>
                <p>Ubi Tumbuk is a traditional Sabahan dish made from pounded sweet potatoes, usually served as a side dish with sambal or other condiments.</p>
            </div>
        </div>
    </section>


    <!-- Travel Tips Section -->
    <section class="travel-tips">
        <h2>Travel Tips for Sabah</h2>
        <div class="attraction-list">
            <div class="attraction-item">
                <h3>Best Time to Visit</h3>
                <p>The best time to visit Sabah is from March to October, during the dry season. The wet season (November to February) brings heavy rains, which can affect travel plans, especially in mountainous areas and islands.</p>
            </div>

            <div class="attraction-item">
                <h3>How to Get There</h3>
                <p>
                    <strong>Flights:</strong> The main gateway to Sabah is Kota Kinabalu International Airport (BKI), with flights connecting to Kuala Lumpur, Penang, and international destinations like Singapore, Hong Kong, and South Korea.<br>
                    <strong>By Sea:</strong> Ferry services operate between Labuan and Kota Kinabalu, offering a scenic maritime route to Sabah.<br>
                    <strong>By Road:</strong> Sabah is accessible by road from Sarawak and Brunei, with buses connecting major towns.
                </p>
            </div>

            <div class="attraction-item">
                <h3>Currency</h3>
                <p>The official currency is the Malaysian Ringgit (MYR). ATMs are widely available in major towns and cities. Credit cards are accepted in most hotels and larger restaurants, but it's wise to carry cash for smaller purchases.</p>
            </div>

            <div class="attraction-item">
                <h3>Language</h3>
                <p>The official language is Bahasa Malaysia, but English is widely spoken, especially in tourist areas. In rural areas, some locals may speak Dusun, Kadazan, or Bajau dialects.</p>
            </div>

            <div class="attraction-item">
                <h3>Local Transportation</h3>
                <p>
                    <strong>Taxis & E-Hailing Services:</strong> Taxis are available, but Grab (e-hailing) is a more reliable and affordable option in Kota Kinabalu.<br>
                    <strong>Public Buses:</strong> Local buses and mini-vans operate between towns, but they can be slow and overcrowded. Renting a car offers more flexibility for exploring remote areas.<br>
                    <strong>Ferry & Boat:</strong> For island hopping or visiting coastal areas, ferries and boat services are available, especially around Kota Kinabalu.
                </p>
            </div>

            <div class="attraction-item">
                <h3>Safety</h3>
                <p>Sabah is generally safe for tourists, but always take care of your belongings in crowded places. Some rural and remote areas may have limited medical services, so it's important to have travel insurance that covers emergencies.</p>
                <p><strong>Travel Insurance:</strong> Ensure you have comprehensive travel insurance that includes medical coverage and activities like diving or trekking.</p>
            </div>

            <div class="attraction-item">
                <h3>Shopping & Bargaining</h3>
                <p>Sabah offers plenty of markets, including the Gaya Street Sunday Market in Kota Kinabalu. Bargaining is acceptable at local markets but do so politely. In malls and larger shops, prices are usually fixed.</p>
            </div>

            <div class="attraction-item">
                <h3>Food Safety</h3>
                <p>Sabah's street food is generally safe, but stick to vendors that look busy to ensure the food is fresh. Drink bottled water, as tap water is not always safe for consumption.</p>
                <p><strong>Tap Water:</strong> Always opt for bottled or filtered water, especially in rural areas.</p>
            </div>

            <div class="attraction-item">
                <h3>Respecting Local Customs</h3>
                <p>
                    <strong>Modest Dress:</strong> While Sabah is a mix of cultures, it’s recommended to dress modestly, especially in rural areas and when visiting religious sites.<br>
                    <strong>Religious Sites:</strong> Always remove shoes before entering mosques or temples. For women, wearing a headscarf is appreciated when visiting mosques.<br>
                    <strong>Greetings:</strong> A smile and a friendly greeting go a long way. When meeting locals, a slight nod or a handshake with both hands is customary.
                </p>
            </div>

            <div class="attraction-item">
                <h3>Tipping</h3>
                <p>Tipping is not a common practice in Sabah, but it is appreciated in tourist areas and at higher-end restaurants. Rounding up the bill or leaving small change is a nice gesture.</p>
            </div>

            <div class="attraction-item">
                <h3>Local Festivals</h3>
                <p>Festivals like the Kaamatan Harvest Festival in May and the Regatta Lepa in Semporna are great times to experience Sabah's cultural heritage, with traditional music, dances, and local food.</p>
            </div>

            <div class="attraction-item">
                <h3>Nearby Islands</h3>
                <p>Sabah is famous for its beautiful islands like Sipadan, Mabul, and Manukan. Plan ahead and book ferry or boat trips in advance, especially during peak tourist seasons.</p>
            </div>
        </div>
    </section>



    <!-- Map Section -->
    <section class="map">
        <h2>Map of Sabah</h2>
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d4065245.1627011504!2d112.27793354060329!3d5.718039851561616!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x32155171c8bc8a9d%3A0x889d1e436c96b307!2sSabah!5e0!3m2!1sen!2smy!4v1727612365918!5m2!1sen!2smy" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
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