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
    <title>Explore Perak - GoLokal</title>
    <link rel="stylesheet" href="assets/css/Perak.css">
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
    <section class="perak-intro">
        <h1>Discover Perak</h1>
        <img src="assets/image/Perak/Flag Perak.png" alt="Perak Flag">
        <p>Perak, once a center of Malaysia's tin mining industry, is now known for its natural beauty and historical significance. Visitors can explore limestone caves, visit charming old towns, or relax by the scenic lakes of this beautiful state.</p>
    </section>

    <!-- Top Attractions Section -->
    <section class="attractions">
        <h2>Top Attractions in Perak</h2>
        <div class="attraction-list">
            <div class="attraction-item">
                <img src="assets/image/Perak/Kellie's Castle.jpg" alt="Kellie's Castle">
                <h3>Kellie's Castle</h3>
                <p>Explore the unfinished mansion built by Scottish planter William Kellie Smith. It is known for its mysterious architecture and ghostly legends.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Perak/Ipoh Old Town.png" alt="Ipoh Old Town">
                <h3>Ipoh Old Town</h3>
                <p>Walk through Ipoh Old Town, famous for its colonial buildings, street art, and vibrant food scene, especially for its white coffee and local dishes.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Perak/Lost World of Tambun.jpeg" alt="Lost World of Tambun">
                <h3>Lost World of Tambun</h3>
                <p>A family-friendly theme park with hot springs, water rides, and natural attractions, nestled in a scenic limestone valley near Ipoh.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Perak/Pangkor Island.webp" alt="Pangkor Island">
                <h3>Pangkor Island</h3>
                <p>A beautiful island getaway known for its beaches, clear waters, and historical landmarks like the Dutch Fort and Fu Lin Kong Temple.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Perak/Taiping Lake Gardens.jpeg" alt="Taiping Lake Gardens">
                <h3>Taiping Lake Gardens</h3>
                <p>One of the oldest public gardens in Malaysia, this peaceful park features lush greenery, scenic lakes, and old rain trees perfect for a relaxing stroll.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Perak/Gua Tempurung.jpg" alt="Gua Tempurung">
                <h3>Gua Tempurung</h3>
                <p>One of the longest limestone caves in Peninsular Malaysia, Gua Tempurung offers exciting cave exploration with stunning stalactites, stalagmites, and underground rivers.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Perak/Lumut.jpg" alt="Lumut">
                <h3>Lumut</h3>
                <p>Known as the gateway to Pangkor Island, Lumut is a charming seaside town with beautiful beaches and seafood restaurants along the coast.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Perak/Perak Cave Temple.jpg" alt="Perak Cave Temple">
                <h3>Perak Cave Temple</h3>
                <p>This famous cave temple is set within limestone hills and is adorned with beautiful Buddha statues, wall murals, and offers stunning panoramic views of Ipoh.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Perak/Royal Belum Rainforest.webp" alt="Royal Belum Rainforest">
                <h3>Royal Belum Rainforest</h3>
                <p>Part of the oldest rainforest in the world, the Royal Belum State Park offers jungle trekking, wildlife observation, and a chance to see the rare Rafflesia flower.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Perak/Ubudiah Mosque.jpg" alt="Ubudiah Mosque">
                <h3>Ubudiah Mosque</h3>
                <p>One of Malaysia’s most beautiful mosques, the Ubudiah Mosque in Kuala Kangsar is an architectural masterpiece with its golden dome and intricate designs.</p>
            </div>
        </div>
    </section>

    <!-- Cultural Heritage Section -->
    <section class="culture">
        <h2>Cultural Heritage of Perak</h2>
        <div class="attraction-list">
            <div class="attraction-item">
                <img src="assets/image/Perak/Perak Museum.jpg" alt="Perak Museum">
                <h3>Perak Museum</h3>
                <p>Established in 1883, the Perak Museum is Malaysia’s oldest museum, housing exhibits on ethnology, zoology, and anthropology, offering a deep dive into Perak’s cultural history.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Perak/Ipoh Old Town.png" alt="Ipoh Town Hall">
                <h3>Ipoh Town Hall</h3>
                <p>The Ipoh Town Hall is a historical colonial building that showcases British architecture. It is still in use today for important events and is a key symbol of the city’s heritage.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Perak/Taiping Zoo.jpg" alt="Taiping Zoo">
                <h3>Taiping Zoo</h3>
                <p>Situated in the beautiful Taiping Lake Gardens, Taiping Zoo is Malaysia’s oldest zoo and offers a wide variety of wildlife species in a natural, rainforest setting.</p>
            </div>


            <div class="attraction-item">
                <img src="assets/image/Perak/Birch Memorial Clock Tower.jpeg" alt="Birch Memorial Clock Tower">
                <h3>Birch Memorial Clock Tower</h3>
                <p>The Birch Memorial Clock Tower in Ipoh is a significant historical monument commemorating James W. W. Birch, the first British Resident of Perak, reflecting the colonial past.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Perak/Lenggong Archaeological Museum.jpg" alt="Lenggong Archaeological Museum">
                <h3>Lenggong Archaeological Museum</h3>
                <p>A UNESCO World Heritage Site, the Lenggong Valley is one of the most important archaeological sites in Southeast Asia, showcasing early human settlements and ancient artifacts.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Perak/Sam Poh Tong Temple.jpg" alt="Sam Poh Tong Temple">
                <h3>Sam Poh Tong Temple</h3>
                <p>This stunning cave temple in Ipoh is carved into a limestone hill, offering a peaceful setting with beautiful statues of Buddha and a serene pond filled with koi fish and turtles.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Perak/Ipoh Railway Station.jpg" alt="Ipoh Railway Station">
                <h3>Ipoh Railway Station</h3>
                <p>Often referred to as the "Taj Mahal of Ipoh," this colonial-era railway station is a grand structure that reflects Perak's history during British rule and its role as a major transport hub.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Perak/Kuala Kangsar Royal Gallery.jpg" alt="Kuala Kangsar Royal Gallery">
                <h3>Kuala Kangsar Royal Gallery</h3>
                <p>This gallery showcases the rich royal heritage of Perak’s monarchy, with exhibits displaying royal regalia, artifacts, and historical records of the state’s royal family.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Perak/Leaning Tower of Teluk Intan.jpg" alt="Leaning Tower of Teluk Intan">
                <h3>Leaning Tower of Teluk Intan</h3>
                <p>The Leaning Tower of Teluk Intan is one of Malaysia's most unique architectural landmarks, known for its slanted structure resembling the famous Leaning Tower of Pisa.</p>
            </div>


            <div class="attraction-item">
                <img src="assets/image/Perak/Concubine Lane.webp" alt="Concubine Lane">
                <h3>Concubine Lane</h3>
                <p>Steeped in history, Concubine Lane in Ipoh was once home to rich tin miners and their mistresses. Today, it’s a bustling street full of shops, cafes, and cultural attractions.</p>
            </div>
        </div>
    </section>


    <!-- Adventure & Nature Section -->
    <section class="adventure">
        <h2>Adventure & Nature in Perak</h2>
        <div class="attraction-list">
            <div class="attraction-item">
                <img src="assets/image/Perak/Gua Tempurung.jpg" alt="Gua Tempurung">
                <h3>Gua Tempurung</h3>
                <p>Explore one of Peninsular Malaysia's largest limestone caves, featuring stalactites, stalagmites, and underground rivers for a thrilling adventure.</p>
                <h4>Activities: Caving, exploring underground rivers, sightseeing</h4>
                <h4>Location: Gopeng, Perak</h4>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Perak/Royal Belum Rainforest.webp" alt="Royal Belum State Park">
                <h3>Royal Belum State Park</h3>
                <p>One of the oldest rainforests in the world, Royal Belum State Park offers wildlife sightings, boat rides, and trekking through pristine natural beauty.</p>
                <h4>Activities: Jungle trekking, wildlife spotting, boating, camping</h4>
                <h4>Location: Gerik, Perak</h4>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Perak/Kuala Sepetang Mangrove Forest.jpeg" alt="Kuala Sepetang Mangrove Forest">
                <h3>Kuala Sepetang Mangrove Forest</h3>
                <p>The largest mangrove reserve in Peninsular Malaysia, famous for its mangrove swamps, eagle sightings, and firefly boat tours.</p>
                <h4>Activities: Mangrove tours, bird watching, firefly boat tours</h4>
                <h4>Location: Kuala Sepetang, Perak</h4>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Perak/Pangkor Island.webp" alt="Pangkor Island">
                <h3>Pangkor Island</h3>
                <p>Pangkor Island offers pristine beaches, clear waters, and a mix of adventure and relaxation, perfect for water sports and beach getaways.</p>
                <h4>Activities: Snorkeling, swimming, hiking, beach relaxation</h4>
                <h4>Location: Pangkor, Perak</h4>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Perak/Bukit Larut (Maxwell Hill).webp" alt="Bukit Larut (Maxwell Hill)">
                <h3>Bukit Larut (Maxwell Hill)</h3>
                <p>At Malaysia's oldest hill station, visitors can enjoy the cool climate, beautiful gardens, and panoramic views of Taiping town below.</p>
                <h4>Activities: Hiking, bird watching, sightseeing</h4>
                <h4>Location: Taiping, Perak</h4>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Perak/Taiping Lake Gardens.jpeg" alt="Taiping Lake Gardens">
                <h3>Taiping Lake Gardens</h3>
                <p>This peaceful garden features lakes, lush greenery, and scenic views, offering visitors a tranquil escape amidst nature.</p>
                <h4>Activities: Boating, picnicking, jogging, sightseeing</h4>
                <h4>Location: Taiping, Perak</h4>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Perak/Sungai Klah Hot Springs.jpg" alt="Sungai Klah Hot Springs">
                <h3>Sungai Klah Hot Springs</h3>
                <p>Known for its natural hot springs, this serene destination is perfect for relaxing in hot spring pools and enjoying scenic surroundings.</p>
                <h4>Activities: Hot spring soaking, spa treatments, sightseeing</h4>
                <h4>Location: Sungkai, Perak</h4>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Perak/Lumut Waterfront.jpg" alt="Lumut Waterfront">
                <h3>Lumut Waterfront</h3>
                <p>A beautiful seaside destination, Lumut Waterfront is perfect for strolling, enjoying coastal views, and exploring nearby islands.</p>
                <h4>Activities: Sightseeing, beach walks, island hopping</h4>
                <h4>Location: Lumut, Perak</h4>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Perak/Bukit Kledang.jpeg" alt="Bukit Kledang">
                <h3>Bukit Kledang</h3>
                <p>A popular hiking spot for both beginners and seasoned hikers, offering breathtaking views of Ipoh and surrounding areas from the summit.</p>
                <h4>Activities: Hiking, photography, sightseeing</h4>
                <h4>Location: Menglembu, Perak</h4>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Perak/Lata Kinjang Waterfall.jpg" alt="Lata Kinjang Waterfall">
                <h3>Lata Kinjang Waterfall</h3>
                <p>One of the tallest waterfalls in Malaysia, Lata Kinjang offers breathtaking views, swimming opportunities, and a cool retreat amidst nature.</p>
                <h4>Activities: Swimming, picnicking, sightseeing</h4>
                <h4>Location: Chenderiang, Perak</h4>
            </div>
        </div>
    </section>


    <!-- Food & Cuisine Section -->
    <section class="cuisine">
        <h2>Food & Cuisine in Perak</h2>
        <div class="attraction-list">
            <div class="attraction-item">
                <img src="assets/image/Perak/Ipoh Chicken Rice.jpg" alt="Ipoh Chicken Rice">
                <h3>Ipoh Chicken Rice</h3>
                <p>One of the most famous dishes in Perak, Ipoh Chicken Rice features tender poached chicken served with fragrant rice and a flavorful soy-based sauce.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Perak/Nasi Ganja.jpg" alt="Nasi Ganja">
                <h3>Nasi Ganja</h3>
                <p>A famous dish in Ipoh, Nasi Ganja consists of fragrant rice served with fried chicken, boiled eggs, and spicy curry, giving it an addictive taste.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Perak/Ipoh White Coffee.jpg" alt="Ipoh White Coffee">
                <h3>Ipoh White Coffee</h3>
                <p>Ipoh White Coffee is world-renowned for its smooth, creamy flavor, brewed using a special roasting process with palm oil margarine.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Perak/Curry Mee.jpg" alt="Curry Mee">
                <h3>Curry Mee</h3>
                <p>Perak's Curry Mee is a popular noodle dish, served in a rich coconut-based curry broth with ingredients like tofu, shrimp, and bean sprouts.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Perak/Ipoh Dim Sum.jpg" alt="Ipoh Dim Sum">
                <h3>Ipoh Dim Sum</h3>
                <p>Ipoh is famous for its delectable dim sum offerings, featuring a wide variety of steamed and fried dumplings, buns, and pastries.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Perak/Chee Cheong Fun.jpeg" alt="Chee Cheong Fun">
                <h3>Chee Cheong Fun</h3>
                <p>This popular rice noodle roll is served with a savory sauce and toppings like sesame seeds, adding to its unique flavor and texture.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Perak/Salted Chicken.jpeg" alt="Salted Chicken">
                <h3>Salted Chicken</h3>
                <p>Perak's Salted Chicken is a must-try dish, featuring whole chicken wrapped in parchment and baked with rock salt for a tender and flavorful result.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Perak/Tau Fu Fah.jpg" alt="Tau Fu Fah">
                <h3>Tau Fu Fah</h3>
                <p>A smooth and silky tofu pudding, Tau Fu Fah is served with sweet syrup, making it a delightful dessert in Perak.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Perak/Ipoh Satay.jpeg" alt="Ipoh Satay">
                <h3>Ipoh Satay</h3>
                <p>Ipoh Satay features grilled skewers of marinated meat, served with a delicious peanut sauce, making it a favorite street food in Perak.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Perak/Kaya Puff.jpg" alt="Kaya Puff">
                <h3>Kaya Puff</h3>
                <p>Kaya Puff is a popular pastry filled with a sweet coconut jam (kaya), offering a flaky and buttery snack loved by both locals and visitors.</p>
            </div>
        </div>
    </section>


    <!-- Travel Tips Section -->
    <section class="travel-tips">
        <h2>Travel Tips for Perak</h2>
        <div class="attraction-list">
            <div class="attraction-item">
                <h3>Best Time to Visit</h3>
                <p>The best time to visit Perak is between April and September, during the dry season. The cooler climate in hill stations like Cameron Highlands also makes it an ideal escape from the heat during these months.</p>
            </div>

            <div class="attraction-item">
                <h3>How to Get There</h3>
                <p>
                    <strong>Flights:</strong> Sultan Azlan Shah Airport in Ipoh is Perak’s main airport, offering domestic flights to and from Kuala Lumpur and Singapore.<br>
                    <strong>By Road:</strong> Perak is accessible via the North-South Expressway, connecting major cities like Kuala Lumpur and Penang. Driving to Ipoh from Kuala Lumpur takes around 2 hours.<br>
                    <strong>Trains:</strong> KTM provides train services from Kuala Lumpur to Ipoh, making for a scenic and comfortable journey.
                </p>
            </div>

            <div class="attraction-item">
                <h3>Currency</h3>
                <p>The official currency is the Malaysian Ringgit (MYR). Credit cards are accepted in most establishments, but it’s advisable to carry cash when visiting smaller towns or rural areas.</p>
            </div>

            <div class="attraction-item">
                <h3>Language</h3>
                <p>The official language is Bahasa Malaysia, but English is widely understood in tourist areas. In Ipoh, you’ll also hear Cantonese and Mandarin due to its large Chinese community.</p>
            </div>

            <div class="attraction-item">
                <h3>Local Transportation</h3>
                <p>
                    <strong>Taxis & E-Hailing Services:</strong> Taxis and e-hailing services like Grab are readily available in Ipoh and other major towns.<br>
                    <strong>Buses:</strong> Local buses operate in Ipoh, but for exploring more rural or remote areas, renting a car is a convenient option.<br>
                    <strong>Trains:</strong> KTM trains are available for intercity travel within Perak, connecting towns like Taiping, Ipoh, and Kuala Kangsar.
                </p>
            </div>

            <div class="attraction-item">
                <h3>Safety</h3>
                <p>Perak is generally safe for tourists. Exercise usual precautions, especially in crowded areas like markets, where petty theft may occur. Keep valuables secure and be aware of your surroundings.</p>
                <p><strong>Travel Insurance:</strong> It is recommended to have travel insurance that covers medical emergencies and lost or stolen items.</p>
            </div>

            <div class="attraction-item">
                <h3>Shopping & Bargaining</h3>
                <p>While shopping in Ipoh’s night markets or small shops, bargaining is acceptable. However, bargaining may not be appropriate in more formal establishments like malls or chain stores.</p>
            </div>

            <div class="attraction-item">
                <h3>Food Safety</h3>
                <p>Perak is famous for its street food, especially in Ipoh. Stick to food stalls that appear busy to ensure the food is fresh. It's also best to drink bottled or boiled water.</p>
            </div>

            <div class="attraction-item">
                <h3>Respecting Local Customs</h3>
                <p>
                    <strong>Modest Dress:</strong> When visiting mosques or rural areas, dress modestly by covering your shoulders and knees.<br>
                    <strong>Religious Sites:</strong> Always remove your shoes when entering mosques or temples, and women should wear a headscarf when visiting mosques.
                </p>
            </div>

            <div class="attraction-item">
                <h3>Tipping</h3>
                <p>Tipping is not a common practice in Malaysia, but it is appreciated in tourist areas, especially in restaurants and for service staff. Rounding up the bill or leaving small change is considered a nice gesture.</p>
            </div>

            <div class="attraction-item">
                <h3>Local Festivals</h3>
                <p>Perak is home to several cultural festivals, including the Ipoh Cultural Festival, which celebrates the region’s diverse heritage. The annual Taiping Heritage Festival is another event worth attending.</p>
            </div>
        </div>
    </section>

    <!-- Map Section -->
    <section class="map">
        <h2>Map of Perak</h2>
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2035633.025636372!2d98.55422942216792!3d4.796517108928019!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3034b5fc2f44401d%3A0xa2d9d6f05cfe5ad2!2sPerak!5e0!3m2!1sen!2smy!4v1727560641896!5m2!1sen!2smy" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
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