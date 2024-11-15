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
    <title>Explore Negeri Sembilan - GoLokal</title>
    <link rel="stylesheet" href="assets/css/NegeriSembilan.css">
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
    <section class="sembilan-intro">
        <h1>Discover Negeri Sembilan</h1>
        <img src="assets/image/Negeri Sembilan/Flag Negeri Sembilan.png" alt="Negeri Sembilan Flag">
        <p>Negeri Sembilan is known for its unique Minangkabau culture and distinctive architecture with sweeping buffalo-horn roofs. The state is also home to beautiful natural landscapes, from serene beaches to lush rainforests.</p>
    </section>

    <!-- Top Attractions Section -->
    <section class="attractions">
        <h2>Top Attractions in Negeri Sembilan</h2>
        <div class="attraction-list">
            <div class="attraction-item">
                <img src="assets/image/Negeri Sembilan/Port Dickson Beach.webp" alt="Port Dickson Beach">
                <h3>Port Dickson Beach</h3>
                <p>Relax and enjoy the sun on the sandy beaches of Port Dickson, one of the most popular beach destinations in Negeri Sembilan.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Negeri Sembilan/Cape Rachado Lighthouse.jpg" alt="Cape Rachado Lighthouse">
                <h3>Cape Rachado Lighthouse</h3>
                <p>Explore the historic Cape Rachado Lighthouse, offering panoramic views of the Straits of Malacca and excellent bird-watching opportunities.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Negeri Sembilan/Ulu Bendul Recreational Park.jpg" alt="Ulu Bendul Recreational Park">
                <h3>Ulu Bendul Recreational Park</h3>
                <p>A serene recreational park nestled at the base of Gunung Angsi, ideal for picnics, swimming, and hiking through lush rainforest.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Negeri Sembilan/Gunung Angsi.jpg" alt="Gunung Angsi">
                <h3>Gunung Angsi</h3>
                <p>Challenge yourself with a hike up Gunung Angsi, one of the highest peaks in Negeri Sembilan, offering rewarding views at the summit.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Negeri Sembilan/Palm Mall Seremban.jpeg" alt="Palm Mall Seremban">
                <h3>Palm Mall Seremban</h3>
                <p>A popular shopping destination in Seremban, Palm Mall offers a variety of retail stores, entertainment options, and dining experiences.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Negeri Sembilan/Sri Menanti Royal Museum.jpg" alt="Sri Menanti Royal Museum">
                <h3>Sri Menanti Royal Museum</h3>
                <p>Step into history at the Sri Menanti Royal Museum, a former royal palace built in traditional Minangkabau style, showcasing royal artifacts and cultural heritage.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Negeri Sembilan/Jeram Toi Waterfall.jpg" alt="Jeram Toi Waterfall">
                <h3>Jeram Toi Waterfall</h3>
                <p>A refreshing retreat in nature, Jeram Toi Waterfall is a great spot for picnicking, swimming, and enjoying the cool waters amidst a beautiful forest backdrop.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Negeri Sembilan/Tanjung Tuan Forest Reserve.jpg" alt="Tanjung Tuan Forest Reserve">
                <h3>Tanjung Tuan Forest Reserve</h3>
                <p>Known for its wildlife and scenic trails, Tanjung Tuan Forest Reserve is a favorite spot for hiking, bird watching, and exploring nature near the coast.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Negeri Sembilan/Rembau Museum.jpg" alt="Rembau Museum">
                <h3>Rembau Museum</h3>
                <p>Learn about the history, culture, and traditions of Negeri Sembilan at the Rembau Museum, featuring exhibits on the local Minangkabau community.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Negeri Sembilan/Lata Kijang Waterfall.jpg" alt="Lata Kijang Waterfall">
                <h3>Lata Kijang Waterfall</h3>
                <p>One of the tallest waterfalls in Malaysia, Lata Kijang is a hidden gem surrounded by dense jungle, offering scenic beauty and tranquility for nature lovers.</p>
            </div>
        </div>
        </div>
    </section>


    <!-- Cultural Heritage Section -->
    <section class="culture">
        <h2>Cultural Heritage of Negeri Sembilan</h2>
        <div class="attraction-list">
            <div class="attraction-item">
                <img src="assets/image/Negeri Sembilan/Sri Menanti Royal Museum.jpg" alt="Sri Menanti Royal Museum">
                <h3>Sri Menanti Royal Museum</h3>
                <p>Explore the grand Sri Menanti Royal Museum, a former royal palace showcasing the rich history and culture of the Negeri Sembilan royal family.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Negeri Sembilan/Minangkabau Cultural Complex.jpg" alt="Minangkabau Cultural Complex">
                <h3>Minangkabau Cultural Complex</h3>
                <p>This cultural complex celebrates Negeri Sembilan's Minangkabau heritage, with exhibits on traditional architecture, customs, and history.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Negeri Sembilan/Kampung Pelegong Homestay.jpg" alt="Kampung Pelegong Homestay">
                <h3>Kampung Pelegong Homestay</h3>
                <p>Experience traditional Malay village life at Kampung Pelegong, where visitors can participate in local crafts, farming, and cultural activities.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Negeri Sembilan/Adat Museum.jpg" alt="Adat Museum">
                <h3>Adat Museum</h3>
                <p>The Adat Museum showcases the unique customs and traditions of the Minangkabau people, including marriage rites, architecture, and local history.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Negeri Sembilan/Astana Raja Melewar.jpg" alt="Astana Raja Melewar">
                <h3>Astana Raja Melewar</h3>
                <p>This historical palace was the home of Negeri Sembilan’s first Yang di-Pertuan Besar, Raja Melewar, and remains an important symbol of the state's royal history.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Negeri Sembilan/Rembau Crystal.webp" alt="Rembau Crystal">
                <h3>Rembau Crystal</h3>
                <p>Rembau is known for its glass-blowing and crystal-making industry. Visit to see artisans at work and purchase locally crafted crystal items.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Negeri Sembilan/Pengkalan Kempas Historical Complex.jpg" alt="Pengkalan Kempas Historical Complex">
                <h3>Pengkalan Kempas Historical Complex</h3>
                <p>Explore the mysterious Pengkalan Kempas Historical Complex, which houses ancient megaliths, also known as “Batu Hidup” (Living Stones). These stones are believed to date back to the 14th century and are associated with local legends and historical figures.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Negeri Sembilan/Kuala Pilah Traditional Houses.jpg" alt="Kuala Pilah Traditional Houses">
                <h3>Kuala Pilah Traditional Houses</h3>
                <p>Visit Kuala Pilah to see well-preserved traditional Minangkabau-style houses, with their distinctive horn-shaped roofs and wooden structures.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Negeri Sembilan/Chengkau Lake and Kampung Hakka.webp" alt="Chengkau Lake">
                <h3>Chengkau Lake and Kampung Hakka</h3>
                <p>Discover the history of Negeri Sembilan’s Hakka Chinese community at Kampung Hakka, near the picturesque Chengkau Lake, rich in cultural significance.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Negeri Sembilan/Malay Traditional House in Pantai.jpg" alt="Malay Traditional House">
                <h3>Malay Traditional House in Pantai</h3>
                <p>This traditional wooden house in the village of Pantai showcases classic Malay architecture, complete with carvings and intricate woodwork.</p>
            </div>
        </div>
    </section>

    <!-- Adventure & Nature Section -->
    <section class="adventure">
        <h2>Adventure & Nature in Negeri Sembilan</h2>
        <div class="attraction-list">
            <div class="attraction-item">
                <img src="assets/image/Negeri Sembilan/Ulu Bendul Recreational Park.jpg" alt="Ulu Bendul Recreational Park">
                <h3>Ulu Bendul Recreational Park</h3>
                <p>Nestled at the base of Gunung Angsi, Ulu Bendul Recreational Park is perfect for a family day out with hiking trails, freshwater streams, and picnic spots.</p>
                <h4>Activities: Hiking, picnicking, swimming</h4>
                <h4>Location: Kuala Pilah, Negeri Sembilan</h4>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Negeri Sembilan/Gunung Angsi.jpg" alt="Gunung Angsi">
                <h3>Gunung Angsi</h3>
                <p>Gunung Angsi is one of the most popular hiking destinations in Negeri Sembilan, offering a challenging trek with rewarding views at the summit.</p>
                <h4>Activities: Hiking, nature photography, bird watching</h4>
                <h4>Location: Kuala Pilah, Negeri Sembilan</h4>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Negeri Sembilan/Jeram Toi Waterfall.jpg" alt="Jeram Toi Waterfall">
                <h3>Jeram Toi Waterfall</h3>
                <p>Jeram Toi Waterfall is a refreshing escape into nature, ideal for a family outing with cool water pools, picnic areas, and scenic forest surroundings.</p>
                <h4>Activities: Swimming, picnicking, nature walks</h4>
                <h4>Location: Jelebu, Negeri Sembilan</h4>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Negeri Sembilan/Tanjung Tuan Forest Reserve.jpg" alt="Tanjung Tuan Forest Reserve">
                <h3>Tanjung Tuan Forest Reserve</h3>
                <p>Tanjung Tuan Forest Reserve offers scenic trails and is known for bird watching, especially during the migratory season. Its coastal views are spectacular.</p>
                <h4>Activities: Bird watching, hiking, nature photography</h4>
                <h4>Location: Port Dickson, Negeri Sembilan</h4>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Negeri Sembilan/Blue Lagoon.jpg" alt="Blue Lagoon">
                <h3>BLue Lagoon</h3>
                <p>A serene spot in Port Dickson, Blue Lagoon is perfect for swimming, snorkeling, and beach relaxation with crystal-clear waters and soft sandy beaches.</p>
                <h4>Activities: Swimming, snorkeling, beach picnics</h4>
                <h4>Location: Port Dickson, Negeri Sembilan</h4>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Negeri Sembilan/Kuala Pilah Rice Fields.jpg" alt="Kuala Pilah Rice Fields">
                <h3>Kuala Pilah Rice Fields</h3>
                <p>Enjoy the scenic beauty of the Kuala Pilah rice fields, a peaceful rural landscape perfect for a nature walk or photography amidst endless green fields.</p>
                <h4>Activities: Nature walks, photography, bird watching</h4>
                <h4>Location: Kuala Pilah, Negeri Sembilan</h4>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Negeri Sembilan/Lata Kijang Waterfall.jpg" alt="Lata Kijang Waterfall">
                <h3>Lata Kijang Waterfall</h3>
                <p>One of the tallest waterfalls in Malaysia, Lata Kijang is surrounded by dense rainforest, making it a perfect spot for adventure seekers and nature lovers.</p>
                <h4>Activities: Hiking, waterfall exploration, camping</h4>
                <h4>Location: Jelebu, Negeri Sembilan</h4>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Negeri Sembilan/Pantai Saujana.jpeg" alt="Pantai Saujana">
                <h3>Pantai Saujana</h3>
                <p>Pantai Saujana is a popular beach in Port Dickson, offering water sports, relaxing beach walks, and beautiful sunsets by the sea.</p>
                <h4>Activities: Jet skiing, swimming, beach activities</h4>
                <h4>Location: Port Dickson, Negeri Sembilan</h4>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Negeri Sembilan/Seremban Lake Gardens.webp" alt="Seremban Lake Gardens">
                <h3>Seremban Lake Gardens</h3>
                <p>Seremban Lake Gardens is a tranquil city park with jogging trails, playgrounds, and serene lake views, perfect for a relaxing day out with family.</p>
                <h4>Activities: Jogging, picnicking, relaxing</h4>
                <h4>Location: Seremban, Negeri Sembilan</h4>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Negeri Sembilan/Gunung Datuk.jpg" alt="Gunung Datuk">
                <h3>Gunung Datuk</h3>
                <p>Gunung Datuk offers an adventurous trek through the jungle, culminating in stunning panoramic views from the summit, making it a favorite among hikers.</p>
                <h4>Activities: Hiking, bird watching, camping</h4>
                <h4>Location: Rembau, Negeri Sembilan</h4>
            </div>
        </div>
    </section>


    <!-- Food & Cuisine Section -->
    <section class="cuisine">
        <h2>Food & Cuisine in Negeri Sembilan</h2>
        <div class="attraction-list">
            <div class="attraction-item">
                <img src="assets/image/Negeri Sembilan/Rendang Itik.jpg" alt="Rendang Itik">
                <h3>Rendang Itik</h3>
                <p>A traditional Negeri Sembilan dish, Rendang Itik is a rich and flavorful duck curry slow-cooked with coconut milk, lemongrass, and chilies.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Negeri Sembilan/Masak Lemak Cili Api.jpg" alt="Masak Lemak Cili Api">
                <h3>Masak Lemak Cili Api</h3>
                <p>A spicy and creamy dish made with coconut milk and bird’s eye chilies, Masak Lemak Cili Api is often cooked with fish, chicken, or vegetables.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Negeri Sembilan/Sambal Tempoyak.jpg" alt="Sambal Tempoyak">
                <h3>Sambal Tempoyak</h3>
                <p>A unique dish made from fermented durian, Sambal Tempoyak is typically mixed with chilies and served with rice or grilled fish.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Negeri Sembilan/Sup Tulang.jpg" alt="Sup Tulang">
                <h3>Sup Tulang</h3>
                <p>Sup Tulang is a hearty bone broth soup, slow-cooked with beef bones, herbs, and spices, served with a squeeze of lime for extra flavor.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Negeri Sembilan/Lemang.jpeg" alt="Lemang">
                <h3>Lemang</h3>
                <p>Lemang is glutinous rice cooked in bamboo with coconut milk, traditionally served during festivals and special occasions with rendang or curries.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Negeri Sembilan/Ubi Kayu Rebus.jpg" alt="Ubi Kayu Rebus">
                <h3>Ubi Kayu Rebus</h3>
                <p>Ubi Kayu Rebus, or boiled cassava, is a simple yet popular traditional snack in Negeri Sembilan, often eaten with grated coconut and sugar.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Negeri Sembilan/Daging Salai Masak Lemak.jpg" alt="Daging Salai Masak Lemak">
                <h3>Daging Salai Masak Lemak</h3>
                <p>This smoky and creamy dish combines smoked beef (Daging Salai) with the rich, spicy flavors of Masak Lemak Cili Api for a delightful combination.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Negeri Sembilan/Cendol.jpeg" alt="Cendol">
                <h3>Cendol</h3>
                <p>A refreshing dessert made of shaved ice, coconut milk, palm sugar, and green rice flour jelly, Cendol is a favorite treat, especially on hot days.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Negeri Sembilan/Asam Pedas.jpg" alt="Asam Pedas">
                <h3>Asam Pedas</h3>
                <p>A tangy and spicy fish stew with tamarind, Asam Pedas is a popular dish in Negeri Sembilan, known for its bold, sour, and spicy flavors.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Negeri Sembilan/Kuih Apam.jpg" alt="Kuih Apam">
                <h3>Kuih Apam</h3>
                <p>Kuih Apam is a soft and fluffy traditional steamed cake, typically enjoyed with grated coconut and served during tea time or special events.</p>
            </div>
        </div>
    </section>

    <!-- Travel Tips Section -->
    <section class="travel-tips">
        <h2>Travel Tips for Negeri Sembilan</h2>
        <div class="attraction-list">
            <div class="attraction-item">
                <h3>Best Time to Visit</h3>
                <p>The best time to visit Negeri Sembilan is between March and October when the weather is pleasant for outdoor activities. The rainy season, from November to February, can bring heavy rain, especially in rural areas and forest reserves.</p>
            </div>

            <div class="attraction-item">
                <h3>How to Get There</h3>
                <p>
                    <strong>Flights:</strong> Negeri Sembilan is served by Kuala Lumpur International Airport (KLIA), about an hour’s drive from Seremban.<br>
                    <strong>By Road:</strong> Negeri Sembilan is well-connected by highways, making it easy to drive from Kuala Lumpur (about 1 hour) or Melaka (1.5 hours).<br>
                    <strong>Trains:</strong> The KTM train service stops in Seremban and other towns, offering a scenic route to Negeri Sembilan from other parts of Malaysia.
                </p>
            </div>

            <div class="attraction-item">
                <h3>Currency</h3>
                <p>The official currency is the Malaysian Ringgit (MYR). Most places accept credit cards, but it's advisable to carry some cash for local markets, rural areas, or smaller eateries.</p>
            </div>

            <div class="attraction-item">
                <h3>Language</h3>
                <p>Bahasa Malaysia is the official language, but English is commonly spoken in tourist areas and urban centers like Seremban. Communication should be easy for international visitors.</p>
            </div>

            <div class="attraction-item">
                <h3>Local Transportation</h3>
                <p>
                    <strong>Taxis & E-Hailing Services:</strong> Taxis and e-hailing services like Grab are readily available in larger towns like Seremban.<br>
                    <strong>Public Buses:</strong> Public buses are available but may not cover all tourist spots, so renting a car is a more convenient option for exploring rural and nature areas.<br>
                    <strong>Bicycles:</strong> Some homestays and rural areas offer bicycle rentals, providing a scenic way to explore villages and countryside.
                </p>
            </div>

            <div class="attraction-item">
                <h3>Safety</h3>
                <p>Negeri Sembilan is generally safe for tourists, but exercise standard precautions, especially in busy areas and night markets. Keep your belongings secure to avoid petty theft.</p>
                <p><strong>Travel Insurance:</strong> It’s a good idea to have travel insurance that covers medical emergencies and travel cancellations.</p>
            </div>

            <div class="attraction-item">
                <h3>Shopping & Bargaining</h3>
                <p>When shopping at markets and small stalls, bargaining is acceptable. Be polite and friendly when negotiating. In larger stores or malls, prices are generally fixed.</p>
            </div>

            <div class="attraction-item">
                <h3>Food Safety</h3>
                <p>Negeri Sembilan is known for its spicy cuisine. The food is generally safe to eat, but stick to busy stalls and restaurants to ensure food turnover and freshness. Drinking bottled or boiled water is recommended.</p>
            </div>

            <div class="attraction-item">
                <h3>Respecting Local Customs</h3>
                <p>
                    <strong>Modest Dress:</strong> When visiting mosques or rural areas, dress modestly by covering shoulders and knees.<br>
                    <strong>Mosques:</strong> Remove shoes before entering mosques, and women should wear a headscarf if entering the prayer areas.<br>
                    <strong>Greetings:</strong> A slight nod and a smile are customary. When shaking hands, offer a gentle handshake using both hands without a strong grip, particularly with Muslims.
                </p>
            </div>

            <div class="attraction-item">
                <h3>Tipping</h3>
                <p>Tipping is not common in Negeri Sembilan, but it’s appreciated in touristy areas, restaurants, and for services like taxis or hotels. Rounding up the bill or leaving some small change is a nice gesture.</p>
            </div>

            <div class="attraction-item">
                <h3>Local Festivals</h3>
                <p>Negeri Sembilan celebrates several local festivals such as Hari Raya Aidilfitri, Chinese New Year, and the annual Minangkabau Cultural Festival. These events are a great way to experience the state's cultural diversity.</p>
            </div>
        </div>
    </section>

    <!-- Map Section -->
    <section class="map">
        <h2>Map of Negeri Sembilan</h2>
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d510069.6012773196!2d101.87244293348034!3d2.839775969878296!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31cde76f651dda2b%3A0x2b4e482fbc170249!2sNegeri%20Sembilan!5e0!3m2!1sen!2smy!4v1727554359597!5m2!1sen!2smy" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
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