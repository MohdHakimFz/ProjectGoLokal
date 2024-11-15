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
    <title>Explore Pahang - GoLokal</title>
    <link rel="stylesheet" href="assets/css/Pahang.css">
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
    <section class="Pahang-intro">
        <h1>Discover Pahang</h1>
        <img src="assets/image/Pahang/Flag Pahang.png" alt="Pahang Flag">
        <p>Pahang, the largest state in Peninsular Malaysia, is a nature lover's paradise. From the cool highlands of Cameron to the jungles of Taman Negara and the beaches of Cherating, Pahang is the ultimate destination for outdoor enthusiasts.</p>
    </section>

    <!-- Top Attractions Section -->
    <section class="attractions">
        <h2>Top Attractions in Pahang</h2>
        <div class="attraction-list">
            <div class="attraction-item">
                <img src="assets/image/Pahang/Cameron Highlands.jpg" alt="Cameron Highlands">
                <h3>Cameron Highlands</h3>
                <p>Famous for its cool climate, tea plantations, strawberry farms, and scenic views, Cameron Highlands is one of the most popular highland retreats in Malaysia.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Pahang/Taman Negara.png" alt="Taman Negara">
                <h3>Taman Negara</h3>
                <p>Explore the lush tropical rainforest of Taman Negara, one of the world’s oldest rainforests, offering activities like jungle trekking, canopy walks, and wildlife spotting.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Pahang/Genting Highlands.jpg" alt="Genting Highlands">
                <h3>Genting Highlands</h3>
                <p>A famous hill resort known for its casinos, theme parks, and cool weather, Genting Highlands offers entertainment and relaxation for families and tourists alike.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Pahang/Bukit Tinggi.jpg" alt="Bukit Tinggi">
                <h3>Bukit Tinggi</h3>
                <p>Visit the charming French-themed Colmar Tropicale in Bukit Tinggi, a quaint hill resort offering a European village experience with cool mountain air.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Pahang/Pahang.jpg" alt="Teluk Cempedak Beach">
                <h3>Teluk Cempedak Beach</h3>
                <p>A beautiful sandy beach located just outside of Kuantan, Teluk Cempedak is perfect for relaxing, swimming, and enjoying seaside activities.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Pahang/Sungai Lembing.jpg" alt="Sungai Lembing">
                <h3>Sungai Lembing</h3>
                <p>Once a thriving tin mining town, Sungai Lembing offers visitors a glimpse into its rich mining history along with stunning views of the sunrise from Bukit Panorama.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Pahang/Cherating Beach.jpg" alt="Cherating Beach">
                <h3>Cherating Beach</h3>
                <p>Cherating is known for its pristine beach, surfing spots, and traditional crafts like batik painting. It’s also home to Malaysia’s first Club Med resort.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Pahang/Fraser's Hill.jpeg" alt="Fraser's Hill">
                <h3>Fraser's Hill</h3>
                <p>A quiet hill station with colonial charm, Fraser’s Hill is ideal for nature lovers, offering bird watching, jungle trekking, and cool mountain weather.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Pahang/Kuantan River Cruise.jpg" alt="Kuantan River Cruise">
                <h3>Kuantan River Cruise</h3>
                <p>Take a relaxing cruise along the Kuantan River, where you can observe the serene mangrove forests, local wildlife, and beautiful sunset views.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Pahang/Tioman Island.jpg" alt="Tioman Island">
                <h3>Tioman Island</h3>
                <p>Tioman Island is a tropical paradise known for its crystal-clear waters, vibrant coral reefs, and pristine beaches. It’s perfect for snorkeling, diving, and beachside relaxation.</p>
            </div>

        </div>
    </section>

    <!-- Cultural Heritage Section -->
    <section class="culture">
        <h2>Cultural Heritage of Pahang</h2>
        <div class="attraction-list">
            <div class="attraction-item">
                <img src="assets/image/Pahang/Muzium Sultan Abu Bakar.jpg" alt="Muzium Sultan Abu Bakar">
                <h3>Muzium Sultan Abu Bakar</h3>
                <p>This museum, located in Pekan, offers a glimpse into Pahang’s royal history, displaying royal regalia, artifacts, and historical items from the Sultanate of Pahang.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Pahang/Pekan Royal Town.jpg" alt="Pekan Royal Town">
                <h3>Pekan Royal Town</h3>
                <p>Visit the royal town of Pekan, home to the Sultan of Pahang. This historical town features royal palaces, traditional architecture, and beautiful mosques.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Pahang/Masjid Sultan Ahmad Shah.jpg" alt="Masjid Sultan Ahmad Shah">
                <h3>Masjid Sultan Ahmad Shah</h3>
                <p>This iconic mosque in Kuantan is an architectural masterpiece and a symbol of Islamic heritage in Pahang, featuring intricate designs and a stunning blue dome.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Pahang/Kampung Budu.webp" alt="Kampung Budu">
                <h3>Kampung Budu</h3>
                <p>Kampung Budu is a historical Malay village known for its traditional wooden houses and the birthplace of local heroes during the British colonial era.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Pahang/Kuantan Chinese Temple.jpg" alt="Kuantan Chinese Temple">
                <h3>Kuantan Chinese Temple</h3>
                <p>This Chinese temple in Kuantan reflects the rich Chinese heritage in Pahang and is an important cultural and religious site for the local Chinese community.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Pahang/Kuala Lipis.jpeg" alt="Kuala Lipis">
                <h3>Kuala Lipis</h3>
                <p>Kuala Lipis was once the capital of Pahang during the British era and retains colonial architecture, including the former District Office and British residences.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Pahang/Gua Charas.jpg" alt="Gua Charas">
                <h3>Gua Charas</h3>
                <p>Gua Charas is a limestone cave that holds a large reclining Buddha statue, reflecting the influence of Buddhism in the region and offering spiritual peace and natural beauty.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Pahang/Mat Kilau Mausoleum.jpeg" alt="Mat Kilau Mausoleum">
                <h3>Mat Kilau Mausoleum</h3>
                <p>The Mat Kilau Mausoleum in Kampung Kelubi is dedicated to the legendary Malay warrior Mat Kilau, who fought against British colonization in Pahang.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Pahang/Bentong Hot Springs.jpg" alt="Bentong Hot Springs">
                <h3>Bentong Hot Springs</h3>
                <p>These hot springs are a popular attraction in Bentong and have historical significance as a natural wellness spot traditionally used by locals for healing.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Pahang/Lurah Bilut Settlement.webp" alt="Lurah Bilut Settlement">
                <h3>Lurah Bilut Settlement</h3>
                <p>Lurah Bilut is Malaysia’s first FELDA settlement and is an important cultural and historical site, symbolizing the beginning of Malaysia’s agricultural and land development efforts.</p>
            </div>
        </div>
    </section>


    <!-- Adventure & Nature Section -->
    <section class="adventure">
        <h2>Adventure & Nature in Pahang</h2>
        <div class="attraction-list">
            <div class="attraction-item">
                <img src="assets/image/Pahang/Taman Negara.jpg" alt="Taman Negara">
                <h3>Taman Negara</h3>
                <p>Explore one of the world’s oldest rainforests at Taman Negara. It offers activities like jungle trekking, canopy walks, cave exploration, and river cruises.</p>
                <h4>Activities: Jungle trekking, canopy walks, river cruises, and wildlife observation</h4>
                <h4>Location: Kuala Tahan, Pahang</h4>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Pahang/Cameron Highlands.jpg" alt="Cameron Highlands">
                <h3>Cameron Highlands</h3>
                <p>Cameron Highlands is known for its cool climate, lush tea plantations, strawberry farms, and beautiful hill stations offering hiking and sightseeing.</p>
                <h4>Activities: Hiking, tea plantation tours, strawberry picking, and sightseeing</h4>
                <h4>Location: Cameron Highlands, Pahang</h4>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Pahang/Fraser's Hill.jpeg" alt="Fraser's Hill">
                <h3>Fraser's Hill</h3>
                <p>A quaint hill station, Fraser's Hill is perfect for bird watching, jungle trekking, and relaxing amidst cool mountain weather and colonial architecture.</p>
                <h4>Activities: Bird watching, hiking, nature photography, and golfing</h4>
                <h4>Location: Fraser's Hill, Pahang</h4>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Pahang/Berkelah Falls.jpg" alt="Berkelah Falls">
                <h3>Berkelah Falls</h3>
                <p>Located near Kuantan, Berkelah Falls is a stunning multi-tiered waterfall, ideal for hiking, picnicking, and swimming in natural pools.</p>
                <h4>Activities: Hiking, swimming, and picnicking</h4>
                <h4>Location: Kuantan, Pahang</h4>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Pahang/Endau-Rompin National Park.jpg" alt="Endau-Rompin National Park">
                <h3>Endau-Rompin National Park</h3>
                <p>Endau-Rompin National Park is a protected rainforest offering opportunities for jungle trekking, camping, and exploring its majestic waterfalls and unique biodiversity.</p>
                <h4>Activities: Jungle trekking, camping, waterfall exploration, and bird watching</h4>
                <h4>Location: Pahang and Johor border</h4>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Pahang/Sungai Pandan Waterfall.jpg" alt="Sungai Pandan Waterfall">
                <h3>Sungai Pandan Waterfall</h3>
                <p>Also known as Panching Waterfall, this natural beauty is a great spot for a family outing, offering cool waters for swimming and scenic picnicking spots.</p>
                <h4>Activities: Swimming, picnicking, and nature photography</h4>
                <h4>Location: Kuantan, Pahang</h4>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Pahang/Kuala Gandah Elephant Sanctuary.jpg" alt="Kuala Gandah Elephant Sanctuary">
                <h3>Kuala Gandah Elephant Sanctuary</h3>
                <p>Visit the Kuala Gandah Elephant Sanctuary, where you can learn about conservation efforts and interact with rescued elephants in their natural habitat.</p>
                <h4>Activities: Elephant conservation, education tours, and wildlife observation</h4>
                <h4>Location: Lanchang, Pahang</h4>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Pahang/Pahang.jpg" alt="Teluk Cempedak Beach">
                <h3>Teluk Cempedak Beach</h3>
                <p>A popular beach near Kuantan, Teluk Cempedak offers beautiful coastal views, water sports, and nearby jungle trails, making it perfect for adventure and relaxation.</p>
                <h4>Activities: Swimming, jungle trekking, and water sports</h4>
                <h4>Location: Kuantan, Pahang</h4>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Pahang/Cherating Beach.jpg" alt="Cherating Beach">
                <h3>Cherating Beach</h3>
                <p>Known for its pristine beaches and calm waters, Cherating is ideal for surfing, relaxing, and exploring local wildlife at the nearby Cherating Turtle Sanctuary.</p>
                <h4>Activities: Surfing, beach picnics, and wildlife observation</h4>
                <h4>Location: Cherating, Pahang</h4>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Pahang/Tioman Island.jpg" alt="Tioman Island">
                <h3>Tioman Island</h3>
                <p>Tioman Island is a tropical paradise known for its crystal-clear waters, vibrant coral reefs, and pristine beaches, perfect for snorkeling, diving, and relaxing by the beach.</p>
                <h4>Activities: Snorkeling, scuba diving, and beach activities</h4>
                <h4>Location: Tioman Island, Pahang</h4>
            </div>
        </div>
    </section>

    <!-- Food & Cuisine Section -->
    <section class="cuisine">
        <h2>Food & Cuisine in Pahang</h2>
        <div class="attraction-list">
            <div class="attraction-item">
                <img src="assets/image/Pahang/Puding Diraja.jpg" alt="Puding Diraja">
                <h3>Puding Diraja</h3>
                <p>Puding Diraja, or Royal Pudding, is a traditional dessert from Pahang made of bananas, prunes, cherries, and ghee-rich custard, typically served to the royal family.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Pahang/Patin Tempoyak.jpg" alt="Patin Tempoyak">
                <h3>Patin Tempoyak</h3>
                <p>This famous dish features Patin fish cooked in a spicy gravy made from fermented durian (tempoyak), a signature dish of Pahang’s traditional cuisine.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Pahang/Satay Pahang.jpg" alt="Satay Pahang">
                <h3>Satay Pahang</h3>
                <p>Satay in Pahang is known for its tender marinated meat skewers, grilled over a charcoal fire, and served with peanut sauce and compressed rice cakes (ketupat).</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Pahang/Sambal Hitam.jpg" alt="Sambal Hitam">
                <h3>Sambal Hitam</h3>
                <p>Sambal Hitam is a unique Pahang dish made from boiled belimbing (a local sour fruit), anchovies, and chilies, offering a tangy and spicy flavor.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Pahang/Opor Pahang.jpeg" alt="Opor Pahang">
                <h3>Opor Pahang</h3>
                <p>Opor Pahang is a slow-cooked beef dish, marinated in a blend of spices and coconut milk, resulting in tender and flavorful meat.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Pahang/Ikan Bakar.webp" alt="Ikan Bakar">
                <h3>Ikan Bakar</h3>
                <p>Grilled fish, or Ikan Bakar, is a popular seafood dish in Pahang, often served with a tangy sambal and eaten with rice or local sides.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Pahang/Tempoyak.jpeg" alt="Tempoyak">
                <h3>Tempoyak</h3>
                <p>Tempoyak is fermented durian, often used as a side dish or as an ingredient in cooking, particularly in the famous Patin Tempoyak dish.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Pahang/Kerabu Pucuk Paku.jpg" alt="Kerabu Pucuk Paku">
                <h3>Kerabu Pucuk Paku</h3>
                <p>Kerabu Pucuk Paku is a healthy and refreshing salad made from young fern shoots, tossed with grated coconut, lime, chilies, and spices.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Pahang/Lempeng Nyiur.jpg" alt="Lempeng Nyiur">
                <h3>Lempeng Nyiur</h3>
                <p>Lempeng Nyiur is a coconut pancake, often eaten as a breakfast dish, served with sugar, syrup, or sambal for a sweet or savory taste.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Pahang/Kuih Peniram.jpg" alt="Kuih Peniram">
                <h3>Kuih Peniram</h3>
                <p>A traditional Malay fried snack, Kuih Peniram is made from rice flour and palm sugar, giving it a chewy texture and sweet flavor.</p>
            </div>
        </div>
    </section>


    <!-- Travel Tips Section -->
    <section class="travel-tips">
        <h2>Travel Tips for Pahang</h2>
        <div class="attraction-list">
            <div class="attraction-item">
                <h3>Best Time to Visit</h3>
                <p>The best time to visit Pahang is between March and October. The weather is cooler in the highlands like Cameron Highlands and Genting Highlands. The monsoon season from November to February brings heavy rain, which may affect beach and nature activities.</p>
            </div>

            <div class="attraction-item">
                <h3>How to Get There</h3>
                <p>
                    <strong>Flights:</strong> The main airport in Pahang is Sultan Ahmad Shah Airport (KUA) in Kuantan, which has flights to/from Kuala Lumpur and several domestic locations.<br>
                    <strong>By Road:</strong> Pahang is well-connected by highways from Kuala Lumpur, which takes about 3-4 hours by car to places like Kuantan or Genting Highlands.<br>
                    <strong>Buses:</strong> Express buses are available from Kuala Lumpur and other cities to various parts of Pahang, such as Kuantan, Cameron Highlands, and Jerantut.
                </p>
            </div>

            <div class="attraction-item">
                <h3>Currency</h3>
                <p>The official currency is the Malaysian Ringgit (MYR). Although credit cards are accepted in most tourist areas, it’s recommended to carry cash for small purchases, especially in rural areas or at local markets.</p>
            </div>

            <div class="attraction-item">
                <h3>Language</h3>
                <p>Bahasa Malaysia is the official language, but English is widely spoken, especially in tourist-friendly areas such as Genting Highlands and Cameron Highlands. You won’t have any trouble communicating with locals in English.</p>
            </div>

            <div class="attraction-item">
                <h3>Local Transportation</h3>
                <p>
                    <strong>Taxis & E-Hailing Services:</strong> Taxis and e-hailing services like Grab are commonly available in Kuantan, Genting Highlands, and Cameron Highlands.<br>
                    <strong>Buses:</strong> Public buses are available in larger towns, but renting a car is more convenient for exploring remote areas like Taman Negara.<br>
                    <strong>Driving:</strong> Roads in Pahang are generally in good condition, but be cautious when driving in the highlands due to winding and foggy conditions.
                </p>
            </div>

            <div class="attraction-item">
                <h3>Safety</h3>
                <p>Pahang is generally safe for tourists, but always practice common sense, such as avoiding secluded areas at night and keeping an eye on personal belongings in crowded places. Ensure that your accommodations are secure and lock your doors when staying at remote resorts or lodges.</p>
                <p><strong>Travel Insurance:</strong> It is advisable to have travel insurance covering health, accidents, and trip cancellations, particularly if you plan to engage in outdoor activities like jungle trekking.</p>
            </div>

            <div class="attraction-item">
                <h3>Food Safety</h3>
                <p>Pahang’s local food is generally safe to eat. Stick to restaurants and food stalls that appear busy, as the food turnover is faster. Be cautious when consuming raw food and opt for bottled or boiled water in rural areas.</p>
            </div>

            <div class="attraction-item">
                <h3>Shopping & Bargaining</h3>
                <p>Shopping at local markets is a fun experience in Pahang, especially in Cameron Highlands. Feel free to bargain at markets and street stalls, but remember to do so politely. Shops in tourist areas may have fixed prices.</p>
            </div>

            <div class="attraction-item">
                <h3>Respecting Local Customs</h3>
                <p>
                    <strong>Modest Dress:</strong> Pahang is more conservative compared to urban areas. Dress modestly, especially when visiting rural areas or religious sites. Cover your shoulders and knees when entering mosques.<br>
                    <strong>Mosques:</strong> Visitors are welcome at mosques, but always remove shoes before entering. Women should wear a headscarf, and men should dress modestly.<br>
                    <strong>Greetings:</strong> A gentle handshake or a nod of the head is a common greeting. When shaking hands with Muslims, avoid a firm grip and offer both hands.
                </p>
            </div>

            <div class="attraction-item">
                <h3>Eco-friendly Travel</h3>
                <p>While visiting nature spots like Taman Negara or Cameron Highlands, be mindful of eco-friendly practices. Avoid littering, stay on marked trails during hikes, and support local conservation efforts by following park guidelines.</p>
            </div>

            <div class="attraction-item">
                <h3>Local Festivals</h3>
                <p>Pahang celebrates major festivals like Hari Raya Aidilfitri, Deepavali, and Chinese New Year. Participating in these festivals is a great way to experience local culture, food, and traditions. Pahang also celebrates cultural festivals such as the Cameron Highlands Flower Festival and the Kuantan River Cruise Festival.</p>
            </div>
        </div>
    </section>



    <!-- Map Section -->
    <section class="map">
        <h2>Map of Pahang</h2>
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2038714.755542982!2d101.45821167225188!3d3.618379520693957!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31c504e2889d108b%3A0x8b39eb767e5ba846!2sPahang!5e0!3m2!1sen!2smy!4v1727556852659!5m2!1sen!2smy" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
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