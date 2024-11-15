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
    <title>Explore Sarawak - GoLokal</title>
    <link rel="stylesheet" href="assets/css/sarawak.css">
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
    <section class="sarawak-intro">
        <h1>Discover Sarawak</h1>
        <img src="assets/image/Sarawak/Flag Sarawak.png" alt="sarawak Flag">
        <p>Sarawak, Malaysia’s largest state, is famed for its vast rainforests, tribal heritage, and rich biodiversity. Visitors can explore the caves of Mulu, enjoy cultural festivals, and experience the unique longhouse communities of Borneo.</p>
    </section>

    <!-- Top Attractions Section -->
    <section class="attractions">
        <h2>Top Attractions in Sarawak</h2>
        <div class="attraction-list">
            <div class="attraction-item">
                <img src="assets/image/Sarawak/Kuching Waterfront.jpg" alt="Kuching Waterfront">
                <h3>Kuching Waterfront</h3>
                <p>Stroll along the scenic Kuching Waterfront, a popular spot for relaxing, shopping, and dining while enjoying the view of the Sarawak River.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Sarawak/Bako National Park.jpg" alt="Bako National Park">
                <h3>Bako National Park</h3>
                <p>Bako National Park is known for its stunning coastal cliffs, diverse wildlife, and beautiful jungle trails.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Sarawak/Gunung Mulu National Park.jpg" alt="Gunung Mulu National Park">
                <h3>Gunung Mulu National Park</h3>
                <p>A UNESCO World Heritage Site, Gunung Mulu National Park is famous for its limestone karst formations, caves, and rich biodiversity.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Sarawak/Semenggoh Nature Reserve.jpg" alt="Semenggoh Nature Reserve">
                <h3>Semenggoh Nature Reserve</h3>
                <p>Home to rehabilitated orangutans, the Semenggoh Nature Reserve offers a rare chance to see these incredible creatures in their natural habitat.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Sarawak/Sarawak Cultural Village.jpg" alt="Sarawak Cultural Village">
                <h3>Sarawak Cultural Village</h3>
                <p>Learn about Sarawak’s rich cultural heritage at this living museum, showcasing the traditional houses and lifestyles of various indigenous groups.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Sarawak/Damai Beach.jpg" alt="Damai Beach">
                <h3>Damai Beach</h3>
                <p>Relax at Damai Beach, a pristine coastal area perfect for beach lovers, water sports enthusiasts, and nature seekers.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Sarawak/Niah National Park.jpg" alt="Niah National Park">
                <h3>Niah National Park</h3>
                <p>Explore the ancient Niah Caves, home to prehistoric rock paintings and archaeological discoveries dating back thousands of years.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Sarawak/Cat Museum.jpg" alt="Cat Museum">
                <h3>Cat Museum</h3>
                <p>Located in Kuching, this quirky museum is dedicated to all things feline, paying homage to the city’s name, which means "cat" in Malay.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Sarawak/Sibu Heritage Centre.jpg" alt="Sibu Heritage Centre">
                <h3>Sibu Heritage Centre</h3>
                <p>Visit the Sibu Heritage Centre to learn about the town’s history and the cultural heritage of the local Chinese, Malay, and indigenous communities.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Sarawak/Lambir Hills National Park.jpg" alt="Lambir Hills National Park">
                <h3>Lambir Hills National Park</h3>
                <p>Hike through Lambir Hills National Park, known for its lush rainforests, waterfalls, and diverse wildlife, offering a great adventure for nature lovers.</p>
            </div>
        </div>
    </section>

    <!-- Culture & Heritage Section -->
    <h2>Cultural Heritage of Sarawak</h2>
    <div class="attraction-list">
        <div class="attraction-item">
            <img src="assets/image/Sarawak/Sarawak State Museum.jpeg" alt="Sarawak State Museum">
            <h3>Sarawak State Museum</h3>
            <p>Learn about Sarawak’s rich history and culture at the Sarawak State Museum, which showcases exhibits on indigenous tribes, colonial history, and local wildlife.</p>
        </div>

        <div class="attraction-item">
            <img src="assets/image/Sarawak/Sarawak Cultural Village.jpg" alt="Sarawak Cultural Village">
            <h3>Sarawak Cultural Village</h3>
            <p>A living museum showcasing the diverse cultures of Sarawak’s indigenous groups, with traditional houses, cultural performances, and handicrafts.</p>
        </div>

        <div class="attraction-item">
            <img src="assets/image/Sarawak/Semenggoh Nature Reserve.jpg" alt="Semenggoh Nature Reserve">
            <h3>Semenggoh Nature Reserve</h3>
            <p>Home to rehabilitated orangutans, this reserve offers visitors a chance to observe these incredible primates in their natural habitat.</p>
        </div>

        <div class="attraction-item">
            <img src="assets/image/Sarawak/Niah National Park.jpg" alt="Niah Caves">
            <h3>Niah Caves</h3>
            <p>Explore the ancient Niah Caves, home to prehistoric rock paintings and archaeological discoveries that date back thousands of years.</p>
        </div>

        <div class="attraction-item">
            <img src="assets/image/Sarawak/Sibu Heritage Centre.jpg" alt="Sibu Heritage Centre">
            <h3>Sibu Heritage Centre</h3>
            <p>Learn about the history and cultural heritage of the Chinese, Malay, and indigenous communities in Sibu.</p>
        </div>

        <div class="attraction-item">
            <img src="assets/image/Sarawak/Lambir Hills National Park.jpg" alt="Lambir Hills National Park">
            <h3>Lambir Hills National Park</h3>
            <p>Known for its rich biodiversity, this national park offers lush rainforests, waterfalls, and hiking trails for nature enthusiasts.</p>
        </div>

        <div class="attraction-item">
            <img src="assets/image/Sarawak/Gunung Mulu National Park.jpg" alt="Gunung Mulu National Park">
            <h3>Gunung Mulu National Park</h3>
            <p>A UNESCO World Heritage Site, famous for its limestone formations, caves, and diverse ecosystems, showcasing the natural beauty of Sarawak.</p>
        </div>

        <div class="attraction-item">
            <img src="assets/image/Sarawak/Bidayuh Longhouse.jpg" alt="Bidayuh Longhouse">
            <h3>Bidayuh Longhouse</h3>
            <p>Visit a traditional Bidayuh longhouse to experience the communal lifestyle and unique architecture of Sarawak’s indigenous people.</p>
        </div>

        <div class="attraction-item">
            <img src="assets/image/Sarawak/Santubong Cultural Village.jpg" alt="Santubong Cultural Village">
            <h3>Santubong Cultural Village</h3>
            <p>A hub for Sarawak’s cultural festivals, showcasing music, dance, and crafts that highlight the heritage of its diverse ethnic groups.</p>
        </div>
    </div>
    </section>

    <!-- Adventure & Nature Section -->
    <section class="adventure">
        <h2>Adventure & Nature in Sarawak</h2>
        <div class="attraction-list">
            <div class="attraction-item">
                <img src="assets/image/Sarawak/Gunung Mulu National Park.jpg" alt="Mulu National Park">
                <h3>Mulu National Park</h3>
                <p>Explore the famous Mulu National Park, a UNESCO World Heritage Site known for its limestone karst formations, extensive caves, and rich biodiversity.</p>
                <h4>Activities: Cave exploration, trekking, and wildlife observation</h4>
                <h4>Location: Miri, Sarawak</h4>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Sarawak/Bako National Park.jpg" alt="Bako National Park">
                <h3>Bako National Park</h3>
                <p>Known for its coastal cliffs, beautiful beaches, and diverse wildlife, Bako National Park offers one of the best nature experiences in Sarawak.</p>
                <h4>Activities: Jungle trekking, wildlife spotting, and beach exploration</h4>
                <h4>Location: Kuching, Sarawak</h4>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Sarawak/Niah National Park.jpg" alt="Niah Caves">
                <h3>Niah National Park</h3>
                <p>Explore the prehistoric Niah Caves, where ancient human remains were discovered, along with fascinating rock paintings.</p>
                <h4>Activities: Cave exploration and archaeological sightseeing</h4>
                <h4>Location: Miri, Sarawak</h4>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Sarawak/Mount Santubong.png" alt="Mount Santubong">
                <h3>Mount Santubong</h3>
                <p>Climb Mount Santubong, a stunning rainforest-covered mountain offering panoramic views of the surrounding area and wildlife spotting opportunities.</p>
                <h4>Activities: Hiking and birdwatching</h4>
                <h4>Location: Santubong, Sarawak</h4>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Sarawak/Lambir Hills National Park.jpg" alt="Lambir Hills National Park">
                <h3>Lambir Hills National Park</h3>
                <p>Known for its diverse plant species, Lambir Hills National Park offers challenging hikes and serene waterfalls amidst dense rainforests.</p>
                <h4>Activities: Jungle trekking and waterfall exploration</h4>
                <h4>Location: Miri, Sarawak</h4>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Sarawak/Similajau National Park.webp" alt="Similajau National Park">
                <h3>Similajau National Park</h3>
                <p>This coastal national park is famous for its golden sandy beaches, rich marine life, and dense jungle trails.</p>
                <h4>Activities: Jungle trekking, beach picnics, and wildlife observation</h4>
                <h4>Location: Bintulu, Sarawak</h4>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Sarawak/Kubah National Park.jpeg" alt="Kubah National Park">
                <h3>Kubah National Park</h3>
                <p>Known for its rich biodiversity, Kubah National Park is a great destination for hiking and enjoying scenic waterfalls.</p>
                <h4>Activities: Jungle trekking, waterfall exploration, and wildlife spotting</h4>
                <h4>Location: Kuching, Sarawak</h4>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Sarawak/Semenggoh Nature Reserve.jpg" alt="Semenggoh Nature Reserve">
                <h3>Semenggoh Nature Reserve</h3>
                <p>Visit the Semenggoh Nature Reserve, home to orangutans being rehabilitated back into the wild, offering an unforgettable wildlife experience.</p>
                <h4>Activities: Wildlife observation and nature walks</h4>
                <h4>Location: Kuching, Sarawak</h4>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Sarawak/Damai Beach.jpg" alt="Damai Beach">
                <h3>Damai Beach</h3>
                <p>Damai Beach offers crystal-clear waters, sandy shores, and a relaxing atmosphere, perfect for beach lovers and water sports enthusiasts.</p>
                <h4>Activities: Swimming, sunbathing, and water sports</h4>
                <h4>Location: Santubong, Sarawak</h4>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Sarawak/Gunung Gading National Park.jpg" alt="Gunung Gading National Park">
                <h3>Gunung Gading National Park</h3>
                <p>Home to the world's largest flower, the Rafflesia, Gunung Gading National Park is a nature lover's paradise.</p>
                <h4>Activities: Jungle trekking, waterfall exploration, and wildlife spotting</h4>
                <h4>Location: Lundu, Sarawak</h4>
            </div>
        </div>
    </section>


    <!-- Food & Cuisine Section -->
    <section class="cuisine">
        <h2>Food & Cuisine in Sarawak</h2>
        <div class="attraction-list">
            <div class="attraction-item">
                <img src="assets/image/Sarawak/Kolo Mee.jpg" alt="Kolo Mee">
                <h3>Kolo Mee</h3>
                <p>A famous Sarawak noodle dish served with minced pork or beef, light soy sauce, and a sprinkle of fried shallots and garlic.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Sarawak/Laksa Sarawak.jpg" alt="Laksa Sarawak">
                <h3>Laksa Sarawak</h3>
                <p>A beloved dish in Sarawak, Laksa Sarawak is a spicy noodle soup made with a fragrant broth of sambal belacan, coconut milk, and served with shredded chicken, prawns, and a side of lime.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Sarawak/Manok Pansoh.jpg" alt="Manok Pansoh">
                <h3>Manok Pansoh</h3>
                <p>A traditional Iban dish, Manok Pansoh is chicken cooked in bamboo with lemongrass, ginger, and tapioca leaves, giving it a unique flavor.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Sarawak/Umai.jpg" alt="Umai">
                <h3>Umai</h3>
                <p>A traditional Melanau raw fish salad, Umai is made with fresh slices of fish marinated in lime juice, shallots, chilies, and salt, served cold.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Sarawak/Midin.jpg" alt="Midin">
                <h3>Midin</h3>
                <p>Midin is a popular Sarawakian wild fern, typically stir-fried with belacan (shrimp paste) and garlic, offering a crunchy and flavorful side dish.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Sarawak/Sarawak Layer Cake.jpg" alt="Sarawak Layer Cake">
                <h3>Sarawak Layer Cake</h3>
                <p>A colorful and intricately designed dessert, Sarawak Layer Cake (Kek Lapis) is known for its vibrant patterns and rich buttery flavor.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Sarawak/Bubur Pedas.webp" alt="Bubur Pedas">
                <h3>Bubur Pedas</h3>
                <p>Bubur Pedas is a spicy porridge made from rice, spices, and a variety of vegetables and herbs, a popular dish during Ramadan in Sarawak.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Sarawak/Terung Dayak.webp" alt="Terung Dayak">
                <h3>Terung Dayak</h3>
                <p>A tangy and sour dish made with a unique Sarawakian eggplant, often cooked in soups or curries with fish or meat.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Sarawak/Ikan Tenggiri Asam Pedas.jpg" alt="Ikan Tenggiri Asam Pedas">
                <h3>Ikan Tenggiri Asam Pedas</h3>
                <p>This spicy and sour mackerel fish stew is flavored with tamarind, chilies, and tomatoes, commonly enjoyed with steamed rice.</p>
            </div>

            <div class="attraction-item">
                <img src="assets/image/Sarawak/Kek Lumut.webp" alt="Kek Lumut">
                <h3>Kek Lumut</h3>
                <p>Kek Lumut, or Moss Cake, is a traditional Sarawak dessert with a dense, moist texture and a green color from pandan and green pea flour.</p>
            </div>
        </div>
    </section>

    <!-- Travel Tips Section -->
    <section class="travel-tips">
        <h2>Travel Tips for Sarawak</h2>
        <div class="attraction-list">
            <div class="attraction-item">
                <h3>Best Time to Visit</h3>
                <p>The best time to visit Sarawak is from March to October, during the dry season. The wet season, from November to February, can bring heavy rains that might disrupt outdoor activities and jungle treks.</p>
            </div>

            <div class="attraction-item">
                <h3>How to Get There</h3>
                <p>
                    <strong>Flights:</strong> Kuching International Airport (KCH) is Sarawak's main airport, with direct flights from Kuala Lumpur, Singapore, and other regional hubs.<br>
                    <strong>By Road:</strong> Sarawak is accessible by road from neighboring regions of Malaysian Borneo. Long-distance buses operate from Brunei and Sabah.<br>
                    <strong>By Boat:</strong> Ferry services connect coastal towns like Sibu and Miri with various riverine and island destinations.
                </p>
            </div>

            <div class="attraction-item">
                <h3>Currency</h3>
                <p>The official currency is the Malaysian Ringgit (MYR). While credit cards are accepted in cities like Kuching, cash is essential when visiting rural areas and local markets.</p>
            </div>

            <div class="attraction-item">
                <h3>Language</h3>
                <p>Bahasa Malaysia is the official language, but English is widely spoken, particularly in Kuching and other tourist areas. Many indigenous communities also speak their own languages.</p>
            </div>

            <div class="attraction-item">
                <h3>Local Transportation</h3>
                <p>
                    <strong>Taxis & E-Hailing Services:</strong> Taxis and Grab are common in Kuching. However, if you’re visiting remote areas, renting a car or booking a tour may be more convenient.<br>
                    <strong>Public Buses:</strong> Buses operate in Kuching, but they are infrequent. For visiting national parks, tour operators often provide transport.<br>
                    <strong>Boats:</strong> Riverboats are commonly used to access remote villages and national parks in Sarawak's interior.
                </p>
            </div>

            <div class="attraction-item">
                <h3>Safety</h3>
                <p>Sarawak is generally a safe destination, but exercise caution in the wilderness. Stick to designated trails when trekking, and be aware of local wildlife, particularly in national parks.</p>
                <p><strong>Travel Insurance:</strong> Ensure your travel insurance covers adventure activities like jungle trekking and diving, as well as medical emergencies.</p>
            </div>

            <div class="attraction-item">
                <h3>Food Safety</h3>
                <p>Sarawak has a thriving street food culture. To ensure safety, eat at popular and busy stalls where food is freshly prepared. Drink only bottled or boiled water, especially in rural areas.</p>
            </div>

            <div class="attraction-item">
                <h3>Respecting Local Customs</h3>
                <p>
                    <strong>Modest Dress:</strong> When visiting rural areas or religious sites, dress modestly. Cover your shoulders and knees, especially in longhouses or mosques.<br>
                    <strong>Longhouse Visits:</strong> When visiting longhouses, ask for permission before taking photographs, and always follow the guidance of your host.
                </p>
            </div>

            <div class="attraction-item">
                <h3>Wildlife Awareness</h3>
                <p>Sarawak's forests are home to unique wildlife, including orangutans and proboscis monkeys. Maintain a safe distance from animals, avoid feeding them, and always follow the advice of guides or park authorities.</p>
            </div>

            <div class="attraction-item">
                <h3>Local Festivals</h3>
                <p>Gawai Dayak, celebrated in June, is Sarawak's major harvest festival. It’s a vibrant celebration featuring traditional music, dancing, and food. The Rainforest World Music Festival, held in July, also attracts international and local musicians.</p>
            </div>
        </div>
    </section>



    <!-- Map Section -->
    <section class="map">
        <h2>Map of Sarawak</h2>
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d688317.2481417953!2d101.40284007283692!3d2.209069265177218!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31f62a0f014b6e47%3A0xf25aa56ec5fe1300!2sSarawak!5e0!3m2!1sen!2smy!4v1727769619684!5m2!1sen!2smy" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
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