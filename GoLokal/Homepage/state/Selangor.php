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
    <title>Explore Selangor - GoLokal</title>
    <link rel="stylesheet" href="assets/css/selangor.css">
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
    <section class="selangor-intro">
        <h1>Discover Selangor</h1>
        <img src="assets/image/Selangor/Flag Selangor.png" alt="Selangor Flag">
        <p>Selangor, Malaysia’s most developed state, surrounds the capital Kuala Lumpur and offers a mix of modern attractions and nature. From shopping malls and theme parks to nature reserves and cultural sites, Selangor has something for everyone.</p>
    </section>

    <!-- Top Attractions Section -->
    <section class="attractions">
        <h2>Top Attractions in Selangor</h2>
        <div class="attraction-list">
            <div class="attraction-item">
                <img src="assets/image/Selangor/Selangor.jpeg" alt="Batu Caves">
                <h3>Batu Caves</h3>
                <p>One of Malaysia's most iconic landmarks, Batu Caves is a limestone hill with a series of caves and cave temples, and home to a massive statue of Lord Murugan.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Selangor/I-City.jpg" alt="I-City Shah Alam">
                <h3>I-City Shah Alam</h3>
                <p>I-City is known for its stunning City of Digital Lights, a theme park with colorful LED displays, snow parks, and an array of fun rides.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Selangor/Sunway Lagoon.jpg" alt="Sunway Lagoon">
                <h3>Sunway Lagoon</h3>
                <p>Sunway Lagoon is a popular amusement park offering a wide range of water slides, amusement rides, and wildlife attractions for visitors of all ages.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Selangor/Paya Indah Wetlands.jpg" alt="Paya Indah Wetlands">
                <h3>Paya Indah Wetlands</h3>
                <p>A peaceful nature reserve where you can enjoy bird watching, hiking, and exploring diverse wetland ecosystems.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Selangor/Sultan Salahuddin Abdul Aziz Shah Mosque.jpg" alt="Sultan Salahuddin Abdul Aziz Shah Mosque">
                <h3>Sultan Salahuddin Abdul Aziz Shah Mosque</h3>
                <p>The largest mosque in Malaysia, known as the Blue Mosque, it features stunning Islamic architecture with a massive blue dome and beautiful interiors.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Selangor/Sepang International Circuit.jpg" alt="Sepang International Circuit">
                <h3>Sepang International Circuit</h3>
                <p>Home to the Malaysian Formula 1 Grand Prix, this circuit is a must-visit for motorsports fans, offering thrilling races and events throughout the year.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Selangor/Forest Research Institute Malaysia (FRIM).jpg" alt="Forest Research Institute Malaysia">
                <h3>Forest Research Institute Malaysia (FRIM)</h3>
                <p>Explore the lush rainforest and canopy walks at FRIM, a popular spot for nature lovers and those interested in Malaysia's flora and fauna.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Selangor/Kuala Lumpur International Airport (KLIA).jpg" alt="Kuala Lumpur International Airport (KLIA)">
                <h3>Kuala Lumpur International Airport (KLIA)</h3>
                <p>One of the busiest airports in Southeast Asia, KLIA offers world-class services, shopping, and dining while serving as a gateway to Malaysia.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Selangor/Bukit Melawati.png" alt="Bukit Melawati">
                <h3>Bukit Melawati</h3>
                <p>A historical hill in Kuala Selangor, Bukit Melawati offers a panoramic view, lighthouse, and the chance to see playful silvered leaf monkeys.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Selangor/Pulau Ketam.jpg" alt="Pulau Ketam">
                <h3>Pulau Ketam</h3>
                <p>An idyllic fishing village built on stilts, Pulau Ketam offers a unique glimpse into the traditional life of the local Chinese fishing community.</p>
            </div>
        </div>
    </section>


    <!-- Cultural Heritage Section -->
    <section class="culture">
        <h2>Cultural Heritage of Selangor</h2>
        <div class="attraction-list">
            <div class="attraction-item">
                <img src="assets/image/Selangor/Sultan Salahuddin Abdul Aziz Shah Mosque.jpg" alt="Sultan Salahuddin Abdul Aziz Shah Mosque">
                <h3>Sultan Salahuddin Abdul Aziz Shah Mosque</h3>
                <p>Known as the "Blue Mosque," it is one of the largest mosques in Southeast Asia and a prominent landmark in Selangor.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Selangor/Istana Alam Shah.jpg" alt="Istana Alam Shah">
                <h3>Istana Alam Shah</h3>
                <p>This royal palace in Klang serves as the official residence of the Sultan of Selangor and is a symbol of Selangor's royal heritage.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Selangor/Selangor.jpeg" alt="Batu Caves">
                <h3>Batu Caves</h3>
                <p>A limestone hill with a series of caves and cave temples, Batu Caves is a famous Hindu pilgrimage site and an important cultural landmark.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Selangor/Kota Darul Ehsan Arch.jpg" alt="Kota Darul Ehsan Arch">
                <h3>Kota Darul Ehsan Arch</h3>
                <p>This grand arch marks the boundary between Selangor and Kuala Lumpur, symbolizing Selangor's history and pride.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Selangor/Sultan Abdul Samad Mausoleum.jpg" alt="Sultan Abdul Samad Mausoleum">
                <h3>Sultan Abdul Samad Mausoleum</h3>
                <p>The resting place of Sultan Abdul Samad, the fourth Sultan of Selangor, this mausoleum is of historical and cultural importance.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Selangor/Royal Klang Heritage Walk.jpg" alt="Royal Klang Heritage Walk">
                <h3>Royal Klang Heritage Walk</h3>
                <p>A guided walking tour that explores the historical landmarks of Klang, including the Raja Mahadi Fort and the Sultan Abdul Aziz Royal Gallery.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Selangor/Sri Shakti Devasthanam Temple.jpg" alt="Sri Shakti Devasthanam Temple">
                <h3>Sri Shakti Devasthanam Temple</h3>
                <p>Sri Shakti Devasthanam Temple is a beautifully designed Hindu temple in Bukit Rotan, Selangor, known for its intricate architecture and vibrant religious ceremonies.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Selangor/Mah Meri Cultural Village.jpg" alt="Mah Meri Cultural Village">
                <h3>Mah Meri Cultural Village</h3>
                <p>The Mah Meri tribe is one of the indigenous peoples of Selangor, and this village preserves and celebrates their unique culture and traditions.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Selangor/Sepang International Circuit.jpg" alt="Sepang International Circuit">
                <h3>Sepang International Circuit</h3>
                <p>Famous for hosting the Malaysian Grand Prix, this circuit is a significant cultural icon for motorsports in Selangor.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Selangor/Tugu Keris Klang.jpg" alt="Tugu Keris Klang">
                <h3>Tugu Keris Klang</h3>
                <p>This monument, shaped like a traditional Malay keris (dagger), symbolizes the strength and courage of the Sultanate of Selangor.</p>
            </div>

        </div>
    </section>

    <!-- Adventure & Nature Section -->
    <section class="adventure">
        <h2>Adventure & Nature in Selangor</h2>
        <div class="attraction-list">
            <div class="attraction-item">
                <img src="assets/image/Selangor/Bukit Broga.jpg" alt="Bukit Broga">
                <h3>Bukit Broga</h3>
                <p>Bukit Broga offers a popular hiking experience with panoramic views, especially beautiful during sunrise.</p>
                <h4>Activities: Hiking, nature photography, sunrise watching</h4>
                <h4>Location: Semenyih, Selangor</h4>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Selangor/Kuala Selangor Nature Park.jpg" alt="Kuala Selangor Nature Park">
                <h3>Kuala Selangor Nature Park</h3>
                <p>Explore this nature park, home to mangroves, wetlands, and various bird species.</p>
                <h4>Activities: Bird watching, hiking, nature photography</h4>
                <h4>Location: Kuala Selangor, Selangor</h4>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Selangor/Kanching Rainforest Waterfall.jpg" alt="Kanching Rainforest Waterfall">
                <h3>Kanching Rainforest Waterfall</h3>
                <p>Kanching Rainforest is a hidden gem featuring a seven-tier waterfall amidst lush greenery.</p>
                <h4>Activities: Hiking, swimming, picnicking</h4>
                <h4>Location: Rawang, Selangor</h4>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Selangor/Klang Gates Quartz Ridge.jpg" alt="Klang Gates Quartz Ridge">
                <h3>Klang Gates Quartz Ridge</h3>
                <p>The world's longest quartz ridge offers stunning views and challenging hikes.</p>
                <h4>Activities: Hiking, sightseeing, photography</h4>
                <h4>Location: Gombak, Selangor</h4>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Selangor/Chiling Waterfalls.jpg" alt="Chiling Waterfalls">
                <h3>Chiling Waterfalls</h3>
                <p>Famous for its scenic waterfalls, this spot is ideal for adventurous hiking and swimming.</p>
                <h4>Activities: Hiking, swimming, picnicking</h4>
                <h4>Location: Kuala Kubu Bharu, Selangor</h4>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Selangor/Taman Negara (National Park).jpg" alt="Taman Negara (National Park)">
                <h3>Taman Negara (National Park)</h3>
                <p>Experience Malaysia’s oldest rainforest, offering jungle trekking and canopy walks.</p>
                <h4>Activities: Jungle trekking, wildlife watching, canopy walks</h4>
                <h4>Location: Taman Negara, Selangor</h4>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Selangor/Skytrex Adventure.avif" alt="Skytrex Adventure">
                <h3>Skytrex Adventure</h3>
                <p>An aerial adventure park where you can challenge yourself with tree-to-tree obstacles.</p>
                <h4>Activities: Zip lining, obstacle courses, adventure park</h4>
                <h4>Location: Shah Alam, Selangor</h4>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Selangor/Selangor River Rafting.jpg" alt="Selangor River Rafting">
                <h3>Selangor River Rafting</h3>
                <p>Experience the thrill of white-water rafting on the Selangor River, an adventure for adrenaline seekers.</p>
                <h4>Activities: White-water rafting, kayaking, river exploration</h4>
                <h4>Location: Kuala Kubu Bharu, Selangor</h4>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Selangor/Sasaran Sky Mirror.jpg" alt="Sasaran Sky Mirror">
                <h3>Sasaran Sky Mirror</h3>
                <p>During low tide, the sand flats of Sasaran reflect the sky, creating a magical mirror effect.</p>
                <h4>Activities: Photography, sightseeing</h4>
                <h4>Location: Kuala Selangor, Selangor</h4>
            </div>


            <div class="attraction-item">
                <img src="assets/image/Selangor/Jugra Hill (Bukit Jugra).jpg" alt="Jugra Hill">
                <h3>Jugra Hill (Bukit Jugra)</h3>
                <p>An underrated hiking spot, Jugra Hill offers both panoramic views and the thrill of paragliding.</p>
                <h4>Activities: Hiking, paragliding, sightseeing</h4>
                <h4>Location: Banting, Selangor</h4>
            </div>
        </div>
    </section>


    <!-- Food & Cuisine Section -->
    <section class="cuisine">
        <h2>Food & Cuisine in Selangor</h2>
        <div class="attraction-list">
            <div class="attraction-item">
                <img src="assets/image/Selangor/Satay Kajang.jpg" alt="Satay Kajang">
                <h3>Satay Kajang</h3>
                <p>Famous for its tender, marinated grilled meat skewers served with a flavorful peanut sauce, Satay Kajang is one of Selangor's most iconic dishes.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Selangor/Nasi Lemak.jpg" alt="Nasi Lemak">
                <h3>Nasi Lemak</h3>
                <p>A national favorite, Nasi Lemak is fragrant rice cooked in coconut milk, served with sambal, fried anchovies, peanuts, and boiled eggs.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Selangor/Rojak Klang.jpg" alt="Rojak Klang">
                <h3>Rojak Klang</h3>
                <p>A local fruit and vegetable salad mixed with a thick, sweet, and savory prawn-based sauce, topped with crushed peanuts for extra flavor.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Selangor/Sup Ayam.jpg" alt="Sup Ayam">
                <h3>Sup Ayam</h3>
                <p>A flavorful and aromatic chicken soup made with a blend of spices, served with rice or noodles. Sup Ayam is a comforting and hearty dish enjoyed across Selangor, perfect for those looking for a non-pork option.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Selangor/Nasi Ambeng.jpg" alt="Nasi Ambeng">
                <h3>Nasi Ambeng</h3>
                <p>A traditional Javanese-Malay rice dish served with chicken, fried noodles, beef rendang, and sambal, popular for group sharing.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Selangor/Sambal Lala.jpg" alt="Sambal Lala">
                <h3>Sambal Lala</h3>
                <p>A delicious and spicy dish featuring clams cooked in sambal sauce, a favorite seafood delicacy in Selangor.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Selangor/Kuih Bahulu.jpeg" alt="Kuih Bahulu">
                <h3>Kuih Bahulu</h3>
                <p>Fluffy, small sponge cakes that are traditionally baked and served during festive occasions. They’re a beloved snack in Selangor.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Selangor/Pisang Goreng.jpg" alt="Pisang Goreng">
                <h3>Pisang Goreng</h3>
                <p>Crispy banana fritters, a popular street snack in Selangor, especially enjoyed during tea time.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Selangor/Sambal Udang.jpeg" alt="Sambal Udang">
                <h3>Sambal Udang</h3>
                <p>Sambal Udang is a flavorful dish made with fresh prawns cooked in a spicy, tangy sambal sauce made from chilies, garlic, and tamarind. This spicy seafood delight is a favorite among Selangor locals.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Selangor/Pulut Panggang.jpg" alt="Pulut Panggang">
                <h3>Pulut Panggang</h3>
                <p>Sticky rice wrapped in banana leaves and grilled, often filled with a sweet or savory coconut filling, a beloved traditional snack in Selangor.</p>
            </div>
        </div>
    </section>



    <!-- Travel Tips Section -->
    <section class="travel-tips">
        <h2>Travel Tips for Selangor</h2>
        <div class="attraction-list">
            <div class="attraction-item">
                <h3>Best Time to Visit</h3>
                <p>The best time to visit Selangor is between March and October, when the weather is warm and dry. From November to February, the region may experience occasional heavy rains during the monsoon season, but it's still a great time for indoor activities.</p>
            </div>

            <div class="attraction-item">
                <h3>How to Get There</h3>
                <p>
                    <strong>Flights:</strong> Selangor is home to Kuala Lumpur International Airport (KLIA), Malaysia’s main airport, located in Sepang. It connects to major cities worldwide.<br>
                    <strong>By Road:</strong> Selangor is well-connected by highways from Kuala Lumpur and other major Malaysian cities. Buses, taxis, and car rentals are also widely available.<br>
                    <strong>Trains:</strong> The KTM Komuter and LRT services provide convenient connections from Kuala Lumpur to various locations within Selangor.
                </p>
            </div>

            <div class="attraction-item">
                <h3>Currency</h3>
                <p>The official currency is the Malaysian Ringgit (MYR). Credit cards are accepted in most hotels and large stores, but it's advisable to carry some cash for purchases at local markets and small businesses.</p>
            </div>

            <div class="attraction-item">
                <h3>Language</h3>
                <p>While Bahasa Malaysia is the official language, English is widely spoken, especially in tourist areas. You won't face much difficulty communicating in English when traveling in Selangor.</p>
            </div>

            <div class="attraction-item">
                <h3>Local Transportation</h3>
                <p>
                    <strong>Taxis & E-Hailing Services:</strong> Taxis and e-hailing services such as Grab are widely available in Selangor. Always ensure the taxi meter is running or use Grab for a hassle-free experience.<br>
                    <strong>Public Buses:</strong> Public buses are available but can be slow. Opt for e-hailing or renting a car for more flexibility.<br>
                    <strong>Driving:</strong> Renting a car is a good option for exploring more remote or suburban areas of Selangor. The highways are well-maintained and easy to navigate.
                </p>
            </div>

            <div class="attraction-item">
                <h3>Safety</h3>
                <p>Selangor is generally a safe destination for travelers, but it's wise to stay cautious in crowded places. Keep your belongings secure, especially in busy markets or public transport areas.</p>
                <p><strong>Travel Insurance:</strong> Consider having travel insurance that covers medical emergencies and travel-related disruptions.</p>
            </div>

            <div class="attraction-item">
                <h3>Shopping & Bargaining</h3>
                <p>Selangor offers a variety of shopping experiences, from high-end malls to local markets. Bargaining is acceptable at street markets, but it's always done politely and with a smile.</p>
            </div>

            <div class="attraction-item">
                <h3>Food Safety</h3>
                <p>Selangor is famous for its street food. While most vendors follow good hygiene practices, it's best to choose stalls that are busy with locals. Food turnover ensures freshness. Avoid drinking tap water and opt for bottled or boiled water.</p>
            </div>

            <div class="attraction-item">
                <h3>Respecting Local Customs</h3>
                <p>
                    <strong>Modest Dress:</strong> It's recommended to dress modestly, especially when visiting religious sites such as mosques. Cover your shoulders and knees.<br>
                    <strong>Mosques:</strong> Visitors are welcome, but remember to remove your shoes before entering. Women may be required to wear a headscarf.<br>
                    <strong>Greetings:</strong> A friendly nod or smile is common, and when shaking hands with Muslims, it's customary to use both hands gently.
                </p>
            </div>

            <div class="attraction-item">
                <h3>Tipping</h3>
                <p>Tipping is not expected in Selangor, but it's appreciated in tourist areas and restaurants. Rounding up the bill or leaving small change is a courteous gesture.</p>
            </div>

            <div class="attraction-item">
                <h3>Local Festivals</h3>
                <p>Selangor celebrates major festivals such as Hari Raya Aidilfitri, Deepavali, and Chinese New Year. Visitors during these times will experience local traditions, festivities, and an array of special holiday foods.</p>
            </div>

            <div class="attraction-item">
                <h3>Nearby Attractions</h3>
                <p>Selangor is close to many popular destinations like Kuala Lumpur, Batu Caves, and the Genting Highlands. Day trips to these locations are easy to arrange, providing a rich mix of nature and city life.</p>
            </div>
        </div>
    </section>


    <!-- Map Section -->
    <section class="map">
        <h2>Map of Selangor</h2>
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1019768.8845667453!2d100.72147578680764!3d3.2320094425092063!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31cc4252cdeb045f%3A0x26e1bee1215dfbb9!2sSelangor!5e0!3m2!1sen!2smy!4v1727841236233!5m2!1sen!2smy" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
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