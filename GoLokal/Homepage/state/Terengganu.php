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
    <title>Explore Terengganu - GoLokal</title>
    <link rel="stylesheet" href="assets/css/terengganu.css">
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
    <section class="terengganu-intro">
        <h1>Discover Terengganu</h1>
        <img src="assets/image/Terengganu/Flag Terengganu.png" alt="Terengganu Flag">
        <p>Terengganu is a stunning state on the east coast of Malaysia, renowned for its crystal-clear waters, breathtaking islands, and rich cultural heritage. From idyllic beaches to traditional crafts and iconic mosques, Terengganu offers a unique blend of natural beauty and Malaysian culture that appeals to travelers of all interests.</p>
    </section>


    <!-- Top Attractions Section -->
    <section class="attractions">
        <h2>Top Attractions in Terengganu</h2>
        <div class="attraction-list">
            <div class="attraction-item">
                <img src="assets/image/Terengganu/Kapas Island.jpeg" alt="Kapas Island">
                <h3>Kapas Island</h3>
                <p>Famed for its clear waters, white sandy beaches, and coral reefs, Kapas Island is perfect for snorkeling, diving, and relaxation.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Terengganu/Redang Island.jpg" alt="Redang Island">
                <h3>Redang Island</h3>
                <p>One of Malaysia’s largest islands, Redang is a popular spot for crystal-clear water, pristine beaches, and diverse marine life.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Terengganu/Kenyir Lake.jpg" alt="Kenyir Lake">
                <h3>Kenyir Lake</h3>
                <p>The largest man-made lake in Southeast Asia, Kenyir Lake offers adventure opportunities like fishing, kayaking, and trekking.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Terengganu/Crystal Mosque.jpg" alt="Crystal Mosque">
                <h3>Crystal Mosque</h3>
                <p>An architectural masterpiece, this mosque is made from glass, crystal, and steel, offering a stunning view along the Terengganu River.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Terengganu/Perhentian Islands.jpg" alt="Perhentian Islands">
                <h3>Perhentian Islands</h3>
                <p>Renowned for crystal-clear waters, coral reefs, and vibrant marine life, these islands are popular among divers and beach lovers.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Terengganu/Marang.jpg" alt="Marang">
                <h3>Marang</h3>
                <p>A quaint fishing village known for its scenic coastal views and a gateway to nearby islands like Pulau Kapas.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Terengganu/Tengku Tengah Zaharah Mosque.jpg" alt="Tengku Tengah Zaharah Mosque">
                <h3>Tengku Tengah Zaharah Mosque</h3>
                <p>This floating mosque is a stunning architectural landmark located on the Terengganu River.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Terengganu/Bukit Puteri.jpg" alt="Bukit Puteri">
                <h3>Bukit Puteri</h3>
                <p>Offering panoramic views of Kuala Terengganu, this historical hill was once a fortress and provides insights into Terengganu’s past.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Terengganu/Terengganu State Museum.jpg" alt="Terengganu State Museum">
                <h3>Terengganu State Museum</h3>
                <p>The largest museum complex in Malaysia, it houses artifacts and exhibits that showcase Terengganu’s rich culture and history.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Terengganu/Kuala Terengganu Chinatown.jpg" alt="Kuala Terengganu Chinatown">
                <h3>Kuala Terengganu Chinatown</h3>
                <p>A vibrant area known for its colorful architecture, local Chinese culture, and delicious street food in the heart of Kuala Terengganu.</p>
            </div>
        </div>
    </section>

    <!-- Cultural Heritage Section -->
    <section class="culture">
        <h2>Cultural Heritage of Terengganu</h2>
        <div class="attraction-list">
            <div class="attraction-item">
                <img src="assets/image/Terengganu/Terengganu State Museum.jpg" alt="Terengganu State Museum">
                <h3>Terengganu State Museum</h3>
                <p>The largest museum complex in Malaysia, showcasing Terengganu’s rich culture and history with various exhibits on arts, crafts, and heritage.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Terengganu/Crystal Mosque.jpg" alt="Crystal Mosque">
                <h3>Crystal Mosque</h3>
                <p>This iconic mosque made from glass and steel represents a unique blend of modern and Islamic architecture, located along the Terengganu River.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Terengganu/Tengku Tengah Zaharah Mosque.jpg" alt="Tengku Tengah Zaharah Mosque">
                <h3>Tengku Tengah Zaharah Mosque</h3>
                <p>Also known as the Floating Mosque, it is a stunning religious landmark built over the Terengganu River, creating an illusion of floating on water.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Terengganu/Kuala Terengganu Chinatown.jpg" alt="Kampung China (Chinatown)">
                <h3>Kampung China (Chinatown)</h3>
                <p>Explore the vibrant and historic Kampung China, known for its colorful streets, traditional Chinese architecture, and cultural festivals.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Terengganu/Masarang Traditional Crafts.jpg" alt="Masarang Traditional Crafts">
                <h3>Masarang Traditional Crafts</h3>
                <p>Terengganu is famous for its traditional crafts such as songket weaving and batik making. Visit local artisans to see these crafts being made.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Terengganu/Sutra Beach Cultural Village.jpg" alt="Sutra Beach Cultural Village">
                <h3>Sutra Beach Cultural Village</h3>
                <p>A beachside cultural village where you can experience traditional Malay performances, including dance, music, and martial arts demonstrations.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Terengganu/Marang River.jpg" alt="Marang River">
                <h3>Marang River</h3>
                <p>Take a boat ride along Marang River to experience the local fishing villages and learn about the traditional livelihoods of the coastal communities.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Terengganu/Pulau Duyong.jpg" alt="Pulau Duyong">
                <h3>Pulau Duyong</h3>
                <p>Home to traditional boat-making, Pulau Duyong showcases the unique heritage of wooden boat construction that has been passed down for generations.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Terengganu/Losong Museum.jpg" alt="Losong Museum">
                <h3>Losong Museum</h3>
                <p>This museum focuses on the traditional keris (Malay dagger), offering insight into the craftsmanship and historical significance of this cultural artifact.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Terengganu/Bukit Puteri.jpg" alt="Bukit Puteri">
                <h3>Bukit Puteri</h3>
                <p>A historical hill in Kuala Terengganu that served as a defense fortress in the 19th century, offering panoramic views and historical significance.</p>
            </div>
        </div>
    </section>


    <!-- Adventure & Nature Section -->
    <section class="adventure">
        <h2>Adventure & Nature in Terengganu</h2>
        <div class="attraction-list">
            <div class="attraction-item">
                <img src="assets/image/Terengganu/Pulau Redang.jpg" alt="Pulau Redang">
                <h3>Pulau Redang</h3>
                <p>One of Malaysia’s most beautiful islands, Pulau Redang offers pristine beaches, crystal-clear waters, and vibrant coral reefs.</p>
                <h4>Activities: Snorkeling, scuba diving, and beach activities</h4>
                <h4>Location: Off the coast of Terengganu</h4>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Terengganu/Pulau Perhentian.jpg" alt="Pulau Perhentian">
                <h3>Pulau Perhentian</h3>
                <p>Known for its stunning marine life, Pulau Perhentian is a popular destination for divers and snorkelers.</p>
                <h4>Activities: Snorkeling, scuba diving, kayaking, and hiking</h4>
                <h4>Location: Off the coast of Terengganu</h4>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Terengganu/Pulau Kapas.jpg" alt="Pulau Kapas">
                <h3>Pulau Kapas</h3>
                <p>A small, serene island known for its white sandy beaches and calm waters, ideal for relaxation and snorkeling.</p>
                <h4>Activities: Snorkeling, swimming, and beach activities</h4>
                <h4>Location: Off the coast of Marang, Terengganu</h4>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Terengganu/Kenyir Lake.jpg" alt="Tasik Kenyir (Kenyir Lake)">
                <h3>Tasik Kenyir (Kenyir Lake)</h3>
                <p>The largest man-made lake in Southeast Asia, Tasik Kenyir offers diverse wildlife, scenic waterfalls, and lush greenery.</p>
                <h4>Activities: Fishing, kayaking, jungle trekking, and waterfall exploration</h4>
                <h4>Location: Hulu Terengganu, Terengganu</h4>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Terengganu/Taman Negara.jpg" alt="Taman Negara Terengganu">
                <h3>Taman Negara Terengganu</h3>
                <p>A part of Malaysia’s oldest rainforest, Taman Negara Terengganu is perfect for nature enthusiasts, offering a rich variety of flora and fauna.</p>
                <h4>Activities: Jungle trekking, bird watching, and camping</h4>
                <h4>Location: Hulu Terengganu, Terengganu</h4>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Terengganu/LaHotSprings.jpg" alt="La Hot Springs">
                <h3>La Hot Springs</h3>
                <p>Relax in the natural hot springs of La, surrounded by lush tropical rainforests in Terengganu.</p>
                <h4>Activities: Hot spring bathing and nature photography</h4>
                <h4>Location: Hulu Terengganu, Terengganu</h4>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Terengganu/Cemerong Waterfall.jpg" alt="Chemerong Waterfall">
                <h3>Chemerong Waterfall</h3>
                <p>One of the tallest waterfalls in Malaysia, Chemerong Waterfall is a must-visit for adventure seekers and nature lovers.</p>
                <h4>Activities: Jungle trekking, swimming, and nature exploration</h4>
                <h4>Location: Dungun, Terengganu</h4>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Terengganu/Pulau Lang tengah.jpg" alt="Pulau Lang Tengah">
                <h3>Pulau Lang Tengah</h3>
                <p>A secluded island between Pulau Redang and Pulau Perhentian, known for its tranquil environment and clear waters.</p>
                <h4>Activities: Snorkeling, diving, and wildlife observation</h4>
                <h4>Location: Off the coast of Terengganu</h4>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Terengganu/Rantau Abang.jpg" alt="Rantau Abang">
                <h3>Rantau Abang</h3>
                <p>Famous for its turtle conservation efforts, Rantau Abang is a great place to witness sea turtles nesting along the beach.</p>
                <h4>Activities: Turtle watching, beach walks, and nature observation</h4>
                <h4>Location: Dungun, Terengganu</h4>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Terengganu/Bukit Keluang.jpg" alt="Bukit Keluang">
                <h3>Bukit Keluang</h3>
                <p>A picturesque hill offering panoramic views of the South China Sea, perfect for hiking and photography enthusiasts.</p>
                <h4>Activities: Hiking, nature photography, and beach exploration</h4>
                <h4>Location: Besut, Terengganu</h4>
            </div>
        </div>
    </section>


    <!-- Food & Cuisine Section -->
    <section class="cuisine">
        <h2>Food & Cuisine in Terengganu</h2>
        <div class="attraction-list">
            <div class="attraction-item">
                <img src="assets/image/Terengganu/Nasi Dagang.avif" alt="Nasi Dagang">
                <h3>Nasi Dagang</h3>
                <p>A famous dish in Terengganu, Nasi Dagang is made of glutinous rice steamed with coconut milk, served with tuna curry and pickled vegetables.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Terengganu/Keropok Lekor.jpg" alt="Keropok Lekor">
                <h3>Keropok Lekor</h3>
                <p>A deep-fried fish sausage made with fish and sago, typically served with a spicy dipping sauce. It’s a popular snack in Terengganu.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Terengganu/Sata.jpg" alt="Sata">
                <h3>Sata</h3>
                <p>Sata is a grilled fish cake wrapped in banana leaves, made with fish, coconut, and spices. It’s a local delicacy in Terengganu.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Terengganu/Laksa Terengganu.jpg" alt="Laksa Terengganu">
                <h3>Laksa Terengganu</h3>
                <p>This variation of laksa is made with rice noodles served in a flavorful fish-based gravy, often topped with boiled eggs and fresh herbs.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Terengganu/Nasi Kerabu.webp" alt="Nasi Kerabu">
                <h3>Nasi Kerabu</h3>
                <p>A rice dish that comes with blue-colored rice (dyed by butterfly pea flowers) and served with salted eggs, fish crackers, and fried chicken or beef.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Terengganu/Budu.jpg" alt="Budu">
                <h3>Budu</h3>
                <p>Budu is a fermented fish sauce, often used as a condiment and served with rice, grilled fish, and ulam (local herbs).</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Terengganu/Otak-Otak.jpeg" alt="Otak-Otak">
                <h3>Otak-Otak</h3>
                <p>A grilled fish paste wrapped in banana leaves, Otak-Otak is made with fish, coconut milk, and spices, giving it a distinct flavor.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Terengganu/Lompat Tikam.jpg" alt="Lompat Tikam">
                <h3>Lompat Tikam</h3>
                <p>A traditional Malay dessert made with layers of pandan-flavored rice flour pudding and topped with coconut milk and gula Melaka (palm sugar).</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Terengganu/Kuih Lapis.jpg" alt="Kuih Lapis">
                <h3>Kueh Lapis</h3>
                <p>A famous Terengganu dessert, Kuih Lapis is a sweet glutinous rice cake filled with coconut, served during festive occasions.</p>
            </div>


            <div class="attraction-item">
                <img src="assets/image/Terengganu/Pulut Lepa.jpg" alt="Pulut Lepa">
                <h3>Pulut Lepa</h3>
                <p>Pulut Lepa is a sticky rice cake wrapped in banana leaves, filled with spicy fish floss. It is grilled until golden brown and fragrant.</p>
            </div>
        </div>
    </section>


    <!-- Travel Tips Section -->
    <section class="travel-tips">
        <h2>Travel Tips for Terengganu</h2>
        <div class="attraction-list">
            <div class="attraction-item">
                <h3>Best Time to Visit</h3>
                <p>The best time to visit Terengganu is between April and October, when the weather is dry and ideal for beach activities and island hopping. The monsoon season from November to February brings heavy rainfall and can affect travel plans, especially to the islands.</p>
            </div>

            <div class="attraction-item">
                <h3>How to Get There</h3>
                <p>
                    <strong>Flights:</strong> Sultan Mahmud Airport (TGG) in Kuala Terengganu is the main airport, with domestic flights connecting from major cities like Kuala Lumpur and Penang.<br>
                    <strong>By Road:</strong> Terengganu is accessible by car or bus from Kuala Lumpur, which takes about 5-6 hours. Many bus companies offer routes to various parts of the state.<br>
                    <strong>Ferries:</strong> To reach the islands like Pulau Redang or Pulau Perhentian, ferries are available from Merang or Kuala Besut. Be sure to check schedules, as they may change depending on the season.
                </p>
            </div>

            <div class="attraction-item">
                <h3>Currency</h3>
                <p>The official currency is the Malaysian Ringgit (MYR). While larger hotels and tourist attractions may accept credit cards, it’s a good idea to carry cash, especially when visiting rural areas or the islands.</p>
            </div>

            <div class="attraction-item">
                <h3>Language</h3>
                <p>The main language spoken in Terengganu is Bahasa Malaysia, but English is commonly understood in tourist areas and larger towns. In rural areas, it’s helpful to know a few basic Malay phrases.</p>
            </div>

            <div class="attraction-item">
                <h3>Local Transportation</h3>
                <p>
                    <strong>Taxis & E-Hailing:</strong> Taxis are available, but e-hailing services like Grab are often more reliable and cheaper.<br>
                    <strong>Public Buses:</strong> Public buses connect major towns, but services may be infrequent. If you're planning to explore more remote places, renting a car can offer more flexibility.<br>
                    <strong>Ferry Services:</strong> Ferries are the primary mode of transport to the islands. Be sure to book in advance, especially during the peak season.
                </p>
            </div>

            <div class="attraction-item">
                <h3>Safety</h3>
                <p>Terengganu is generally safe for tourists. However, take care of your belongings when in crowded areas like markets. When swimming in the sea, especially during the monsoon season, be cautious of strong currents.</p>
                <p><strong>Travel Insurance:</strong> Travel insurance is recommended, especially if you plan to participate in water sports or island excursions.</p>
            </div>

            <div class="attraction-item">
                <h3>Shopping & Bargaining</h3>
                <p>Terengganu is known for its batik, songket, and handicrafts. You can find many unique souvenirs at the local markets. Bargaining is acceptable in smaller markets, but do it respectfully.</p>
            </div>

            <div class="attraction-item">
                <h3>Food Safety</h3>
                <p>Terengganu is famous for its fresh seafood. Street food is generally safe, but stick to vendors with high turnover. As in other parts of Malaysia, it’s better to drink bottled or boiled water.</p>
            </div>

            <div class="attraction-item">
                <h3>Respecting Local Customs</h3>
                <p>
                    <strong>Modest Dress:</strong> Terengganu is more conservative compared to other parts of Malaysia, so it’s advisable to dress modestly, especially in rural areas or when visiting mosques.<br>
                    <strong>Mosques:</strong> Visitors are welcome in mosques, but ensure to cover up, remove your shoes, and women should wear a headscarf.<br>
                    <strong>Greetings:</strong> When greeting locals, a smile and nod are appreciated. Handshakes are common, but use both hands lightly when shaking hands with Muslims.
                </p>
            </div>

            <div class="attraction-item">
                <h3>Tipping</h3>
                <p>Tipping is not common practice in Malaysia, but it is appreciated in tourist areas or at restaurants. Leaving a small tip or rounding up the bill is considered a polite gesture.</p>
            </div>

            <div class="attraction-item">
                <h3>Local Festivals</h3>
                <p>Terengganu celebrates festivals like Hari Raya Aidilfitri, Chinese New Year, and Hari Raya Haji. Additionally, Terengganu hosts the annual Monsoon Cup, an international sailing event held during the monsoon season.</p>
            </div>

            <div class="attraction-item">
                <h3>Island Hopping</h3>
                <p>Terengganu is home to some of Malaysia’s most stunning islands, like Pulau Redang, Pulau Perhentian, and Pulau Kapas. These islands offer incredible snorkeling, diving, and beach experiences. Plan ahead during the monsoon season, as ferry services may be affected.</p>
            </div>
        </div>
    </section>


    <!-- Map Section -->
    <section class="map">
        <h2>Map of Terengganu</h2>
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2035266.780768665!2d100.53208729712293!3d4.917836495899598!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31b6dd7557fbd357%3A0x6a8fe5afedf2a3fe!2sTerengganu!5e0!3m2!1sen!2smy!4v1727842642726!5m2!1sen!2smy" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
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