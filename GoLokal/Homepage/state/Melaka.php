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
    <title>Explore Melaka - GoLokal</title>
    <link rel="stylesheet" href="assets/css/Melaka.css">
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
    <section class="melaka-intro">
        <h1>Discover Melaka</h1>
        <img src="assets/image/Melaka/Flag Melaka.png" alt="Melaka Flag">
        <p>Melaka is a historic state rich in colonial architecture, museums, and cultural sites. As a UNESCO World Heritage Site, it offers a unique blend of history, from Portuguese forts to Dutch buildings, making it a must-visit for history enthusiasts.</p>
    </section>

    <!-- Top Attractions Section -->
    <section class="attractions">
        <h2>Top Attractions in Melaka</h2>
        <div class="attraction-list">
            <div class="attraction-item">
                <img src="assets/image/Melaka/A'Famosa Fort.jpeg" alt="A'Famosa Fort">
                <h3>A'Famosa Fort</h3>
                <p>One of the oldest surviving European architectural remains in Southeast Asia, A'Famosa Fort is a historical landmark from the Portuguese era of Melaka.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Melaka/Stadthuys.jpg" alt="Stadthuys">
                <h3>Stadthuys</h3>
                <p>Built by the Dutch in 1650, Stadthuys is a distinctive red building that now houses a history museum, showcasing Melaka’s rich colonial past.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Melaka/Flora de la Mar Maritime Museum.jpg" alt="Flora de la Mar Maritime Museum">
                <h3>Flora de la Mar Maritime Museum</h3>
                <p>Housed in a replica of the Portuguese ship Flora de la Mar, this maritime museum showcases Melaka’s rich maritime history and role as a major trading port in Southeast Asia.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Melaka/St. Paul's Hill.JPG" alt="St. Paul's Hill">
                <h3>St. Paul's Hill</h3>
                <p>Climb St. Paul's Hill to explore the ruins of St. Paul's Church and enjoy panoramic views of Melaka’s historical cityscape.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Melaka/Jonker Street.jpg" alt="Jonker Street">
                <h3>Jonker Street</h3>
                <p>Famous for its bustling night market, Jonker Street is the heart of Melaka’s Chinatown, offering local delicacies, souvenirs, and cultural performances.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Melaka/Melaka River Cruise.jpeg" alt="Melaka River Cruise">
                <h3>Melaka River Cruise</h3>
                <p>Take a scenic cruise along the Melaka River and enjoy a unique perspective of the historical city’s architecture and landmarks.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Melaka/Baba & Nyonya Heritage Museum.jpeg" alt="Baba & Nyonya Heritage Museum">
                <h3>Baba & Nyonya Heritage Museum</h3>
                <p>Learn about the unique culture of the Peranakan Chinese community in Melaka at this beautifully preserved heritage museum.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Melaka/Taming Sari Tower.jpeg" alt="Taming Sari Tower">
                <h3>Taming Sari Tower</h3>
                <p>Get a bird's-eye view of Melaka from the Taming Sari Tower, a revolving gyro tower that provides panoramic views of the city and coastline.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Melaka/Kampung Morten.png" alt="Kampung Morten">
                <h3>Kampung Morten</h3>
                <p>Explore Kampung Morten, a traditional Malay village in the heart of Melaka, known for its well-preserved wooden houses and cultural charm.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Melaka/Melaka Sultanate Palace.jpg" alt="Melaka Sultanate Palace">
                <h3>Melaka Sultanate Palace</h3>
                <p>A wooden replica of the 15th-century palace of Sultan Mansur Shah, this museum showcases the history and culture of the Melaka Sultanate.</p>
            </div>
        </div>
    </section>


    <!-- Cultural Heritage Section -->
    <section class="culture">
        <h2>Cultural Heritage of Melaka</h2>
        <div class="attraction-list">
            <div class="attraction-item">
                <img src="assets/image/Melaka/A'Famosa Fort.jpeg" alt="A'Famosa Fort">
                <h3>A'Famosa Fort</h3>
                <p>A historical fort built by the Portuguese in 1511, A'Famosa is one of the oldest European architectural remains in Southeast Asia.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Melaka/St. Paul's Hill.JPG" alt="St. Paul's Church">
                <h3>St. Paul's Church</h3>
                <p>Located on St. Paul's Hill, this 16th-century church was built by the Portuguese and offers panoramic views of Melaka.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Melaka/Cheng Hoon Teng Temple.jpg" alt="Cheng Hoon Teng Temple">
                <h3>Cheng Hoon Teng Temple</h3>
                <p>Malaysia's oldest functioning Chinese temple, Cheng Hoon Teng is dedicated to the goddess of mercy and reflects Melaka's multicultural heritage.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Melaka/Kampung Morten.png" alt="Kampung Morten">
                <h3>Kampung Morten</h3>
                <p>Explore this traditional Malay village in the heart of Melaka, known for its well-preserved wooden houses and rich cultural heritage.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Melaka/Baba & Nyonya Heritage Museum.jpeg" alt="Baba & Nyonya Heritage Museum">
                <h3>Baba & Nyonya Heritage Museum</h3>
                <p>Discover the history of the Peranakan Chinese community through the beautifully preserved antiques, clothing, and architecture of this museum.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Melaka/Portuguese Settlement.jpeg" alt="Portuguese Settlement">
                <h3>Portuguese Settlement</h3>
                <p>This coastal community preserves the heritage of Melaka’s Portuguese descendants. Visit during the San Pedro Festival to experience vibrant cultural celebrations.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Melaka/Melaka Sultanate Palace.jpg" alt="Melaka Sultanate Palace">
                <h3>Melaka Sultanate Palace</h3>
                <p>A replica of the 15th-century palace of Sultan Mansur Shah, this museum displays the rich history and culture of the Melaka Sultanate.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Melaka/Jonker Street.jpg" alt="Jonker Street">
                <h3>Jonker Street</h3>
                <p>Known for its bustling night market, Jonker Street is the heart of Melaka’s Chinatown and a showcase of its multicultural heritage.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Melaka/Chitty Village.jpg" alt="Chitty Village">
                <h3>Chitty Village</h3>
                <p>The Chitty community in Melaka is a unique blend of Indian and Malay culture. Visit Chitty Village to explore their traditional homes and cultural practices.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Melaka/Hang Li Poh's Well.jpeg" alt="Hang Li Poh's Well">
                <h3>Hang Li Poh's Well</h3>
                <p>Built in the 15th century for Princess Hang Li Poh, this well is one of the oldest in Malaysia and is believed to have never dried up, symbolizing Melaka’s deep history.</p>
            </div>
        </div>
    </section>


    <!-- Adventure & Nature Section -->
    <section class="adventure">
        <h2>Adventure & Nature in Melaka</h2>
        <div class="attraction-list">
            <div class="attraction-item">
                <img src="assets/image/Melaka/Ayer Keroh Lake.jpg" alt="Ayer Keroh Lake">
                <h3>Ayer Keroh Lake</h3>
                <p>Ayer Keroh Lake is a peaceful retreat perfect for boating, kayaking, or just relaxing by the water, surrounded by lush greenery.</p>
                <h4>Activities: Boating, kayaking, picnicking</h4>
                <h4>Location: Ayer Keroh, Melaka</h4>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Melaka/Taman Botani Melaka.jpg" alt="Taman Botani Melaka">
                <h3>Taman Botani Melaka</h3>
                <p>This botanical garden offers beautiful landscapes, a canopy walk, and biking trails, making it ideal for nature lovers and families.</p>
                <h4>Activities: Cycling, nature walks, bird watching</h4>
                <h4>Location: Ayer Keroh, Melaka</h4>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Melaka/Melaka River.jpeg" alt="Melaka River">
                <h3>Melaka River</h3>
                <p>Take a relaxing boat cruise along the Melaka River to experience the historical city’s waterfront, lined with colorful murals and heritage buildings.</p>
                <h4>Activities: River cruises, sightseeing</h4>
                <h4>Location: Melaka City, Melaka</h4>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Melaka/Melaka Zoo & Night Safari.jpg" alt="Melaka Zoo">
                <h3>Melaka Zoo & Night Safari</h3>
                <p>The Melaka Zoo is home to various species of animals and offers an exciting Night Safari, where visitors can explore the zoo after dark.</p>
                <h4>Activities: Wildlife observation, Night Safari</h4>
                <h4>Location: Ayer Keroh, Melaka</h4>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Melaka/Bukit Batu Putih.jpeg" alt="Bukit Batu Putih">
                <h3>Bukit Batu Putih</h3>
                <p>Bukit Batu Putih is a hidden gem for hikers, offering a short but rewarding climb with panoramic views of the coastline and surrounding forests.</p>
                <h4>Activities: Hiking, nature photography</h4>
                <h4>Location: Tanjung Tuan, Melaka</h4>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Melaka/Pantai Klebang.jpg" alt="Pantai Klebang">
                <h3>Pantai Klebang</h3>
                <p>A popular beach for picnics and kite flying, Pantai Klebang is also known for its sand dunes, making it a perfect spot for photography and beach activities.</p>
                <h4>Activities: Picnicking, kite flying, photography</h4>
                <h4>Location: Klebang, Melaka</h4>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Melaka/Taman Rimba.jpeg" alt="Taman Rimba">
                <h3>Taman Rimba</h3>
                <p>Taman Rimba is a recreational park offering forest walks, camping areas, and picnic spots, providing a serene escape into nature.</p>
                <h4>Activities: Camping, forest walks, picnicking</h4>
                <h4>Location: Ayer Keroh, Melaka</h4>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Melaka/Blue Lake.jpg" alt="Blue Lake Melaka">
                <h3>Blue Lake</h3>
                <p>Known for its clear blue waters, Blue Lake is a scenic location for those seeking tranquility, ideal for sightseeing and nature photography.</p>
                <h4>Activities: Sightseeing, nature photography</h4>
                <h4>Location: Krubong, Melaka</h4>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Melaka/Alor Gajah Forest Reserve.jpg" alt="Alor Gajah Forest Reserve">
                <h3>Alor Gajah Forest Reserve</h3>
                <p>The Alor Gajah Forest Reserve is a lush green area perfect for hiking and nature exploration, offering diverse flora and fauna for enthusiasts.</p>
                <h4>Activities: Hiking, wildlife observation, bird watching</h4>
                <h4>Location: Alor Gajah, Melaka</h4>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Melaka/Tanjung Tuan.jpg" alt="Tanjung Tuan">
                <h3>Tanjung Tuan</h3>
                <p>Located along the coast, Tanjung Tuan is a forest reserve known for its lighthouse and bird-watching opportunities, especially during the migratory season.</p>
                <h4>Activities: Bird watching, hiking, lighthouse visits</h4>
                <h4>Location: Tanjung Tuan, Melaka</h4>
            </div>
        </div>
    </section>


    <!-- Food & Cuisine Section -->
    <section class="cuisine">
        <h2>Food & Cuisine in Melaka</h2>
        <div class="attraction-list">
            <div class="attraction-item">
                <img src="assets/image/Melaka/Asam Pedas Melaka.jpg" alt="Asam Pedas Melaka">
                <h3>Asam Pedas Melaka</h3>
                <p>A tangy and spicy fish stew made with tamarind, chilies, and local herbs. This version of Asam Pedas is one of Melaka's signature dishes and is typically served with white rice.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Melaka/Chicken Rice Balls.jpg" alt="Chicken Rice Balls">
                <h3>Chicken Rice Balls</h3>
                <p>A famous Melaka dish, this variation of Hainanese chicken rice is served with rice formed into small balls, alongside tender poached chicken and chili sauce.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Melaka/Nyonya Kuih.jpg" alt="Nyonya Laksa">
                <h3>Nyonya Laksa</h3>
                <p>A popular Peranakan dish, Nyonya Laksa is a rich and creamy noodle soup made with coconut milk, shrimp, tofu, and spicy sambal.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Melaka/Cendol.jpg" alt="Cendol">
                <h3>Cendol</h3>
                <p>This refreshing dessert features shaved ice topped with green rice flour jelly, coconut milk, and palm sugar syrup, making it a favorite treat in Melaka’s hot weather.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Melaka/Onde-Onde.webp" alt="Onde-Onde">
                <h3>Onde-Onde</h3>
                <p>Onde-Onde are bite-sized glutinous rice balls filled with palm sugar and coated in grated coconut, offering a sweet surprise in every bite.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Melaka/Nasi Lemak.jpeg" alt="Nasi Lemak">
                <h3>Nasi Lemak</h3>
                <p>Considered a national dish, Nasi Lemak in Melaka is served with fragrant rice cooked in coconut milk, sambal, boiled eggs, fried anchovies, and peanuts.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Melaka/Ayam Pong Teh.jpeg" alt="Ayam Pong Teh">
                <h3>Ayam Pong Teh</h3>
                <p>A traditional Nyonya dish, Ayam Pong Teh is a savory chicken stew slow-cooked with potatoes, fermented soybean paste, and garlic, giving it a unique flavor.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Melaka/Satay Celup.jpeg" alt="Satay Celup">
                <h3>Satay Celup</h3>
                <p>Satay Celup is a local favorite where various skewered meats, seafood, and vegetables are dipped into a communal pot of rich, boiling peanut sauce.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Melaka/Nyonya Kuih.jpg" alt="Nyonya Kuih">
                <h3>Nyonya Kuih</h3>
                <p>Nyonya Kuih are colorful bite-sized desserts made from rice flour, coconut milk, and palm sugar, representing the Peranakan influence in Melaka’s food culture.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Melaka/Popiah.jpg" alt="Popiah">
                <h3>Popiah</h3>
                <p>Popiah is a fresh spring roll filled with jicama, tofu, and vegetables, wrapped in a thin crepe-like skin, and typically served with a sweet and spicy sauce.</p>
            </div>
        </div>
    </section>


    <!-- Travel Tips Section -->
    <section class="travel-tips">
        <h2>Travel Tips for Melaka</h2>
        <div class="attraction-list">
            <div class="attraction-item">
                <h3>Best Time to Visit</h3>
                <p>The best time to visit Melaka is between March and November when the weather is relatively dry. Avoid the monsoon season from November to February as heavy rains might disrupt outdoor activities.</p>
            </div>

            <div class="attraction-item">
                <h3>How to Get There</h3>
                <p>
                    <strong>Flights:</strong> The nearest airport is Kuala Lumpur International Airport (KLIA), about 1.5 hours from Melaka by road.<br>
                    <strong>By Road:</strong> Melaka is well-connected to Kuala Lumpur (about 2 hours) and Singapore (3-4 hours) by bus or car.<br>
                    <strong>Trains:</strong> There are no direct trains to Melaka, but the nearest train station is in Tampin, about 30 minutes away by car.
                </p>
            </div>

            <div class="attraction-item">
                <h3>Currency</h3>
                <p>The official currency is the Malaysian Ringgit (MYR). Credit cards are widely accepted in shopping malls and restaurants, but having some cash on hand is essential for street markets and small shops.</p>
            </div>

            <div class="attraction-item">
                <h3>Language</h3>
                <p>Bahasa Malaysia is the official language, but English is commonly spoken in tourist areas and businesses, making communication easy for international visitors.</p>
            </div>

            <div class="attraction-item">
                <h3>Local Transportation</h3>
                <p>
                    <strong>Taxis & E-Hailing Services:</strong> Taxis are available, but Grab (e-hailing) is a more reliable and budget-friendly option.<br>
                    <strong>Public Buses:</strong> Melaka has a local bus system, but it may not be very convenient for tourists. Walking or using Grab is often better.<br>
                    <strong>Bicycle Rentals:</strong> In the historic district, you can rent bicycles to explore the city at a relaxed pace.
                </p>
            </div>

            <div class="attraction-item">
                <h3>Safety</h3>
                <p>Melaka is generally safe for tourists, but it's wise to be cautious of pickpocketing in crowded areas like Jonker Street. Keep your belongings secure, especially in markets and during festivals.</p>
                <p><strong>Travel Insurance:</strong> Consider travel insurance that covers medical expenses and trip cancellations for added security.</p>
            </div>

            <div class="attraction-item">
                <h3>Shopping & Bargaining</h3>
                <p>Jonker Street is famous for its night market, and bargaining is acceptable, but be polite and reasonable. In larger stores or malls, prices are usually fixed.</p>
            </div>

            <div class="attraction-item">
                <h3>Food Safety</h3>
                <p>Melaka's street food is famous and generally safe to eat. Stick to busy food stalls for freshness, and try local favorites like Chicken Rice Balls and Cendol.</p>
                <p><strong>Tap Water:</strong> It is recommended to drink bottled or boiled water as tap water is not always safe for consumption.</p>
            </div>

            <div class="attraction-item">
                <h3>Respecting Local Customs</h3>
                <p>
                    <strong>Modest Dress:</strong> Dress modestly when visiting religious sites such as mosques or temples. Cover your shoulders and knees, especially in these areas.<br>
                    <strong>Religious Etiquette:</strong> Remove your shoes before entering mosques and temples, and ensure to dress appropriately. Women may be required to wear headscarves at some mosques.<br>
                    <strong>Greetings:</strong> A polite smile or nod is common when greeting locals. When shaking hands with Muslims, use both hands without a firm grip.
                </p>
            </div>

            <div class="attraction-item">
                <h3>Tipping</h3>
                <p>Tipping is not common in Melaka, but rounding up the bill or leaving small change at restaurants and for services like hotels or taxis is appreciated.</p>
            </div>

            <div class="attraction-item">
                <h3>Local Festivals</h3>
                <p>Melaka celebrates major festivals like the Chinese New Year, Hari Raya Aidilfitri, and the Melaka River Festival. These celebrations offer unique opportunities to experience local traditions, food, and performances.</p>
            </div>
        </div>
    </section>


    <!-- Map Section -->
    <section class="map">
        <h2>Map of Melaka</h2>
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d127576.85532647035!2d102.16910161227808!3d2.237376638469744!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31d1ee278e8c65dd%3A0x32a7281769e016a!2sMalacca!5e0!3m2!1sen!2smy!4v1727602314395!5m2!1sen!2smy" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
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