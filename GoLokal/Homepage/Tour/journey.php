<?php
session_start();

// Capture the selected plan and state details from the GET request
$plan_name = isset($_GET['plan_name']) ? $_GET['plan_name'] : '';
$state = isset($_GET['state']) ? $_GET['state'] : '';

$state_itineraries = [
    'Johor' => [
        'Top Attractions' => [
            'Day 1' => [
                'Title' => 'Adventure and Relaxation in Johor',
                'Morning' => 'Visit Legoland Malaysia for a day of adventure and excitement with family-friendly rides and attractions.',
                'Afternoon' => 'Relax at Desaru Beach, enjoying the scenic beauty and a picnic lunch by the sea.',
                'Evening' => 'Spend the evening at Johor Bahru City Square for shopping and dining. GoLokal recommends trying local favorites like Mee Rebus, Satay, and Johor-style Chicken Rice at the mall’s food courts or nearby eateries.',
            ],
            'Day 2' => [
                'Title' => 'Exploring Johor’s Heritage and Local Flavors',
                'Morning' => 'Tour Istana Bukit Serene, the royal palace of the Sultan of Johor, and learn about Johor’s regal heritage.',
                'Afternoon' => 'Admire the Victorian-Moorish architecture of Sultan Abu Bakar State Mosque with a guided historical tour.',
                'Evening' => 'Explore Pasar Karat night market, where GoLokal’s curated picks include street foods like Lok Lok (skewered foods), Pisang Goreng (fried bananas), and freshly grilled Otak-Otak (fish cakes wrapped in banana leaves).',
            ],
            'Day 3' => [
                'Title' => 'Nature Exploration and Waterfront Relaxation',
                'Morning' => 'Visit Tanjung Piai National Park, the southernmost tip of mainland Asia, to experience scenic views and mangrove forests.',
                'Afternoon' => 'Conclude your journey with a waterfront lunch at Danga Bay, where GoLokal suggests enjoying popular Johor dishes like Laksa Johor, Mee Bandung, Kacang Pool, and Nasi Briyani Gam at nearby seaside restaurants.',
                'Optional Evening' => 'If time permits, visit Kota Tinggi Waterfalls for a refreshing experience with nature and a final leisurely dip.',
            ],

            'GoLokal Offerings' => [
                'Food Recommendations' => 'Curated list of local food spots at Johor Bahru City Square and Pasar Karat night market.',
                'Guided Tours' => 'Historical tours of Sultan Abu Bakar State Mosque and Istana Bukit Serene with knowledgeable local guides.',
                'Cuisine Tour' => 'A guided Johor cuisine tour featuring traditional dishes and must-try flavors.',
                'Shopping Assistance' => 'Guided shopping experiences at Johor Bahru City Square and Pasar Karat, helping you discover local crafts and antiques.',
                'Relaxation Spots' => 'Recommended spots for a relaxing beach experience at Desaru Beach and waterfront dining at Danga Bay.',
            ]
        ],

        'Cultural Heritage' => [
            'Day 1' => [
                'Title' => 'Arrival & Exploration of Johor Bahru’s Historical Roots',
                'Morning' => 'Arrive in Johor Bahru and check in to your hotel.',
                'Afternoon' => 'Discover the Johor Bahru Old Chinese Temple and explore Chinese Ancestral Temples, gaining insights into Johor’s multicultural heritage. Visit heritage shops and local food stalls along the Johor Heritage Trail.',
                'Evening' => 'Dine in the Johor Bahru city center with GoLokal’s recommendations to try dishes like Mee Rebus, Lontong, and Laksa Johor for an authentic local taste.',
            ],
            'Day 2' => [
                'Title' => 'Royal Heritage and Historical Sites',
                'Morning' => 'Begin with a visit to the Sultan Abu Bakar Royal Museum housed in the Grand Palace (Istana Besar) to explore Johor’s royal history, including artifacts, weaponry, and regalia.',
                'Afternoon' => 'Explore nearby heritage sites, such as Sultan Abu Bakar State Mosque, known for its Victorian-Moorish architecture, and the Laksamana Bentan Mausoleum, commemorating a historic Malay warrior.',
                'Evening' => 'Enjoy traditional Johorean cuisine at a local restaurant. GoLokal suggests trying Nasi Briyani Gam, Kacang Pool, and Ikan Asam Pedas, which are regional specialties.',
            ],
            'Day 3' => [
                'Title' => 'Traditional Arts, Crafts, and Cultural Villages',
                'Morning' => 'Participate in cultural activities like the Festival Zapin Johor, where you can witness the traditional Zapin dance, a key part of Johor’s Malay heritage. If available, join in workshops or performances.',
                'Afternoon' => 'Visit Kampung Johor Lama (Old Johor Village), a historical site that provides a glimpse into the life of early Johoreans. Explore artisan markets for authentic handicrafts. GoLokal recommends sampling local snacks such as Keropok Lekor (fish crackers) and Kuih (Malay pastries) during your exploration.',
                'Late Afternoon' => 'Check out and prepare for departure.',
            ],

            'GoLokal Offerings' => [
                'Guided Tours' => 'Experienced guides provide in-depth insights and stories behind cultural landmarks, enriching your understanding of Johor’s heritage.',
                'Transportation Arrangements' => 'Convenient and organized transport between sites for a seamless and hassle-free experience.',
                'Hands-On Craft Sessions' => 'Interactive workshops with local artisans, allowing visitors to engage in traditional Malay arts and crafts.',
                'Accommodation Recommendations' => 'Curated hotel suggestions near key cultural landmarks for easy access to attractions.',
                'Dining Experiences' => 'Meals at traditional restaurants featuring curated local menus, including dishes like Laksa Johor and Nasi Briyani Gam.',
                'Customized Itineraries' => 'Flexible itinerary adjustments to cater to personal preferences, ensuring a personalized experience.',
            ]
        ],

        'Adventure' => [
            'Day 1' => [
                'Title' => 'Rainforest Trekking and Waterfall Exploration',
                'Morning' => 'Arrive in Johor and check in to your hotel.',
                'Afternoon' => 'Explore Endau-Rompin National Park with activities like jungle trekking, bird watching, and waterfall exploration. Enjoy the lush rainforest and diverse wildlife.',
                'Evening' => 'Dine on local cuisine at a nearby restaurant, with GoLokal’s recommendations to try dishes like Ayam Penyet, Nasi Lemak, and Satay for a hearty, authentic meal.'
            ],
            'Day 2' => [
                'Title' => 'Beach and Marine Adventures',
                'Morning' => 'Travel to Sultan Iskandar Marine Park for a morning of snorkeling, scuba diving, and kayaking to experience Johor’s underwater beauty and vibrant coral reefs.',
                'Afternoon' => 'Enjoy lunch by the beach at Desaru Coast, sampling local seafood specialties such as Sambal Prawns, Grilled Fish, and Kerabu (Malay salad). Relax on Desaru Beach or try more water sports like jet skiing and surfing.',
                'Evening' => 'Unwind with a scenic dinner along the Desaru Coast, with GoLokal’s picks for fresh seafood and local desserts like Cendol and Pisang Goreng.'
            ],
            'Day 3' => [
                'Title' => 'Mountain Climbing and Firefly Tours',
                'Morning' => 'Climb Gunung Ledang (Mount Ophir) for a challenging hike with breathtaking views from the summit. Enjoy guided routes and rest stops along the way.',
                'Afternoon' => 'Return for a relaxed lunch featuring Johorean favorites like Mee Bandung and Roti Jala. Recharge after the climb.',
                'Evening' => 'End your adventure at Sungai Lebam Wetlands for a magical firefly boat tour, where you can witness thousands of fireflies lighting up the night in a serene setting. Optionally, try local snacks like Otak-Otak and Goreng Pisang before heading back to your hotel.'
            ],
            'GoLokal Offerings' => [
                'Activity Passes' => 'Pre-arranged passes for adventure activities, including Endau-Rompin National Park, Sultan Iskandar Marine Park, and firefly tours at Sungai Lebam Wetlands.',
                'Safety Gear and Guides' => 'Provision of safety equipment and trained guides for trekking, climbing, water sports, and firefly tours to ensure a safe experience.',
                'Transportation' => 'Organized transport between adventure locations, covering remote areas like Gunung Ledang and Endau-Rompin National Park.',
                'Dining Recommendations' => 'Curated list of dining options near adventure spots, with recommendations for local favorites such as seafood dishes, traditional Malay cuisine, and local desserts.',
                'Accommodation Suggestions' => 'Recommendations for hotels and lodges catering to adventure travelers, located near nature parks and coastal areas.',
                'Custom Itinerary Flexibility' => 'Options to customize the itinerary based on preferences, fitness levels, and weather conditions for a personalized adventure experience.',
            ],
        ],
    ],

    'Kedah' => [
        'Top Attractions' => [
            'Day 1' => [
                'Title' => 'Cultural Insights and Scenic Views',
                'Morning' => 'Begin your journey with a visit to the Kedah Paddy Museum to learn about the history and significance of rice cultivation in Kedah, known as the "Rice Bowl of Malaysia."',
                'Afternoon' => 'Head to the Alor Setar Tower for panoramic views of Alor Setar and its surroundings. Enjoy lunch at the revolving restaurant at the top, where GoLokal recommends trying local specialties like Gulai Ikan Temenung (mackerel curry) and Laksa Kedah.',
                'Evening' => 'Stroll around Taman Jubli Emas, a serene park with gardens and walking paths, perfect for a relaxing evening.',
            ],
            'Day 2' => [
                'Title' => 'Island Adventure on Langkawi',
                'Morning' => 'Take a ferry to Langkawi Island, known as the Jewel of Kedah. Start your day with a visit to Pantai Cenang, a popular beach for water activities and beach relaxation.',
                'Afternoon' => 'Explore other iconic spots like the Langkawi Sky Bridge for breathtaking views, and enjoy activities like snorkeling at Pulau Payar Marine Park. For lunch, GoLokal recommends sampling local seafood dishes like Grilled Fish with Air Asam and Sotong Bakar (grilled squid).',
                'Evening' => 'End your day with a peaceful dinner by the beach, where you can enjoy dishes like Nasi Tomato and Ayam Percik, a local favorite.',
            ],
            'Day 3' => [
                'Title' => 'Historical Landmarks and Natural Beauty',
                'Morning' => 'Visit Gunung Jerai, a scenic mountain offering cool air and stunning views. This is a popular spot for hiking and nature lovers.',
                'Afternoon' => 'Travel to Kota Kuala Kedah (Kuala Kedah Fort) to explore this historical fortress that defended Kedah from foreign invasions. For lunch, GoLokal suggests local delicacies such as Nasi Ulam (herb rice) and Daging Masak Hitam (blackened beef).',
                'Evening' => 'End your journey at the ancient Lembah Bujang Archaeological Museum, where you can explore artifacts from one of Southeast Asia\'s earliest civilizations. Conclude with a traditional dinner in Alor Setar featuring Laksa Kedah or Mee Rebus.',
            ],

            'GoLokal Offerings' => [
                'Guided Tours' => 'Expert guides for each cultural and historical site, providing rich stories about Kedah’s heritage.',
                'Transportation Arrangements' => 'Organized transport between attractions, including ferry arrangements to Langkawi Island.',
                'Dining Recommendations' => 'Curated list of restaurants offering Kedah specialties like Laksa Kedah, Ayam Percik, and seafood dishes.',
                'Accommodation Suggestions' => 'Recommendations for hotels near major attractions such as Langkawi Island and Alor Setar.',
                'Custom Itinerary Flexibility' => 'Flexible itinerary options to personalize your journey based on interests and preferences.',
            ],
        ],

        'Cultural Heritage' => [
            'Day 1' => [
                'Title' => 'Historical Landmarks and Traditional Heritage',
                'Morning' => 'Begin with a visit to Muzium Negeri Kedah to explore the history, culture, and heritage of Kedah. The museum showcases artifacts from the Kedah Sultanate, traditional Malay lifestyle, and archaeological finds from Bujang Valley.',
                'Afternoon' => 'Explore Balai Nobat, where royal musical instruments are stored, symbolizing Kedah’s monarchy and traditions.',
                'Evening' => 'Dine in Alor Setar with GoLokal’s recommendations to try Kedah specialties like Laksa Kedah and Nasi Ulam (herb rice) for a taste of local flavors.',
            ],
            'Day 2' => [
                'Title' => 'Sacred Sites and Cultural Roots',
                'Morning' => 'Visit the iconic Masjid Zahir, one of Malaysia’s oldest mosques, renowned for its Islamic architecture and religious significance.',
                'Afternoon' => 'Continue to Istana Anak Bukit, the official residence of the Sultan of Kedah, which showcases royal Malay architecture and Kedah’s ceremonial heritage.',
                'Evening' => 'Experience local cuisine at a traditional restaurant. GoLokal recommends trying dishes like Daging Masak Hitam (blackened beef) and Ayam Percik for an authentic Kedah dining experience.',
            ],
            'Day 3' => [
                'Title' => 'Ancient Civilizations and Local Traditions',
                'Morning' => 'Explore Lembah Bujang, an archaeological site with ancient Hindu-Buddhist temples and ruins from one of Southeast Asia’s earliest civilizations.',
                'Afternoon' => 'Visit Rumah Tok Su, a traditional Malay house that has been preserved to display Malay architecture and cultural heritage, and then head to Pekan Rabu, a traditional market known for local handicrafts and traditional foods.',
                'Evening' => 'Conclude your cultural journey with dinner featuring Kedah favorites like Mee Rebus and Kuih (traditional Malay pastries) for dessert, curated by GoLokal.',
            ],

            'GoLokal Offerings' => [
                'Guided Tours' => 'Experienced guides provide historical insights at each cultural landmark, enriching the understanding of Kedah’s heritage.',
                'Transportation Arrangements' => 'Organized transport between historical sites, ensuring a smooth cultural exploration.',
                'Dining Recommendations' => 'A curated list of restaurants serving Kedah specialties such as Laksa Kedah, Nasi Ulam, and Ayam Percik.',
                'Accommodation Suggestions' => 'Recommendations for accommodations near major cultural sites in Alor Setar.',
                'Custom Itinerary Flexibility' => 'Flexible itinerary adjustments to personalize cultural experiences based on individual interests.',
            ],
        ],

        'Adventure' => [
            'Day 1' => [
                'Title' => 'Mountain Views and Waterfall Exploration',
                'Morning' => 'Start your adventure with a hike up Gunung Jerai for breathtaking views and nature photography. Enjoy the cool climate and scenic trails.',
                'Afternoon' => 'Continue your day with a visit to Bukit Hijau Waterfall, a serene spot surrounded by lush greenery, perfect for a refreshing swim and picnic.',
                'Evening' => 'Dine locally with GoLokal’s recommendations, trying dishes such as Nasi Lemuni (rice cooked with lemuni leaves) and Ikan Bakar (grilled fish) for a delicious end to your day.',
            ],
            'Day 2' => [
                'Title' => 'Island Thrills and Coastal Exploration',
                'Morning' => 'Head to Langkawi for a thrilling walk across the Langkawi Sky Bridge and panoramic views from the Langkawi Cable Car.',
                'Afternoon' => 'Experience water activities at Telaga Tujuh Waterfalls (Seven Wells Waterfalls), where you can swim, hike, and relax. For lunch, GoLokal suggests enjoying fresh seafood like Sotong Goreng Tepung (fried squid) and Udang Masak Lemak (prawns in coconut milk).',
                'Evening' => 'Enjoy a beachside dinner with local favorites like Nasi Tomato and Ayam Percik while watching the sunset on Langkawi’s coastline.',
            ],
            'Day 3' => [
                'Title' => 'Mangrove Exploration and Lake Serenity',
                'Morning' => 'Embark on a mangrove tour at Kilim Karst Geoforest Park. Explore the rich mangrove ecosystem, observe wildlife, and take a boat ride through limestone formations.',
                'Afternoon' => 'Visit Tasik Pedu, one of Kedah’s largest lakes, for fishing, boating, and nature observation in a tranquil setting. Enjoy a picnic lunch with GoLokal’s curated snacks like Kuih Karas (crispy rice flour snack) and Dodol (traditional sticky toffee).',
                'Evening' => 'End your journey with a local dinner in Alor Setar, sampling dishes like Laksa Kedah and Pulut Durian (glutinous rice with durian) as a sweet farewell.',
            ],
            'GoLokal Offerings' => [
                'Activity Passes' => 'Pre-arranged passes for hiking, mangrove tours, and adventure activities in Langkawi and Kilim Karst Geoforest Park.',
                'Safety Gear and Guides' => 'Provision of safety equipment and trained guides for all adventure activities to ensure a safe experience.',
                'Transportation' => 'Organized transport between remote adventure locations like Gunung Jerai, Kilim Karst Geoforest Park, and Tasik Pedu.',
                'Dining Recommendations' => 'A curated list of dining options featuring local favorites such as Nasi Lemuni, Ayam Percik, and seafood specialties.',
                'Accommodation Suggestions' => 'Recommendations for eco-lodges and hotels catering to adventurous travelers, located near nature spots and coastal areas.',
                'Custom Itinerary Flexibility' => 'Flexible options to adjust activities based on weather and personal preferences for a personalized adventure experience.',
            ],
        ],
    ],

    'Kelantan' => [
        'Top Attractions' => [
            'Day 1' => [
                'Title' => 'Cultural Landmarks and Heritage in Kota Bharu',
                'Morning' => 'Begin your journey with a visit to Istana Jahar, a former royal residence turned museum that showcases Kelantanese culture, heritage, and traditional craftsmanship.',
                'Afternoon' => 'Explore Siti Khadijah Market, a bustling market where local traders, mostly women, sell fresh produce, traditional snacks, and handmade crafts. GoLokal recommends trying Kelantan delicacies such as Nasi Kerabu (herb rice) and Ayam Percik (spiced grilled chicken).',
                'Evening' => 'Enjoy dinner at a local restaurant, sampling dishes like Laksam (Kelantanese rice noodle in fish gravy) and Kuih Akok (traditional coconut milk pastries) for dessert.',
            ],
            'Day 2' => [
                'Title' => 'Historical Sites and Traditional Crafts',
                'Morning' => 'Visit Kampung Laut Mosque, one of the oldest mosques in Malaysia, known for its traditional Malay architecture and spiritual significance.',
                'Afternoon' => 'Head to the Rantau Panjang Duty-Free Zone for shopping and explore local handicrafts. For lunch, GoLokal suggests trying local snacks such as Keropok Lekor (fish crackers) and Nasi Tumpang (rice layered with different dishes in a cone-shaped banana leaf).',
                'Evening' => 'Experience the lively atmosphere of Wakaf Che Yeh Night Market, where you can find souvenirs, clothing, and Kelantanese street foods like Pulut Bakar (grilled glutinous rice) and Sata (fish wrapped in banana leaves).',
            ],
            'Day 3' => [
                'Title' => 'Natural Wonders and Historical Insights',
                'Morning' => 'Start with a trip to Gunung Stong State Park, known for its majestic seven-tiered waterfall, Jelawang Waterfall, offering stunning views and hiking opportunities.',
                'Afternoon' => 'Visit Gua Ikan, a limestone cave with fascinating folklore and scenic surroundings. Enjoy a picnic lunch with traditional dishes like Nasi Dagang (coconut rice with fish curry) and Dodol (sticky toffee-like dessert) arranged by GoLokal.',
                'Evening' => 'Return to Kota Bharu to visit Muzium Kelantan, which houses exhibits on Kelantan’s arts, culture, and royal heritage. End your day with a local dinner featuring dishes like Mee Celup (Kelantan-style noodle soup) and Tepung Pelita (layered coconut milk dessert).',
            ],
            'GoLokal Offerings' => [
                'Guided Tours' => 'Expert guides provide historical and cultural context at each landmark, enriching your understanding of Kelantan’s heritage.',
                'Transportation Arrangements' => 'Convenient transportation options between attractions for a hassle-free journey.',
                'Dining Recommendations' => 'A curated list of restaurants featuring Kelantan’s traditional dishes such as Nasi Kerabu, Laksam, and Ayam Percik.',
                'Accommodation Suggestions' => 'Recommendations for hotels near major attractions in Kota Bharu and surrounding areas.',
                'Custom Itinerary Flexibility' => 'Options to adjust the itinerary based on personal interests and preferred experiences.',
            ],
        ],

        'Cultural Heritage' => [
            'Day 1' => [
                'Title' => 'Exploring Traditional Arts and Crafts',
                'Morning' => 'Start with a visit to Balai Getam Guri, a center dedicated to traditional Kelantanese arts, where you can see exhibits on batik, songket weaving, and wood carving.',
                'Afternoon' => 'Head to the Wayang Kulit (Shadow Puppet) Theatre to experience the intricate art of shadow puppetry, where skilled puppeteers bring ancient stories to life with music and narration.',
                'Evening' => 'Dine at a local Kelantanese restaurant, with GoLokal’s recommendations to try dishes like Nasi Kerabu (herb rice with blue rice) and Ayam Percik (grilled spiced chicken) for a true taste of Kelantanese flavors.',
            ],
            'Day 2' => [
                'Title' => 'Islamic Heritage and Local Markets',
                'Morning' => 'Visit Muzium Islam Kelantan to explore the influence of Islam on Kelantan’s culture, architecture, and history through its exhibits.',
                'Afternoon' => 'Explore Siti Khadijah Market, a vibrant marketplace known for traditional snacks, Kelantanese handicrafts, and local produce sold by local women traders. GoLokal suggests sampling street foods like Akok (sweet coconut milk cakes) and Lompat Tikam (traditional rice dessert).',
                'Evening' => 'Visit Pantai Seri Tujuh (Seven Lagoons Beach) for a scenic beach experience. Known for the annual International Kite Festival, it’s a popular spot to witness Kelantan’s kite-flying traditions.',
            ],
            'Day 3' => [
                'Title' => 'Cultural Festivals and Spiritual Landmarks',
                'Morning' => 'Experience the Rebana Ubi (Giant Drum) Festival, where you can see performances showcasing the traditional Kelantanese drums, a unique part of the region’s musical heritage.',
                'Afternoon' => 'Explore Wat Photivihan, home to Southeast Asia’s largest reclining Buddha statue, symbolizing the influence of the Thai-Buddhist community in Kelantan.',
                'Evening' => 'End your cultural journey with dinner at a local spot, enjoying dishes like Laksam (Kelantan-style rice noodles in fish gravy) and Kuih Tahi Itik (sweet mung bean and egg yolk dessert) recommended by GoLokal.',
            ],
            'GoLokal Offerings' => [
                'Guided Tours' => 'Expert guides at each cultural site offer insights into the history and significance of Kelantan’s heritage.',
                'Transportation Arrangements' => 'Convenient transportation options between cultural landmarks for a seamless experience.',
                'Dining Recommendations' => 'A curated list of restaurants featuring traditional Kelantanese dishes such as Nasi Kerabu, Laksam, and Ayam Percik.',
                'Accommodation Suggestions' => 'Recommendations for accommodations near key cultural sites in Kota Bharu and surrounding areas.',
                'Custom Itinerary Flexibility' => 'Flexible itinerary options to cater to personal preferences and interests in specific cultural experiences.',
            ],
        ],

        'Adventure' => [
            'Day 1' => [
                'Title' => 'River Rafting and Jungle Exploration',
                'Morning' => 'Begin your adventure with an exhilarating white-water rafting experience on the Nenggiri River. Enjoy the rush of navigating through rapids amidst lush rainforest surroundings.',
                'Afternoon' => 'Relax and have lunch at a local spot with GoLokal’s recommendations to try Kelantanese favorites such as Nasi Kerabu (herb rice) and Ikan Singgang (fish stew).',
                'Evening' => 'Unwind at Pantai Irama, also known as "The Beach of Melody," where you can enjoy a peaceful evening walk or swim in the calm waters.',
            ],
            'Day 2' => [
                'Title' => 'Hiking and Waterfalls in Gunung Stong',
                'Morning' => 'Embark on a jungle trekking adventure in Gunung Stong State Park. Hike up to Jelawang Waterfall, one of the highest waterfalls in Southeast Asia, and take in the stunning views and abundant wildlife.',
                'Afternoon' => 'Have a picnic lunch by the waterfall, arranged by GoLokal, featuring traditional snacks like Kuih Akok and Nasi Tumpang (rice layered with curries).',
                'Evening' => 'Return to Kota Bharu for a relaxing dinner, with dishes like Ayam Percik (spiced grilled chicken) and Laksam (Kelantanese rice noodles in fish gravy).',
            ],
            'Day 3' => [
                'Title' => 'Caving and Beach Relaxation',
                'Morning' => 'Head to Gua Ikan or Gua Musang for a caving adventure. These limestone caves offer fascinating formations and are steeped in local folklore.',
                'Afternoon' => 'Travel to Pantai Bisikan Bayu, the "Beach of Whispering Breeze," for a relaxing afternoon. This serene beach is perfect for picnics, fishing, and enjoying the peaceful coastal scenery.',
                'Evening' => 'End your adventure with a seafood dinner at a coastal restaurant, with GoLokal’s recommendations to try local seafood dishes like Sotong Goreng Tepung (fried squid) and Udang Masak Lemak (prawns in coconut milk).',
            ],
            'GoLokal Offerings' => [
                'Activity Passes' => 'Pre-arranged passes for white-water rafting, jungle trekking, and caving activities.',
                'Safety Gear and Guides' => 'Provision of safety equipment and trained guides for all adventure activities to ensure a safe experience.',
                'Transportation' => 'Organized transport between adventure sites such as the Nenggiri River, Gunung Stong State Park, and Gua Ikan.',
                'Dining Recommendations' => 'A curated list of dining options featuring Kelantanese specialties such as Nasi Kerabu, Ayam Percik, and seafood dishes.',
                'Accommodation Suggestions' => 'Recommendations for eco-lodges and adventure-friendly accommodations near major sites.',
                'Custom Itinerary Flexibility' => 'Options to adjust activities based on personal preferences and weather conditions for a tailored adventure experience.',
            ],
        ],
    ],
    'Melaka' => [
        'Top Attractions' => [
            'Day 1' => [
                'Title' => 'Historical Forts and Scenic Views',
                'Morning' => 'Start your day by visiting A’Famosa Fort, one of the oldest European architectural remains in Southeast Asia, which offers a glimpse into Melaka’s Portuguese history.',
                'Afternoon' => 'Head to St. Paul’s Hill to explore the ruins of St. Paul’s Church and enjoy panoramic views of Melaka’s historical cityscape.',
                'Evening' => 'Dine in Melaka’s city center, where GoLokal recommends trying local specialties such as Asam Pedas (spicy sour fish stew) and Nyonya Laksa (a fusion of Malay and Chinese flavors).',
            ],
            'Day 2' => [
                'Title' => 'Colonial Architecture and Bustling Streets',
                'Morning' => 'Visit The Stadthuys, a distinctive red building built by the Dutch in 1650 that now serves as a museum showcasing Melaka’s colonial past.',
                'Afternoon' => 'Stroll through Jonker Street, famous for its bustling night market, where you can find souvenirs, local delicacies, and cultural performances. For lunch, GoLokal suggests trying Chicken Rice Balls, a unique Melaka twist on traditional Hainanese chicken rice.',
                'Evening' => 'Enjoy the vibrant atmosphere of Jonker Street at night, sampling street foods like Kuih Keria (sweet potato doughnuts) and Popiah (fresh spring rolls).',
            ],
            'Day 3' => [
                'Title' => 'Maritime Heritage and Peranakan Culture',
                'Morning' => 'Explore the Flora de la Mar Maritime Museum, housed in a replica of a Portuguese ship, to learn about Melaka’s history as a major trading port in Southeast Asia.',
                'Afternoon' => 'Visit the Baba & Nyonya Heritage Museum, which showcases the unique culture of the Peranakan Chinese community in Melaka. For lunch, GoLokal recommends trying Peranakan dishes like Ayam Pongteh (chicken stew) and Cendol (a shaved ice dessert with coconut milk and palm sugar).',
                'Evening' => 'Take a scenic Melaka River Cruise to see the city’s architecture and historical landmarks from a unique perspective.',
            ],
            'GoLokal Offerings' => [
                'Guided Tours' => 'Experienced guides provide insights into Melaka’s history, architecture, and cultural heritage at each major site.',
                'Transportation Arrangements' => 'Convenient transportation between historical and cultural attractions for a seamless journey.',
                'Dining Recommendations' => 'A curated list of restaurants featuring Melaka’s specialties, including Asam Pedas, Chicken Rice Balls, and Peranakan dishes.',
                'Accommodation Suggestions' => 'Recommendations for hotels near major attractions in Melaka’s historical city center.',
                'Custom Itinerary Flexibility' => 'Options to adjust the itinerary based on personal interests for a tailored experience in Melaka.',
            ],
        ],

        'Cultural Heritage' => [
            'Day 1' => [
                'Title' => 'Peranakan Heritage and Historical Landmarks',
                'Morning' => 'Start your journey with a visit to the Baba & Nyonya Heritage Museum, where you can learn about the rich Peranakan culture. This museum offers a glimpse into the daily lives, customs, and traditions of the Peranakan Chinese community in Melaka.',
                'Afternoon' => 'After the museum, head over to St. Paul’s Hill and explore the ruins of St. Paul’s Church. The church offers panoramic views of Melaka’s historical cityscape, including the A’Famosa Fort, built by the Portuguese in 1511.',
                'Evening' => 'Dine in Melaka’s city center and sample local dishes such as Chicken Rice Balls and Nyonya Laksa, two of Melaka’s signature dishes, highly recommended by GoLokal.',
            ],
            'Day 2' => [
                'Title' => 'Traditional Malay Village and Religious Heritage',
                'Morning' => 'Begin your day by exploring Kampung Morten, a traditional Malay village located along the Melaka River. The village features beautifully preserved wooden houses, reflecting the local Malay architectural style and cultural heritage.',
                'Afternoon' => 'Visit Cheng Hoon Teng Temple, Malaysia’s oldest functioning Chinese temple, dedicated to the goddess of mercy. This temple is a testament to Melaka’s multicultural past and is an important symbol of the Chinese community’s religious practices.',
                'Evening' => 'Head to Chitty Village, a unique blend of Indian and Malay cultural influences, where you can enjoy a quiet evening and taste Chitty-style curry for dinner.',
            ],
            'Day 3' => [
                'Title' => 'Portuguese Heritage and Cultural Performances',
                'Morning' => 'Spend the morning at the Melaka Sultanate Palace, a replica of Sultan Mansur Shah’s 15th-century palace, showcasing the rich history of the Melaka Sultanate through its exhibits.',
                'Afternoon' => 'Continue your journey by visiting the Portuguese Settlement, a vibrant community preserving the heritage of Melaka’s Portuguese descendants. Be sure to try Portuguese-inspired dishes like Devil’s Curry for lunch.',
                'Evening' => 'End your trip with a cultural dance performance at Encore Melaka. This immersive show highlights the city’s history and multiculturalism through stunning visuals and performances.',
            ],
            'GoLokal Offerings' => [
                'Guided Tours' => 'Experienced guides who specialize in Melaka’s cultural heritage will provide insightful commentary at each location.',
                'Transportation Arrangements' => 'Transportation between cultural attractions such as Kampung Morten, the Portuguese Settlement, and Jonker Street for a hassle-free experience.',
                'Dining Recommendations' => 'Curated lists of the best local restaurants offering Melaka’s signature dishes, including Peranakan cuisine, Chitty dishes, and Portuguese food.',
                'Accommodation Suggestions' => 'A selection of hotels located within walking distance to key attractions such as Jonker Street and the Baba & Nyonya Heritage Museum.',
                'Custom Itinerary Flexibility' => 'Options to customize the itinerary based on personal interests, with the possibility to add visits to other significant cultural landmarks or more culinary stops.',
            ],
        ],

        'Adventure' => [
            'Day 1' => [
                'Title' => 'River Cruise and Nature Walks',
                'Morning' => 'Start your adventure with a relaxing river cruise along the Melaka River. Enjoy the scenic views of Melaka’s waterfront, passing by historical buildings, colorful murals, and modern attractions.',
                'Afternoon' => 'After the river cruise, visit Taman Botani Melaka for a nature walk. Explore the park’s cycling paths, canopy walk, and bird-watching opportunities, perfect for a nature lover’s adventure.',
                'Evening' => 'For dinner, head to a local restaurant by the river and enjoy Melaka’s famous Ikan Bakar (grilled fish), served with spicy sambal and rice.',
            ],
            'Day 2' => [
                'Title' => 'Treetop Adventures and Night Safari',
                'Morning' => 'Spend your morning experiencing Skytrekking at Taman Rimba in Ayer Keroh, where you can navigate through a series of treetop obstacles and zip lines in the forest. It’s a thrilling adventure perfect for adrenaline seekers.',
                'Afternoon' => 'After an exciting morning, visit the Melaka Zoo for some wildlife observation. During the afternoon, explore the zoo and its various animal exhibits.',
                'Evening' => 'Stay for the Night Safari at the zoo, where you can explore the nocturnal habits of different animals. Enjoy a local dinner with dishes like Asam Pedas (spicy sour fish stew) at a nearby Ayer Keroh restaurant.',
            ],
            'Day 3' => [
                'Title' => 'Cycling and Scenic Views',
                'Morning' => 'Join a cycling tour that takes you through Melaka’s historical landmarks. Ride past A’Famosa Fort, St. Paul’s Church, and along the riverbank, immersing yourself in the city’s rich history and scenic views.',
                'Afternoon' => 'For lunch, indulge in Chicken Rice Balls, a local favorite, at one of Jonker Street’s popular eateries.',
                'Evening' => 'End your adventure-filled day by heading to Pantai Klebang to enjoy a serene beachside evening. Watch the sunset while enjoying local street food such as Coconut Shake and Kuih Keria (sweet potato doughnuts).',
            ],
            'GoLokal Offerings' => [
                'Guided Tours' => 'Professional guides for river cruises, skytrekking, and cycling adventures to ensure a safe and enjoyable experience.',
                'Transportation Arrangements' => 'Convenient transfers between adventure sites such as Taman Botani, Melaka Zoo, and Pantai Klebang.',
                'Dining Recommendations' => 'Curated lists of restaurants serving Melaka’s famous adventure fuel meals like Ikan Bakar, Asam Pedas, and Chicken Rice Balls.',
                'Accommodation Suggestions' => 'Recommendations for adventure-friendly hotels near nature parks and the riverfront.',
                'Custom Itinerary Flexibility' => 'Options to adjust the itinerary for personalized adventure experiences such as additional hiking, water sports, or wildlife photography.',
            ],
        ],
    ],


    'Negeri Sembilan' => [
        'Top Attractions' => [
            'Day 1' => [
                'Title' => 'Seremban Heritage and Nature',
                'Morning' => 'Begin your day at the Seremban Lake Gardens, a beautifully landscaped public park perfect for a morning stroll. Enjoy the peaceful surroundings with lush greenery and serene lakes.',
                'Afternoon' => 'Visit the Negeri Sembilan State Museum to learn about the state’s history, culture, and traditional Minangkabau architecture. This museum offers a fascinating glimpse into the heritage of Negeri Sembilan.',
                'Evening' => 'End your day by exploring local cuisine. GoLokal recommends trying Masak Lemak Cili Api, a spicy coconut-based dish with meat or fish, and pairing it with Daging Salai (smoked beef) for a truly local dining experience.',
            ],
            'Day 2' => [
                'Title' => 'Historical Fort and Outdoor Adventures',
                'Morning' => 'Take a trip to Fort Lukut, an old fort with a rich historical background. The fort also houses a museum, showcasing artifacts and information about Negeri Sembilan’s royal history and the fort’s importance during the tin mining era.',
                'Afternoon' => 'Head to the Jeram Toi Waterfall for a refreshing afternoon amidst nature. Enjoy a picnic, swim in the natural pools, or simply relax by the waterfall.',
                'Evening' => 'For dinner, enjoy Nasi Minyak or Nasi Ambeng, a fragrant rice dish often served during festivities, along with a variety of side dishes. This will give you a taste of the local celebration cuisine.',
            ],
            'Day 3' => [
                'Title' => 'Beach Relaxation and Scenic Views',
                'Morning' => 'Spend the day relaxing at Port Dickson Beach, one of the most popular beach destinations in Negeri Sembilan. Enjoy sunbathing, swimming, or beachside picnicking.',
                'Afternoon' => 'Visit the Cape Rachado Lighthouse, a historic landmark offering panoramic views of the Straits of Malacca. The area is also perfect for bird-watching and nature exploration.',
                'Evening' => 'For your final dinner, indulge in Ikan Bakar (grilled fish) or Sotong Goreng (fried squid) at a beachfront restaurant, enjoying the fresh seafood and the beautiful ocean view.',
            ],
            'GoLokal Offerings' => [
                'Guided Tours' => 'Experienced local guides will take you through historical landmarks like Fort Lukut and Cape Rachado Lighthouse, providing insights into the area’s rich history.',
                'Transportation Arrangements' => 'Convenient transport options between attractions like Seremban Lake Gardens, Jeram Toi Waterfall, and Port Dickson Beach to make your journey seamless.',
                'Dining Recommendations' => 'Curated lists of restaurants serving Negeri Sembilan specialties such as Masak Lemak Cili Api, Nasi Ambeng, and fresh seafood.',
                'Accommodation Suggestions' => 'Suggestions for beachside resorts in Port Dickson or hotels near Seremban’s top attractions for a comfortable stay.',
                'Custom Itinerary Flexibility' => 'Adjust the itinerary according to personal preferences, whether you want more time at the beach or additional historical site visits.',
            ],
        ],

        'Cultural Heritage' => [
            'Day 1' => [
                'Title' => 'Minangkabau Heritage and Traditions',
                'Morning' => 'Begin your cultural journey with a visit to the Minangkabau Cultural Complex, where you can explore traditional architecture, customs, and exhibits on Minangkabau history. Learn about the influence of the Minangkabau people in shaping Negeri Sembilan’s culture.',
                'Afternoon' => 'After the cultural complex, visit the Adat Museum to further understand the local traditions, including unique marriage rites, traditional clothing, and other customs deeply rooted in the Minangkabau heritage.',
                'Evening' => 'Enjoy a traditional Minangkabau meal for dinner, with dishes such as Masak Lemak Cili Api (spicy coconut milk stew) and Rendang Daging (spicy beef stew) at a local restaurant recommended by GoLokal.',
            ],
            'Day 2' => [
                'Title' => 'Traditional Malay Homes and Craftsmanship',
                'Morning' => 'Travel to Kampung Pelegong for an immersive experience in traditional Malay village life. Participate in local crafts, farming, and cultural activities as you explore the homestay lifestyle.',
                'Afternoon' => 'Visit the Malay Traditional House in Pantai to see classic Malay wooden architecture, complete with intricate carvings. Learn about the construction and symbolism of these houses from local guides.',
                'Evening' => 'Sample authentic Daging Salai Masak Lemak (smoked meat in spicy coconut broth) for dinner, a specialty of Negeri Sembilan’s traditional cuisine.',
            ],
            'Day 3' => [
                'Title' => 'Cultural Performances and Local Festivals',
                'Morning' => 'Start your day at Sri Menanti Royal Museum, a former palace showcasing royal artifacts and traditional Minangkabau architecture. This visit offers insights into Negeri Sembilan’s royal history.',
                'Afternoon' => 'Explore the Astana Raja Melewar, the historical palace of Negeri Sembilan’s first Yang di-Pertuan Besar, before heading to the Rembau Crystal center to see local artisans crafting glass and crystal items.',
                'Evening' => 'End your trip by attending a local cultural performance or festival in one of the villages. If your visit coincides with a local festival, you can witness traditional dances, music, and ceremonial events.',
            ],
            'GoLokal Offerings' => [
                'Guided Tours' => 'Expert guides offer deep insights into the Minangkabau cultural complex, traditional houses, and royal palaces, providing historical and cultural context at every stop.',
                'Transportation Arrangements' => 'Seamless transportation between major heritage sites such as Kampung Pelegong, Sri Menanti Royal Museum, and Rembau Crystal, ensuring you have a smooth journey through the state’s rich history.',
                'Dining Recommendations' => 'Curated dining options featuring Negeri Sembilan’s famous dishes like Masak Lemak Cili Api, Rendang, and Daging Salai at top traditional eateries.',
                'Accommodation Suggestions' => 'Recommendations for homestays or hotels that offer an authentic experience, such as staying in a traditional Malay house or nearby heritage sites.',
                'Custom Itinerary Flexibility' => 'Options to adjust the itinerary for personalized experiences, with the ability to include additional stops or deeper cultural activities based on individual preferences.',
            ],
        ],

        'Adventure' => [
            'Day 1' => [
                'Title' => 'Hiking and Camping in Gunung Angsi',
                'Morning' => 'Start your day with a hike up Gunung Angsi, one of the highest peaks in Negeri Sembilan. The trail offers a moderate challenge for adventurers, with rewarding panoramic views at the summit.',
                'Afternoon' => 'Take a break for a picnic at Ulu Bendul Recreational Park, which is nestled at the base of the mountain. Enjoy the freshwater streams and scenic beauty of the park.',
                'Evening' => 'If you’re in for more adventure, set up camp at Ulu Bendul or one of the designated camping spots near Gunung Angsi for an overnight stay in the great outdoors. For dinner, GoLokal recommends trying Daging Salai Masak Lemak Cili Api (smoked meat in spicy coconut milk), a local delicacy you can prepare at the campsite or enjoy at a nearby eatery.',
            ],
            'Day 2' => [
                'Title' => 'Beach and Water Sports in Port Dickson',
                'Morning' => 'Head to Port Dickson for a day filled with water activities. Spend your morning at Blue Lagoon, where you can swim, snorkel, and enjoy the clear waters.',
                'Afternoon' => 'For lunch, enjoy fresh seafood at a beachfront restaurant. GoLokal recommends Ikan Bakar (grilled fish) or Sotong Goreng (fried squid) with rice, prepared in traditional Negeri Sembilan style.',
                'Evening' => 'Continue your water sports adventure with jet skiing, banana boating, or kayaking at Pantai Saujana. Wrap up your evening by relaxing on the beach, watching the sunset over the Straits of Malacca.',
            ],
            'Day 3' => [
                'Title' => 'ATV and Adventure Sports at Extreme Park Port Dickson',
                'Morning' => 'Begin your day with adrenaline-pumping activities at Extreme Park Port Dickson. Try ATV riding through rugged trails, or explore other activities such as paintball and go-karting.',
                'Afternoon' => 'Take a short break for lunch at a nearby restaurant, where you can try Nasi Goreng Kampung (village-style fried rice) and a refreshing Coconut Shake to refuel for the afternoon.',
                'Evening' => 'End your adventure-filled day with a leisurely walk along Tanjung Tuan Forest Reserve. This area offers beautiful hiking trails, bird-watching opportunities, and a chance to visit the historic Cape Rachado Lighthouse.',
            ],
            'GoLokal Offerings' => [
                'Guided Tours' => 'Skilled adventure guides provide assistance for activities such as hiking, ATV rides, and water sports to ensure safety and a memorable experience.',
                'Transportation Arrangements' => 'GoLokal offers convenient transfers between adventure sites such as Gunung Angsi, Port Dickson, and Extreme Park for a smooth journey throughout the itinerary.',
                'Dining Recommendations' => 'A curated list of top local eateries offering Negeri Sembilan specialties such as Daging Salai Masak Lemak, Ikan Bakar, and Nasi Goreng Kampung.',
                'Accommodation Suggestions' => 'Camping options at Ulu Bendul and nearby hotels in Port Dickson for those seeking a mix of adventure and relaxation.',
                'Custom Itinerary Flexibility' => 'Personalize your itinerary to include additional adventure activities, extra time for beach relaxation, or hiking trails based on your preferences.',
            ],
        ],
    ],


    'Pahang' => [
        'Top Attractions' => [
            'Day 1' => [
                'Title' => 'Genting Highlands Adventure and Entertainment',
                'Morning' => 'Kick off your day with a scenic drive to Genting Highlands, a popular hill resort known for its cool weather and entertainment options.',
                'Afternoon' => 'Spend the afternoon enjoying the various theme parks at Genting, such as Skytropolis or SnowWorld. You can also try your luck at the casino or explore the SkyAvenue shopping mall.',
                'Evening' => 'Dine at one of Genting Highlands’ top restaurants. GoLokal recommends trying Steamboat or Hot Pot for dinner, ideal for the cool highland climate. These restaurants often serve fresh local produce with flavorful broths.',
            ],
            'Day 2' => [
                'Title' => 'Explore the Scenic Cameron Highlands',
                'Morning' => 'Head to Cameron Highlands, famous for its tea plantations and cool, misty weather. Start your day with a visit to the Boh Tea Plantation for a tour of the tea processing facility and enjoy a cup of freshly brewed tea with stunning hilltop views.',
                'Afternoon' => 'Visit the Strawberry Farms and Lavender Gardens to pick your own strawberries or enjoy lavender-infused products. For lunch, stop at a local café and enjoy Scones with Cream and Jam, a highland specialty.',
                'Evening' => 'For dinner, savor Nasi Lemak or Cameron Highlands Steamboat in one of the restaurants featuring farm-fresh vegetables. Don’t forget to try local Tea Ice Cream as a sweet treat to end your day.',
            ],
            'Day 3' => [
                'Title' => 'Jungle Trekking at Taman Negara National Park',
                'Morning' => 'Begin your adventure at Taman Negara, one of the world’s oldest rainforests. Go on a jungle trek through the lush greenery, or try the famous canopy walk, where you’ll get an aerial view of the forest.',
                'Afternoon' => 'After your trek, take a river cruise to explore the wildlife and natural beauty of the park. You might spot various animals, from monkeys to exotic birds.',
                'Evening' => 'Enjoy a traditional Malay meal for dinner, including dishes like Ikan Patin Masak Tempoyak (river catfish cooked in durian paste) or Rendang Tok (slow-cooked beef with coconut and spices) in a nearby restaurant.',
            ],

            'GoLokal Offerings' => [
                'Guided Tours' => 'Professional guides offer deep insights during your visit to attractions like Taman Negara and Cameron Highlands, providing history and cultural context.',
                'Transportation Arrangements' => 'Convenient transfers between Pahang’s top attractions such as Genting Highlands, Cameron Highlands, and Taman Negara for a seamless experience.',
                'Dining Recommendations' => 'A curated list of eateries offering Pahang specialties like Nasi Lemak, Steamboat, and local farm-to-table dishes.',
                'Accommodation Suggestions' => 'Stay in luxury resorts at Genting Highlands, cozy inns in Cameron Highlands, or nature lodges near Taman Negara for a range of experiences.',
                'Custom Itinerary Flexibility' => 'Personalize your adventure with options to include additional activities such as extended jungle trekking, more time exploring farms, or visiting additional nearby attractions.',
            ],
        ],

        'Cultural Heritage' => [
            'Day 1' => [
                'Title' => 'Exploring Pahang’s Royal History in Pekan',
                'Morning' => 'Begin your cultural journey with a visit to the Sultan Abu Bakar Museum in Pekan. Explore the royal regalia, historical artifacts, and traditional items that offer insight into the royal heritage of the Sultanate of Pahang.',
                'Afternoon' => 'Walk around Pekan Royal Town, which features historical architecture, palaces, and beautiful mosques. Don’t miss a visit to the Masjid Sultan Ahmad Shah for its stunning Islamic architecture.',
                'Evening' => 'For dinner, GoLokal recommends enjoying a traditional Pahang meal, such as Ikan Patin Masak Tempoyak (catfish in durian paste) and Nasi Kerabu (herb-infused rice) at a local restaurant in Pekan.',
            ],
            'Day 2' => [
                'Title' => 'Discovering Villages and Handicrafts in Kuantan',
                'Morning' => 'Head to Kampung Budu, a historical village known for its traditional wooden houses and the legacy of local heroes. Learn about the history of the British colonial era and how it shaped the village.',
                'Afternoon' => 'Explore Kuantan Chinese Temple, a significant cultural and religious site reflecting the influence of the Chinese community in Pahang. Afterward, visit handicraft workshops in Kuantan, where you can witness artisans creating batik and other traditional crafts.',
                'Evening' => 'Enjoy a seafood dinner near Kuantan’s coast, where dishes like Ikan Bakar (grilled fish) and Sotong Goreng (fried squid) are local favorites, accompanied by a refreshing Coconut Shake.',
            ],
            'Day 3' => [
                'Title' => 'Exploring Indigenous Cultures in Cameron Highlands',
                'Morning' => 'Travel to Cameron Highlands to learn about the Orang Asli (Indigenous) communities. Visit an Orang Asli village to discover their traditional lifestyle, customs, and survival skills, such as hunting and making blowpipes.',
                'Afternoon' => 'Explore the Lurah Bilut Settlement, Malaysia’s first FELDA settlement, symbolizing the beginning of agricultural and land development efforts. Learn about the impact this has had on the state’s history and economy.',
                'Evening' => 'End your day with a warm meal featuring Steamboat or Hot Pot in the highlands, using fresh local vegetables and meat to warm up after a day of exploration.',
            ],

            'GoLokal Offerings' => [
                'Guided Tours' => 'Expert local guides will accompany you through key cultural sites such as the Sultan Abu Bakar Museum, Orang Asli villages, and Pekan Royal Town, providing in-depth historical context.',
                'Transportation Arrangements' => 'Convenient transfers between Pekan, Kuantan, and Cameron Highlands to allow for a comfortable journey between Pahang’s rich cultural attractions.',
                'Dining Recommendations' => 'GoLokal offers recommendations for Pahang’s signature dishes like Ikan Patin Tempoyak, Nasi Kerabu, and Ikan Bakar to give you a full cultural and culinary experience.',
                'Accommodation Suggestions' => 'Stay in heritage hotels in Pekan or local inns in Cameron Highlands to enhance your cultural experience, with proximity to key attractions.',
                'Custom Itinerary Flexibility' => 'Personalize your itinerary to include more time in traditional villages, cultural festivals, or additional visits to local handicraft markets, depending on your interests.',
            ],
        ],

        'Adventure' => [
            'Day 1' => [
                'Title' => 'Jungle Trekking and Canopy Walk at Taman Negara',
                'Morning' => 'Begin your adventure at Taman Negara, one of the oldest rainforests in the world. Start with an exhilarating jungle trekking experience, where you can spot diverse wildlife and explore the rich biodiversity of the rainforest.',
                'Afternoon' => 'Continue your day with the Canopy Walk, one of the longest suspension bridges in Southeast Asia. Enjoy a bird’s eye view of the forest and its towering trees.',
                'Evening' => 'For dinner, GoLokal recommends trying local Pahang dishes such as Ikan Patin Tempoyak (catfish cooked with durian paste) or Gulai Asam Rong at a nearby traditional restaurant.',
            ],
            'Day 2' => [
                'Title' => 'Hiking and Camping in Fraser’s Hill',
                'Morning' => 'Head to Fraser’s Hill, a serene hill station perfect for hiking enthusiasts. Explore the scenic trails with a guide, where you’ll encounter rare birds and unique flora, making it ideal for bird-watching and nature photography.',
                'Afternoon' => 'Set up camp in one of the designated campsites and enjoy the cool, misty air. Spend the rest of the afternoon hiking along additional trails or taking in the colonial charm of the area.',
                'Evening' => 'Prepare a campsite dinner or enjoy a warm meal at a hilltop café. GoLokal recommends savoring a traditional Steamboat or Hot Pot, which is a perfect fit for the cool weather at Fraser’s Hill.',
            ],
            'Day 3' => [
                'Title' => 'White-Water Rafting at Jeram Besu',
                'Morning' => 'Embark on a thrilling white-water rafting adventure at Jeram Besu, one of Pahang’s premier spots for rafting. The rushing rapids provide an exhilarating challenge for thrill-seekers.',
                'Afternoon' => 'After your rafting adventure, enjoy a local lunch at one of the riverside cafés. GoLokal recommends dishes such as Nasi Goreng Kampung (village-style fried rice) with Ayam Goreng Berempah (spiced fried chicken).',
                'Evening' => 'Wrap up your adventure-filled trip with a relaxing evening along the river, where you can unwind and reflect on the day’s excitement.',
            ],
            'GoLokal Offerings' => [
                'Guided Tours' => 'Expert local guides provide safety briefings and guidance for activities like jungle trekking, canopy walking, and white-water rafting, ensuring an enjoyable and secure experience.',
                'Transportation Arrangements' => 'Convenient transfers between key adventure spots such as Taman Negara, Fraser’s Hill, and Jeram Besu, allowing for a hassle-free trip.',
                'Dining Recommendations' => 'Curated lists of eateries offering Pahang’s local dishes, such as Ikan Patin Tempoyak, Gulai Asam Rong, and hearty Steamboat for a full culinary experience.',
                'Accommodation Suggestions' => 'Options include comfortable nature lodges near Taman Negara, campsites at Fraser’s Hill, and riverside inns near Jeram Besu, catering to different levels of adventure and relaxation.',
                'Custom Itinerary Flexibility' => 'Personalize your adventure by extending your stay at any of the locations or adding more outdoor activities such as bird-watching, caving, or extended hiking trails.',
            ],
        ],
    ],

    'Perak' => [
        'Top Attractions' => [
            'Day 1' => [
                'Title' => 'Exploring Ipoh’s Old Town and Colonial Architecture',
                'Morning' => 'Start your day by walking through Ipoh Old Town, where you can admire the city’s colonial architecture, vibrant street art, and historical landmarks.',
                'Afternoon' => 'Stop by a local kopitiam (traditional coffee shop) and try the famous Ipoh White Coffee along with some local dishes such as Nasi Ganja (aromatic rice with fried chicken) or Hor Hee (fish ball noodles).',
                'Evening' => 'Continue your exploration by visiting the Perak Cave Temple, a majestic cave temple set within limestone hills with stunning views of the city. End your evening with local Chee Cheong Fun (rice noodle rolls) and Tau Fu Fah (soybean pudding).',
            ],
            'Day 2' => [
                'Title' => 'History and Fun at Kellie’s Castle and Lost World of Tambun',
                'Morning' => 'Begin the day with a visit to the mysterious Kellie’s Castle, an unfinished mansion known for its Scottish architecture and ghostly legends.',
                'Afternoon' => 'For lunch, head to a nearby café and enjoy a local favorite like Mee Kari (curry noodles) or Ayam Goreng Berempah (spiced fried chicken). After lunch, head to the Lost World of Tambun, a family-friendly theme park featuring natural hot springs, water rides, and limestone attractions.',
                'Evening' => 'End the day by relaxing at the hot springs or indulging in some street food at the night market, with dishes such as Popiah (spring rolls) and Rojak Buah (fruit salad).',
            ],
            'Day 3' => [
                'Title' => 'A Royal Tour of Kuala Kangsar',
                'Morning' => 'Travel to the Royal Town of Kuala Kangsar, home to historical sites and royal architecture. Start by visiting the grand Ubudiah Mosque, one of Malaysia’s most beautiful mosques, known for its golden dome and intricate design.',
                'Afternoon' => 'Explore the Sultan Azlan Shah Gallery, where you’ll learn about the royal family’s history. For lunch, try Laksa Kuala Kangsar, a local variation of the famous laksa dish, at a popular local eatery.',
                'Evening' => 'End your day with a relaxing stroll along the Perak River, taking in the royal town’s charm before returning for a dinner of traditional Nasi Kerabu (blue herb-infused rice with side dishes) at a local restaurant.',
            ],
            'GoLokal Offerings' => [
                'Guided Tours' => 'Join knowledgeable local guides who will offer insights into the history and cultural significance of each attraction, such as Ipoh Old Town’s colonial past, Kellie’s Castle’s ghostly legends, and the royal history of Kuala Kangsar.',
                'Transportation Arrangements' => 'GoLokal will arrange seamless transportation between attractions, including transfers from Ipoh to Kuala Kangsar and the Lost World of Tambun.',
                'Dining Recommendations' => 'Curated lists of local eateries offering Perak’s iconic dishes like Ipoh White Coffee, Laksa Kuala Kangsar, and Nasi Kerabu for an authentic culinary experience.',
                'Accommodation Suggestions' => 'Stay in boutique hotels in Ipoh’s Old Town or comfortable resorts near the Lost World of Tambun for a blend of historical charm and modern convenience.',
                'Custom Itinerary Flexibility' => 'Personalize your itinerary by adding stops at additional attractions such as Gua Tempurung for caving, Royal Belum Rainforest for nature lovers, or Pangkor Island for a beach retreat.',
            ],
        ],

        'Cultural Heritage' => [
            'Day 1' => [
                'Title' => 'Exploring Ipoh’s Heritage Trail and Historical Buildings',
                'Morning' => 'Start your cultural journey in Ipoh by visiting the famous Ipoh Town Hall, a symbol of the city’s British colonial past. Then head to Birch Memorial Clock Tower, which commemorates the first British Resident of Perak, reflecting the state’s colonial history.',
                'Afternoon' => 'Explore the bustling Concubine Lane, which was once home to miners and their mistresses. It’s now a vibrant street filled with shops, cafes, and cultural attractions. For lunch, enjoy some local delicacies like Ipoh Hor Fun (rice noodles) or Nasi Ganja at a nearby eatery.',
                'Evening' => 'Visit the Ipoh Railway Station, often referred to as the "Taj Mahal of Ipoh." Admire the grand colonial architecture before heading to a restaurant for dinner, where you can savor Tau Fu Fah (soybean pudding) and White Coffee at a traditional kopitiam.',
            ],
            'Day 2' => [
                'Title' => 'Perak Museum and Nature in Taiping',
                'Morning' => 'Begin your day in Taiping by exploring the Perak Museum, Malaysia’s oldest museum. It offers exhibits on ethnology, zoology, and anthropology, giving you an in-depth understanding of Perak’s rich cultural and natural history.',
                'Afternoon' => 'Take a leisurely walk through the serene Taiping Lake Gardens, known for its lush greenery, scenic lakes, and historical rain trees. Stop by a local café for lunch, where GoLokal recommends trying Mee Rebus or Char Kuey Teow.',
                'Evening' => 'End your day with a visit to Taiping Zoo, Malaysia’s oldest zoo, where you can explore a variety of wildlife species in a natural rainforest setting. For dinner, head to a nearby night market and try Popiah (spring rolls) or Cendol (sweet dessert).',
            ],
            'Day 3' => [
                'Title' => 'Royal Heritage in Kuala Kangsar',
                'Morning' => 'Travel to the Royal Town of Kuala Kangsar, where you’ll visit the beautiful Ubudiah Mosque, an iconic mosque with a golden dome that’s considered one of Malaysia’s most beautiful architectural landmarks.',
                'Afternoon' => 'Explore the Istana Kenangan (Palace of Memories), a historical wooden palace built without nails. Learn about the royal family’s history and the unique architectural design. For lunch, enjoy the famous Laksa Kuala Kangsar, a savory noodle dish.',
                'Evening' => 'Before concluding your trip, visit the Kuala Kangsar Royal Gallery, which houses royal regalia, historical artifacts, and records of the state’s royal family. End the day with a traditional Nasi Kerabu meal at a local restaurant.',
            ],
            'GoLokal Offerings' => [
                'Guided Tours' => 'Knowledgeable local guides will accompany you through Ipoh’s heritage sites, the Perak Museum, and Kuala Kangsar’s royal landmarks, offering historical insights and cultural context.',
                'Transportation Arrangements' => 'Seamless transportation between Ipoh, Taiping, and Kuala Kangsar ensures a smooth and comfortable journey across Perak’s cultural attractions.',
                'Dining Recommendations' => 'GoLokal offers curated dining recommendations featuring Perak’s famous dishes, such as Ipoh Hor Fun, Mee Rebus, Laksa Kuala Kangsar, and Nasi Kerabu.',
                'Accommodation Suggestions' => 'Stay in heritage hotels in Ipoh’s Old Town, comfortable inns near Taiping Lake Gardens, or royal-inspired accommodations in Kuala Kangsar for an immersive experience.',
                'Custom Itinerary Flexibility' => 'Personalize your itinerary by adding visits to additional heritage sites like the Leaning Tower of Teluk Intan, Sam Poh Tong Temple, or Gua Tempurung for caving and nature exploration.',
            ],
        ],

        'Adventure' => [
            'Day 1' => [
                'Title' => 'Caving Adventure at Gua Tempurung',
                'Morning' => 'Begin your adventure with an exhilarating exploration of Gua Tempurung, one of Peninsular Malaysia’s largest limestone caves. Traverse through its stunning stalactites, stalagmites, and underground rivers for a thrilling caving experience.',
                'Afternoon' => 'After your caving adventure, take a break for lunch at a local restaurant in Gopeng, where GoLokal recommends trying Mee Kari Gopeng (curry noodles) or Nasi Lemak Rendang (coconut rice with spiced beef).',
                'Evening' => 'End the day with some relaxation and light hiking around Gopeng, soaking in the natural beauty of the surrounding limestone hills and rivers. For dinner, enjoy a warm meal of Ikan Bakar (grilled fish) by the riverside.',
            ],
            'Day 2' => [
                'Title' => 'River Tubing and White-Water Rafting in Gopeng',
                'Morning' => 'Start your morning with an adrenaline-pumping river tubing session down the Kampar River, where you’ll navigate gentle rapids and take in the stunning natural surroundings.',
                'Afternoon' => 'After a quick lunch, get ready for an adventurous afternoon of white-water rafting in Gopeng. Navigate through the thrilling rapids of the Kampar River under the guidance of experienced instructors.',
                'Evening' => 'Wrap up your action-packed day with a hearty local dinner of Nasi Goreng Kampung (village-style fried rice) or Sambal Udang Petai (prawns with spicy sambal and stink beans), paired with refreshing local drinks like Coconut Shake.',
            ],
            'Day 3' => [
                'Title' => 'Paragliding Adventure at Bukit Kinding',
                'Morning' => 'Experience the thrill of paragliding at Bukit Kinding, where you’ll glide over lush landscapes and enjoy breathtaking aerial views of Perak’s beautiful countryside.',
                'Afternoon' => 'Recharge with a local lunch featuring Laksa Perak (spicy noodle soup) or Rendang Ayam (spiced chicken) at a nearby restaurant before continuing your adventure.',
                'Evening' => 'End your adventure-filled trip by relaxing at the hot springs of Sungai Klah, where you can soak in natural hot spring pools and enjoy the serene atmosphere. For dinner, GoLokal recommends sampling Gulai Tempoyak Ikan Patin (fish cooked in durian paste) or Ayam Goreng Berempah (spiced fried chicken).',
            ],
            'GoLokal Offerings' => [
                'Guided Tours' => 'GoLokal provides expert guides to assist with caving in Gua Tempurung, white-water rafting in Gopeng, and paragliding at Bukit Kinding, ensuring both safety and enjoyment.',
                'Transportation Arrangements' => 'Convenient transportation is arranged between adventure sites such as Gopeng, Bukit Kinding, and Sungai Klah to offer a smooth and hassle-free journey.',
                'Dining Recommendations' => 'Curated lists of local eateries offer traditional Perak dishes such as Mee Kari Gopeng, Laksa Perak, and Gulai Tempoyak Ikan Patin, giving you an authentic taste of the state’s cuisine.',
                'Accommodation Suggestions' => 'Stay in nature lodges near Gua Tempurung or cozy guesthouses near Bukit Kinding to be close to your adventure activities while enjoying the natural scenery.',
                'Custom Itinerary Flexibility' => 'Personalize your itinerary with options for more activities like hiking, bird-watching, or adding a beach day at Pangkor Island for relaxation.',
            ],
        ],
    ],

    'Perlis' => [
        'Top Attractions' => [
            'Day 1' => [
                'Title' => 'Exploring Perlis’ Cultural and Natural Heritage',
                'Morning' => 'Start your day with a visit to Kota Kayang Museum, where you’ll learn about the history and culture of Perlis through its exhibits on archaeology, royal artifacts, and traditional customs.',
                'Afternoon' => 'Head to Perlis State Park, a nature reserve known for its limestone hills, caves, and diverse wildlife. Take a guided hike or enjoy bird watching while exploring the park’s beautiful trails.',
                'Evening' => 'For dinner, enjoy traditional Laksa Perlis (a local noodle dish with a tangy fish-based broth) or Ikan Bakar (grilled fish) at a local restaurant, paired with refreshing Air Janda Pulang (a local Perlis drink).',
            ],
            'Day 2' => [
                'Title' => 'Wang Kelian Market and Scenic Lake Views',
                'Morning' => 'Begin your day with a visit to the Wang Kelian Sunday Market, a bustling border market where you can browse for local produce, handicrafts, and unique items from Thailand and Malaysia.',
                'Afternoon' => 'After the market, head to Timah Tasoh Lake, a serene man-made lake surrounded by hills. Take a boat ride, enjoy bird watching, or have a picnic by the lakeside while taking in the scenic views.',
                'Evening' => 'For dinner, try Nasi Ulam Perlis (rice with herbs and vegetables) or Kerabu Mangga (spicy mango salad) at a nearby restaurant. These dishes reflect the refreshing flavors of Perlis cuisine.',
            ],
            'Day 3' => [
                'Title' => 'Cave Exploration at Gua Kelam',
                'Morning' => 'Spend your last day at Gua Kelam Recreational Park, home to one of Perlis’ most famous limestone caves. Walk through the 370-meter long cave via the wooden walkway while admiring the cave’s natural formations.',
                'Afternoon' => 'After exploring Gua Kelam, visit Tasik Melati, a small but scenic lake surrounded by floating islands. Enjoy a peaceful walk or a picnic by the water, soaking in the natural beauty of the area.',
                'Evening' => 'End your trip with a special dinner at a local restaurant. GoLokal recommends Rendang Tok Perlis (slow-cooked beef rendang) or Kuih Koci (a sweet glutinous rice dessert) to wrap up your culinary experience in Perlis.',
            ],
            'GoLokal Offerings' => [
                'Guided Tours' => 'GoLokal offers expert local guides who will provide in-depth insights during your visits to cultural sites like Kota Kayang Museum and natural wonders like Gua Kelam and Perlis State Park.',
                'Transportation Arrangements' => 'Seamless transfers are provided between key attractions such as Perlis State Park, Wang Kelian, and Timah Tasoh Lake to make your journey through Perlis comfortable and hassle-free.',
                'Dining Recommendations' => 'Curated dining options include local eateries that serve Perlis specialties such as Laksa Perlis, Nasi Ulam Perlis, and Rendang Tok Perlis, giving you a full taste of Perlis’ unique cuisine.',
                'Accommodation Suggestions' => 'Stay at charming guesthouses or eco-lodges near natural attractions like Timah Tasoh Lake or Perlis State Park for a peaceful retreat close to nature.',
                'Custom Itinerary Flexibility' => 'Personalize your itinerary with options to explore additional sites like Perlis Vineyard, known for its local grapes and wine, or add rock climbing adventures at Bukit Keteri.',
            ],
        ],

        'Cultural Heritage' => [
            'Day 1' => [
                'Title' => 'Exploring the Royal History of Perlis',
                'Morning' => 'Start your journey at the Arau Royal Palace, the residence of the Raja of Perlis. Learn about the state’s royal history, its legacy, and its role in Malaysian heritage. Marvel at the palace’s impressive architecture and royal significance.',
                'Afternoon' => 'Visit the Syed Hussein Royal Mausoleum, which is the final resting place of Perlis’ royal figures. It offers a deep dive into the royal traditions and history of the region.',
                'Evening' => 'End your day with a traditional meal of Rendang Tok Perlis (slow-cooked beef rendang) or Laksa Perlis (spicy noodle dish) at a local restaurant in Arau, savoring the rich flavors of Perlis cuisine.',
            ],
            'Day 2' => [
                'Title' => 'Village Life and Local Artisans',
                'Morning' => 'Head to a traditional Malay village in Perlis where you can engage with local artisans. Learn about the traditional crafts, such as batik making, wood carving, and songket weaving. You can also witness how local handicrafts are made and even try making some yourself.',
                'Afternoon' => 'Explore Kota Kayang Museum, where you’ll gain further insight into the state’s history, archaeology, and royal lineage. Afterward, visit a local café and enjoy Nasi Ulam Perlis (rice mixed with herbs) or Kerabu Mangga (mango salad).',
                'Evening' => 'Relax with a peaceful dinner near Timah Tasoh Lake, where you can try Ikan Bakar (grilled fish) or Sambal Udang (spicy prawn sambal), while enjoying the serene natural surroundings.',
            ],
            'Day 3' => [
                'Title' => 'Traditional Festivals and Cultural Performances',
                'Morning' => 'Attend a local cultural festival in Perlis, where you can experience the vibrant traditional dance and music. Festivals such as Tarian Canggung (a traditional dance unique to Perlis) often take place during special occasions, offering a glimpse into the state’s cultural heritage.',
                'Afternoon' => 'Visit the Wang Kelian Sunday Market, where you can explore a bustling cross-border market, shop for local products, and experience the unique cultural exchange between Malaysia and Thailand.',
                'Evening' => 'For your final dinner, GoLokal suggests trying Kuih Koci (sweet glutinous rice dessert) and Nasi Kandar (rice with various curries) at a popular local eatery, concluding your Perlis journey with local flavors.',
            ],
            'GoLokal Offerings' => [
                'Guided Tours' => 'GoLokal offers local guides to provide deeper insights into the Arau Royal Palace, traditional villages, and cultural festivals, making your trip educational and immersive.',
                'Transportation Arrangements' => 'Enjoy convenient transportation between historical sites, villages, and local markets to ensure a smooth and comfortable journey throughout Perlis.',
                'Dining Recommendations' => 'A curated list of local dining experiences featuring Perlis specialties like Rendang Tok, Laksa Perlis, and Ikan Bakar, ensuring you savor the rich local cuisine.',
                'Accommodation Suggestions' => 'Stay in cozy guesthouses near Arau or traditional village homestays for an authentic cultural experience during your stay in Perlis.',
                'Custom Itinerary Flexibility' => 'Customize your trip with more cultural experiences such as learning traditional Perlis dance or attending additional festivals depending on the time of year you visit.',
            ],
        ],


        'Adventure' => [
            'Day 1' => [
                'Title' => 'Caving and River Exploration at Gua Kelam',
                'Morning' => 'Start your day by exploring Gua Kelam, one of the most famous limestone caves in Malaysia. Walk through the cave along the underground river, taking in the stunning natural formations such as stalactites and stalagmites.',
                'Afternoon' => 'After your caving adventure, enjoy a picnic at a nearby spot with local delicacies like Nasi Goreng Kampung (village-style fried rice) and Roti Canai (flaky flatbread) with curry.',
                'Evening' => 'For dinner, try traditional Laksa Perlis (a spicy noodle dish) or Ikan Bakar (grilled fish) at a local restaurant in Kaki Bukit, capping off your day with Perlis flavors.',
            ],
            'Day 2' => [
                'Title' => 'Hiking and Bird-Watching in Perlis State Park',
                'Morning' => 'Head to Perlis State Park for a day of hiking and bird-watching. Explore the lush forest trails, limestone hills, and caves while spotting diverse wildlife and bird species.',
                'Afternoon' => 'Take a break for lunch at a nearby café, where GoLokal recommends trying Mee Kari (curry noodles) or Sambal Udang Petai (spicy prawns with stink beans) for a flavorful local meal.',
                'Evening' => 'Return to your accommodation or relax with an outdoor dinner by the lake at Timah Tasoh, where you can enjoy Nasi Kerabu (herb-infused blue rice) and Ayam Percik (grilled chicken with coconut gravy).',
            ],
            'Day 3' => [
                'Title' => 'ATV Rides Around Timah Tasoh Lake',
                'Morning' => 'Get ready for an exciting day of ATV riding around Timah Tasoh Lake. Experience the thrill of riding through scenic trails with views of the lake and surrounding mountains.',
                'Afternoon' => 'Recharge with a local lunch featuring Nasi Ulam Perlis (herb rice) or Rendang Tok Perlis (slow-cooked beef rendang) at a nearby restaurant before continuing your adventure.',
                'Evening' => 'End your adventure-filled trip with a boat ride on Kuala Perlis, enjoying fresh seafood such as Udang Galah (giant river prawns) or Ketam Masak Lemak (crabs in coconut milk) while watching the sunset over the coastal town.',
            ],

            'GoLokal Offerings' => [
                'Guided Tours' => 'GoLokal offers guided tours for caving at Gua Kelam, bird-watching in Perlis State Park, and ATV riding around Timah Tasoh, ensuring a safe and enjoyable experience.',
                'Transportation Arrangements' => 'Convenient transfers between adventure sites such as Perlis State Park, Gua Kelam, and Timah Tasoh Lake for a seamless and worry-free journey.',
                'Dining Recommendations' => 'Curated dining recommendations featuring local Perlis cuisine such as Laksa Perlis, Mee Kari, and Nasi Ulam Perlis to provide a full culinary experience.',
                'Accommodation Suggestions' => 'Stay at cozy lodges near Timah Tasoh Lake or guesthouses close to Perlis State Park for easy access to adventure activities and natural surroundings.',
                'Custom Itinerary Flexibility' => 'Personalize your adventure by adding more activities like kayaking at Timah Tasoh Lake or rock climbing at Bukit Keteri, depending on your interests.',
            ],
        ],
    ],

    'Penang' => [
        'Top Attractions' => [
            'Day 1' => [
                'Title' => 'Exploring George Town’s Heritage and Culture',
                'Morning' => 'Begin with a walking tour of George Town, a UNESCO World Heritage Site. Discover its historical architecture, vibrant street art, and multicultural heritage, as you stroll through the charming streets and alleys.',
                'Afternoon' => 'Visit Clan Jetties, a traditional waterfront village with stilt houses offering a glimpse into Penang’s Chinese heritage. For lunch, enjoy Char Kuey Teow (stir-fried noodles with prawns) or Asam Laksa (spicy and tangy fish soup) at a nearby food stall.',
                'Evening' => 'End your day at Fort Cornwallis, learning about Penang’s colonial history with guided tours and performances. Wrap up with a local dinner, savoring dishes like Nasi Kandar (rice with various curries) at a popular restaurant.',
            ],
            'Day 2' => [
                'Title' => 'Natural Beauty and Spiritual Landmarks',
                'Morning' => 'Head to Penang Hill and enjoy the stunning views of George Town and the surrounding area. Take the famous funicular railway to the top for a scenic experience.',
                'Afternoon' => 'Visit Kek Lok Si Temple, one of Southeast Asia’s largest and most beautiful Buddhist temples. Explore its pagodas and shrines while taking in the panoramic views of Penang. Have lunch nearby, with GoLokal recommending Hainanese Chicken Rice or Mee Goreng Mamak (Indian-Muslim style fried noodles).',
                'Evening' => 'End the day with a relaxing visit to Penang Botanic Gardens, where you can unwind in a lush green setting surrounded by diverse plant species. For dinner, try Penang Hokkien Mee (spicy prawn noodle soup) at a local spot.',
            ],
            'Day 3' => [
                'Title' => 'Street Art, Food, and Local Attractions',
                'Morning' => 'Explore Penang’s famous street art in George Town. Visit murals and interactive installations that tell the story of Penang’s heritage and local life.',
                'Afternoon' => 'Embark on a culinary tour through Penang’s famous food streets. Sample delicacies like Rojak (fruit and vegetable salad), Lor Bak (five-spice pork rolls), and Chendol (iced dessert with coconut milk).',
                'Evening' => 'Conclude your trip with a visit to the Pinang Peranakan Mansion, a beautifully restored museum showcasing the lifestyle of the Peranakan Chinese community. For dinner, GoLokal suggests trying Poh Piah (spring rolls) and Kuih (traditional desserts) at a nearby café.',
            ],
            'GoLokal Offerings' => [
                'Guided Tours' => 'Local guides provide rich insights into George Town’s history, Penang Hill’s natural beauty, and the cultural significance of Kek Lok Si Temple, making your exploration informative and memorable.',
                'Transportation Arrangements' => 'Convenient transfers between major attractions, such as Penang Hill, Kek Lok Si Temple, and George Town’s street art locations, for a seamless experience.',
                'Dining Recommendations' => 'GoLokal offers curated dining recommendations featuring Penang’s must-try dishes, including Char Kuey Teow, Asam Laksa, and Penang Hokkien Mee, ensuring an authentic culinary adventure.',
                'Accommodation Suggestions' => 'Stay in boutique hotels in George Town for a heritage experience or near Penang Hill for a more tranquil setting, offering proximity to key attractions.',
                'Custom Itinerary Flexibility' => 'Customize your trip with additional visits to places like Entopia Butterfly Farm or ESCAPE Theme Park for family-friendly fun or Penang National Park for outdoor adventures.',
            ],
        ],

        'Cultural Heritage' => [
            'Day 1' => [
                'Title' => 'Exploring George Town’s Historical Sites',
                'Morning' => 'Start at the Pinang Peranakan Mansion, a beautifully restored museum showcasing the opulent lifestyle of the Straits Chinese community. Continue to the Khoo Kongsi Clan House for a glimpse into one of Penang’s most famous clan houses, known for its grand architecture and intricate carvings.',
                'Afternoon' => 'Visit the Cheong Fatt Tze Mansion (Blue Mansion), an iconic heritage building that reflects Penang’s colonial past. Enjoy lunch at a local hawker stall, with favorites like Char Kuey Teow (stir-fried noodles with prawns) and Asam Laksa (spicy and tangy fish soup).',
                'Evening' => 'Explore the George Town Street Art, an open-air gallery featuring murals and installations depicting Penang’s culture and history. End the day with a meal at a traditional restaurant, sampling Nasi Kandar (rice with various curries) and Roti Canai (flaky flatbread).',
            ],
            'Day 2' => [
                'Title' => 'Immersive Cultural Experiences',
                'Morning' => 'Join a traditional cooking class to learn how to make iconic Penang dishes such as Asam Laksa and Cendol (a sweet coconut milk dessert). Learn about the techniques and flavors that make Penang cuisine unique.',
                'Afternoon' => 'Participate in a Batik painting workshop or explore the art of Peranakan beading at a local cultural center. For lunch, try Mee Goreng Mamak (Indian-Muslim style fried noodles) in Little India.',
                'Evening' => 'Visit the Kek Lok Si Temple, one of the largest and most beautiful Buddhist temples in Southeast Asia, with views of the city at sunset. Dine nearby, enjoying dishes like Penang Hokkien Mee (spicy prawn noodle soup) and local desserts.',
            ],
            'Day 3' => [
                'Title' => 'Art Galleries and Cultural Centers',
                'Morning' => 'Tour Hin Bus Depot Art Centre and Penang State Art Gallery, where you can view contemporary and traditional Malaysian art that reflects the island’s cultural diversity.',
                'Afternoon' => 'Visit the Penang House of Music to explore Penang’s musical heritage. Then, stop by the Kapitan Keling Mosque, an iconic landmark representing Penang’s Indian-Muslim community. Have lunch with a taste of Lor Bak (five-spice pork rolls) and Rojak (fruit and vegetable salad).',
                'Evening' => 'Conclude your cultural exploration with a visit to the Penang Cultural Center for a performance of traditional Malay dance and music. End the day with a meal at a heritage café, sampling Kuih (traditional desserts) and Bubur Cha Cha (coconut milk dessert).',
            ],
            'GoLokal Offerings' => [
                'Guided Tours' => 'Expert local guides enhance your experience at historical sites like Khoo Kongsi, Kapitan Keling Mosque, and Penang House of Music, providing valuable context on Penang’s heritage.',
                'Transportation Arrangements' => 'Convenient transfers between George Town’s key historical sites, workshops, and cultural centers to ensure a seamless journey.',
                'Dining Recommendations' => 'Curated dining options that highlight Penang’s culinary heritage, featuring dishes like Char Kuey Teow, Asam Laksa, and Hokkien Mee for an authentic experience.',
                'Accommodation Suggestions' => 'Stay in boutique hotels near George Town’s heritage area or in converted colonial buildings for an immersive historical ambiance.',
                'Custom Itinerary Flexibility' => 'Customize your experience by adding more workshops, heritage site visits like St. George’s Church or Fort Cornwallis, or additional culinary experiences.',
            ],
        ],

        'Adventure' => [
            'Day 1' => [
                'Title' => 'Cycling Tour Around Penang Island',
                'Morning' => 'Start your adventure with a guided cycling tour around Penang Island. Begin at George Town, where you can explore scenic roads, coastal paths, and historic areas by bike.',
                'Afternoon' => 'Take a break at a local café and enjoy Penang favorites like Nasi Lemak (coconut rice with sambal) or Mee Goreng (fried noodles) before continuing your cycling route towards Penang National Park.',
                'Evening' => 'End the day with a visit to Penang Botanic Gardens for a relaxing stroll and spot some native flora and fauna. For dinner, try Penang Laksa and Char Kuey Teow (stir-fried flat noodles) at a local food stall.',
            ],
            'Day 2' => [
                'Title' => 'Thrills at Escape Theme Park',
                'Morning' => 'Head to Escape Theme Park for an action-packed day. Challenge yourself on zip-lining courses, obstacle courses, and climbing towers. Escape offers a variety of thrilling activities for all ages.',
                'Afternoon' => 'Take a lunch break at the park’s café, with GoLokal recommending snacks and local refreshments to keep you energized. Alternatively, enjoy nearby eateries that serve dishes like Curry Mee (noodles in curry soup) and Popiah (fresh spring rolls).',
                'Evening' => 'Wrap up the day with a visit to The Habitat on Penang Hill. Experience canopy walks and guided nature tours that offer breathtaking views of Penang’s lush rainforest. Have dinner nearby with dishes like Hokkien Mee (prawn noodle soup) to complete the day.',
            ],
            'Day 3' => [
                'Title' => 'Beach Day and Water Sports at Batu Ferringhi',
                'Morning' => 'Spend the day at Batu Ferringhi Beach for a range of water activities including snorkeling, jet skiing, and parasailing. Relax on the sandy shores and enjoy the scenic coastline.',
                'Afternoon' => 'For lunch, explore the beachfront food stalls offering Grilled Seafood, Rojak (fruit and vegetable salad), and refreshing Cendol (iced dessert with coconut milk).',
                'Evening' => 'Enjoy the evening at the Batu Ferringhi night market, where you can shop for souvenirs and sample street food like Satay (grilled meat skewers) and Kuih (traditional sweets).',
            ],
            'GoLokal Offerings' => [
                'Guided Tours' => 'GoLokal offers experienced guides for activities such as cycling tours around Penang Island, guided canopy walks at The Habitat, and snorkeling lessons at Batu Ferringhi Beach.',
                'Transportation Arrangements' => 'Seamless transfers between adventure sites like Escape Theme Park, Penang Hill, and Batu Ferringhi Beach for a hassle-free journey.',
                'Dining Recommendations' => 'A curated list of recommended eateries featuring Penang’s local dishes such as Char Kuey Teow, Penang Laksa, and Nasi Lemak to enhance your adventure experience.',
                'Accommodation Suggestions' => 'Stay near Batu Ferringhi for easy access to the beach or in the George Town area for its cultural charm and proximity to adventure sites.',
                'Custom Itinerary Flexibility' => 'Options to personalize your itinerary with additional activities, such as a visit to Entopia Butterfly Farm or Penang National Park for more nature exploration.',
            ],
        ],
    ],

    'Sabah' => [
        'Top Attractions' => [
            'Day 1' => [
                'Title' => 'Exploring Kota Kinabalu’s Cultural and Historical Landmarks',
                'Morning' => 'Begin with a tour of Kota Kinabalu City Mosque, also known as the “Floating Mosque,” renowned for its stunning architecture and views over a man-made lagoon.',
                'Afternoon' => 'Visit the Sabah State Museum to gain insight into Sabah’s rich heritage, indigenous cultures, and historical artifacts. Enjoy lunch at a nearby eatery with GoLokal recommending Nasi Lemak and Mee Goreng.',
                'Evening' => 'Stroll through Kota Kinabalu’s city center to explore markets and local shops, sampling street foods such as Lok Lok (skewered bites) and Kuih (traditional sweets) for dinner.',
            ],
            'Day 2' => [
                'Title' => 'Adventure at Mount Kinabalu and Kinabalu Park',
                'Morning' => 'Start early for Mount Kinabalu. Whether you’re climbing to the summit or exploring lower trails, you’ll be rewarded with spectacular views and a chance to witness unique flora.',
                'Afternoon' => 'Explore Kinabalu Park, Malaysia’s first UNESCO World Heritage site, known for its incredible biodiversity. Take a guided nature walk through the park’s trails. For lunch, try the park’s restaurant serving Sabah Vegetable Dishes and Laksa.',
                'Evening' => 'Relax at a nearby hot spring, such as Poring Hot Springs, to unwind after a day of adventure. Try local dishes like Hinava (Sabahan ceviche) and Soto (Bornean noodle soup) for dinner.',
            ],
            'Day 3' => [
                'Title' => 'Relaxing at Tunku Abdul Rahman Marine Park',
                'Morning' => 'Take a boat to Tunku Abdul Rahman Marine Park and spend the day island-hopping among its pristine islands like Manukan and Sapi. Enjoy activities like snorkeling, diving, and beach relaxation.',
                'Afternoon' => 'Savor a beachside picnic with local delicacies such as Grilled Fish, Sambal Udang (spicy prawn), and tropical fruits. Enjoy snorkeling or take a short hike for panoramic views.',
                'Evening' => 'Return to Kota Kinabalu and visit a seafood restaurant, famous for Sabah’s fresh seafood platters, to complete your Sabah experience.',
            ],
            'GoLokal Offerings' => [
                'Guided Tours' => 'Local guides enhance your experience at Kota Kinabalu City Mosque, Sabah State Museum, and Mount Kinabalu, providing deeper insights into Sabah’s culture and history.',
                'Transportation Arrangements' => 'Convenient transfers between major attractions, including Mount Kinabalu, Kinabalu Park, and Tunku Abdul Rahman Marine Park, for a seamless journey.',
                'Dining Recommendations' => 'Recommendations for local eateries and food stalls featuring unique Sabah dishes like Hinava, Soto, and fresh Seafood Platters.',
                'Accommodation Suggestions' => 'Stay in eco-lodges near Kinabalu Park or beach resorts around Kota Kinabalu to enhance your comfort and access to adventure activities.',
                'Custom Itinerary Flexibility' => 'Options to adjust the itinerary, such as adding a visit to Sepilok Orangutan Rehabilitation Centre or a cruise along Kinabatangan River for wildlife watching.',
            ],
        ],

        'Cultural Heritage' => [
            'Day 1' => [
                'Title' => 'Immersion into Indigenous Culture at Mari Mari Cultural Village',
                'Morning' => 'Start your cultural journey with a visit to Mari Mari Cultural Village. Here, experience the daily lives, customs, and practices of Sabah’s indigenous tribes including the Bajau, Murut, and Rungus communities.',
                'Afternoon' => 'Enjoy a traditional lunch at the village with dishes like Hinava (a fish salad), Ambuyat (sago-based dish), and Bosou (fermented fish or meat).',
                'Evening' => 'Conclude the day with a cultural dance performance at the village. For dinner, GoLokal recommends trying local cuisine at a nearby restaurant, featuring dishes like Linopot (rice in leaf wrap) and Sambal Terung (spicy eggplant).',
            ],
            'Day 2' => [
                'Title' => 'Handicraft and Heritage Tour in Kota Kinabalu',
                'Morning' => 'Begin with a visit to Kota Belud Tamu, a vibrant weekly market where artisans and farmers from various tribes gather. Shop for traditional handicrafts, beadwork, and woven items.',
                'Afternoon' => 'Head to the Sabah State Museum to gain a deeper understanding of Sabah’s history and cultural heritage. Break for lunch nearby and try Soto Makassar (spicy noodle soup) or Sup Tulang (bone soup).',
                'Evening' => 'Explore the Kota Kinabalu Handicraft Market in the evening, where you can purchase souvenirs and handcrafted goods. For dinner, try Nasi Kuning (yellow rice) and Ikan Bakar (grilled fish).',
            ],
            'Day 3' => [
                'Title' => 'Traditional Rungus Longhouse Experience in Kudat',
                'Morning' => 'Travel to Kudat to visit the Rungus Longhouse. Learn about the Rungus tribe’s communal way of life, their distinctive architecture, and how longhouses serve as both homes and community centers.',
                'Afternoon' => 'Join the locals in a traditional cooking class at the longhouse, learning to prepare authentic dishes like Tuhau (wild ginger salad) and Pinasakan (braised fish). Enjoy a meal with the Rungus community.',
                'Evening' => 'Return to Kota Kinabalu and conclude your cultural journey with a farewell dinner featuring Rendang Sabah and Tapai (fermented rice wine) for an authentic Sabahan dining experience.',
            ],
            'GoLokal Offerings' => [
                'Guided Tours' => 'Knowledgeable guides at Mari Mari Cultural Village, Kota Belud Tamu, and Rungus Longhouse offer insights into the daily lives, traditions, and history of Sabah’s indigenous tribes.',
                'Transportation Arrangements' => 'Convenient transportation between Kota Kinabalu, Kudat, and other key cultural sites, ensuring a smooth journey across Sabah.',
                'Dining Recommendations' => 'A curated list of local eateries and traditional dishes like Hinava, Linopot, and Ambuyat to complete your cultural experience.',
                'Accommodation Suggestions' => 'Stay in traditional lodgings or nearby eco-resorts for a full immersion in Sabah’s culture and natural surroundings.',
                'Custom Itinerary Flexibility' => 'Options to extend your visit with activities such as a trip to Bajau Laut Stilt Houses or the Gombunan Ceremonial Site for more cultural exploration.',
            ],
        ],

        'Adventure' => [
            'Day 1' => [
                'Title' => 'Underwater Exploration at Sipadan Island',
                'Morning' => 'Begin the day with a boat trip to Sipadan Island, a world-renowned diving spot. Dive into the crystal-clear waters to explore vibrant coral reefs and encounter diverse marine life, including turtles, reef sharks, and schools of fish.',
                'Afternoon' => 'Take a break on the island with a picnic lunch, featuring local favorites like Nasi Lemak (coconut rice with sambal and condiments) and Kuih Cincin (ring-shaped rice cake).',
                'Evening' => 'Return to the mainland and enjoy a seafood dinner at a recommended local restaurant, with options like Ikan Bakar (grilled fish) and Sabahan Fish Noodle Soup.',
            ],
            'Day 2' => [
                'Title' => 'Rafting Thrills at Kiulu River',
                'Morning' => 'Embark on an exhilarating white-water rafting adventure at the Kiulu River. Enjoy navigating through mild rapids, suitable for beginners and providing plenty of thrills while surrounded by lush tropical scenery.',
                'Afternoon' => 'After rafting, have a traditional lunch along the riverbank, featuring Linopot (rice wrapped in leaves) and Tuhau (wild ginger salad).',
                'Evening' => 'Return to Kota Kinabalu for a relaxing evening and try Soto Makassar (Indonesian-style beef soup) at a local restaurant recommended by GoLokal.',
            ],
            'Day 3' => [
                'Title' => 'Mount Kinabalu Climbing Adventure',
                'Morning' => 'Begin the early ascent of Mount Kinabalu, a challenging trek that offers spectacular views and the chance to see unique alpine flora. Climbing Mount Kinabalu is a strenuous but rewarding activity for adventurous travelers.',
                'Afternoon' => 'Enjoy a packed lunch on the trail, with Ambuyat (sago starch with dipping sauce) and Hinava (Sabahan raw fish salad), two traditional Sabahan dishes.',
                'Evening' => 'Descend and head back to the lodge for a farewell dinner with Sabahan delicacies such as Pinasakan (braised fish with tangy flavor) and Tapai (rice wine).',
            ],
            'GoLokal Offerings' => [
                'Guided Adventures' => 'Expert guides for diving at Sipadan, rafting at Kiulu River, and trekking up Mount Kinabalu, ensuring safety and enriching the experience with local knowledge.',
                'Transportation Arrangements' => 'Seamless transfers from Kota Kinabalu to key adventure sites like Sipadan Island, Kiulu River, and Kinabalu Park for a stress-free journey.',
                'Dining Recommendations' => 'Suggested dining spots featuring Sabahan dishes such as Hinava, Pinasakan, and Nasi Lemak to enhance the culinary experience.',
                'Accommodation Suggestions' => 'Stay options near adventure sites, including eco-lodges near Mount Kinabalu and beach resorts for easy access to diving.',
                'Custom Itinerary Flexibility' => 'Flexible itinerary options for additional activities like jungle trekking in Danum Valley or exploring the Tunku Abdul Rahman Marine Park.',
            ],
        ],
    ],

    'Sarawak' => [
        'Top Attractions' => [
            'Day 1' => [
                'Title' => 'Exploring Kuching City and Sarawak Museum',
                'Morning' => 'Start your journey in Kuching with a visit to the Kuching Waterfront. Enjoy a leisurely walk along the river and take in the scenic views of the Sarawak River and the iconic Darul Hana Bridge.',
                'Afternoon' => 'Head to the Sarawak Museum for an immersive experience into Sarawak’s cultural and natural history. Discover artifacts from indigenous tribes, colonial history, and local wildlife exhibits.',
                'Evening' => 'Dine at a local Kuching restaurant and try Laksa Sarawak (a spicy coconut-based noodle soup) and Kolo Mee (stir-fried noodles with minced meat and greens).',
            ],
            'Day 2' => [
                'Title' => 'Adventure in Bako National Park',
                'Morning' => 'Take a boat ride to Bako National Park, renowned for its diverse ecosystems, from mangrove swamps to lush rainforests. Enjoy jungle trekking to spot proboscis monkeys, wild boars, and unique plant species.',
                'Afternoon' => 'Have a picnic lunch in the park with local delicacies, including Mee Jawa (Javanese-style noodles) and Kuih Lapis (layered cake). Continue exploring the park’s trails, reaching the coastline for scenic cliff views.',
                'Evening' => 'Return to Kuching for a relaxed dinner featuring Ayam Pansuh (chicken cooked in bamboo) and Manok Pansoh (another traditional bamboo dish).',
            ],
            'Day 3' => [
                'Title' => 'Cultural Immersion at Sarawak Cultural Village',
                'Morning' => 'Visit the Sarawak Cultural Village, an open-air museum showcasing the traditional lifestyles of Sarawak’s indigenous groups. Explore traditional longhouses, cultural performances, and handicraft displays.',
                'Afternoon' => 'Participate in interactive sessions, including traditional crafts and cooking workshops to learn about Sarawak’s cultural heritage hands-on.',
                'Evening' => 'End your journey with a taste of Umai (raw fish salad) and Ikan Terubok Masin (salted fish), two iconic Sarawakian dishes, at a GoLokal-recommended restaurant before departing.',
            ],
            'GoLokal Offerings' => [
                'Guided Tours' => 'Experienced guides offer insights into the history and wildlife of Bako National Park, as well as the cultural heritage displayed at the Sarawak Cultural Village.',
                'Transportation Arrangements' => 'Boat transfers to Bako National Park and convenient travel arrangements to various attractions in Kuching and surrounding areas.',
                'Dining Recommendations' => 'Suggestions for local eateries serving Sarawakian specialties, including Laksa Sarawak and Kolo Mee for an authentic culinary experience.',
                'Accommodation Suggestions' => 'Accommodation options near Kuching Waterfront and other major attractions, providing easy access and comfort.',
                'Custom Itinerary Flexibility' => 'Options to adjust the itinerary to include additional activities such as a visit to Semenggoh Nature Reserve or Niah National Park for those with extended stays.',
            ],
        ],

        'Cultural Heritage' => [
            'Day 1' => [
                'Title' => 'Immersion in Sarawak’s Indigenous Culture at Sarawak Cultural Village',
                'Morning' => 'Begin your journey with a visit to the Sarawak Cultural Village, a living museum showcasing the diverse cultures of Sarawak’s indigenous groups. Experience traditional houses, handicrafts, and performances.',
                'Afternoon' => 'Enjoy a traditional lunch at the Cultural Village with dishes like Manok Pansoh (chicken cooked in bamboo) and Umai (raw fish salad).',
                'Evening' => 'End the day with a cultural dance performance. For dinner, GoLokal suggests a nearby restaurant to try Laksa Sarawak and Kolo Mee.',
            ],
            'Day 2' => [
                'Title' => 'Market Exploration and Handicrafts in Kuching',
                'Morning' => 'Explore Main Bazaar in Kuching, where you can shop for local crafts, beadwork, and souvenirs, and interact with artisans.',
                'Afternoon' => 'After lunch, visit the Sarawak State Museum for a deeper understanding of the region’s history and culture. Recommended lunch options nearby include Mee Jawa and Ayam Penyet.',
                'Evening' => 'Visit the Kuching Waterfront in the evening for a leisurely stroll. GoLokal recommends dinner at a local eatery, featuring dishes like Midin (stir-fried jungle fern) and Dabai (local black olive).',
            ],
            'Day 3' => [
                'Title' => 'Arts and Crafts in Miri and Sibu',
                'Morning' => 'Travel to Sibu Heritage Centre to learn about the local Chinese, Malay, and indigenous communities through their arts and crafts exhibits.',
                'Afternoon' => 'After lunch, visit a local arts center in Miri, where you can see traditional textiles, pottery, and handicrafts. For lunch, try Nasi Lemak and Kuih Lapis (layered cake).',
                'Evening' => 'Conclude your cultural journey with a farewell dinner featuring Ikan Terubuk Masin (salted fish) and Tuak (local rice wine) for an authentic Sarawakian experience.',
            ],
            'GoLokal Offerings' => [
                'Guided Tours' => 'Expert guides available at Sarawak Cultural Village, Main Bazaar, and Sibu Heritage Centre to provide insights into Sarawak’s rich culture.',
                'Transportation Arrangements' => 'Convenient transport options from Kuching to Sibu and Miri, ensuring a seamless cultural exploration across Sarawak.',
                'Dining Recommendations' => 'Handpicked local eateries to experience authentic Sarawakian flavors, such as Laksa Sarawak and Manok Pansoh.',
                'Accommodation Suggestions' => 'Traditional lodges and eco-resorts near key cultural sites for a comfortable stay with a cultural ambiance.',
                'Custom Itinerary Flexibility' => 'Options to add visits to additional attractions like Niah Caves or Lambir Hills National Park for extended cultural experiences.',
            ],
        ],


        'Adventure' => [
            'Day 1' => [
                'Title' => 'Caving Adventure at Mulu National Park',
                'Morning' => 'Begin the day with an exploration of Mulu National Park’s Deer Cave, one of the world’s largest cave passages, famous for its limestone formations and bat exodus.',
                'Afternoon' => 'After lunch, continue with caving activities at the Lang Cave, which features stunning stalactites and stalagmites. Enjoy local dishes like Laksa Sarawak for lunch.',
                'Evening' => 'Return to your accommodation for dinner and relaxation. GoLokal recommends trying Manok Pansoh (chicken cooked in bamboo) at a nearby restaurant for an authentic taste of Sarawak.',
            ],
            'Day 2' => [
                'Title' => 'Jungle Trekking in Bario Highlands',
                'Morning' => 'Travel to the Bario Highlands and embark on a jungle trekking experience through dense rainforest, exploring the unique flora and fauna of Sarawak.',
                'Afternoon' => 'Break for lunch with a traditional Bario rice dish, unique to the highlands and cultivated by the local Kelabit people. Continue trekking in the afternoon, visiting local farms and experiencing the serene landscapes.',
                'Evening' => 'For dinner, GoLokal suggests tasting Umai (a raw fish salad) at a local eatery to wind down the adventurous day.',
            ],
            'Day 3' => [
                'Title' => 'Kayaking Adventure in Santubong',
                'Morning' => 'Head to Santubong for a scenic kayaking adventure along Sarawak’s rivers, surrounded by lush greenery and mountainous views.',
                'Afternoon' => 'Stop for a riverside lunch with dishes such as Midin (jungle fern stir-fried) and Ikan Terubuk Masin (salted fish), capturing the local flavors of Sarawak.',
                'Evening' => 'Conclude your trip with a farewell dinner back in Kuching, enjoying Kolok Mee and Teh C Peng Special (three-layered tea) to celebrate your adventure-filled journey.',
            ],
            'GoLokal Offerings' => [
                'Guided Tours' => 'Professional guides at Mulu National Park, Bario Highlands, and Santubong provide in-depth knowledge and ensure safety during activities.',
                'Transportation Arrangements' => 'Easy transport options from Mulu to Bario and Santubong, connecting you seamlessly across Sarawak’s adventurous locations.',
                'Dining Recommendations' => 'A curated list of restaurants and local dishes such as Laksa Sarawak and Manok Pansoh to enhance your culinary experience.',
                'Accommodation Suggestions' => 'Stay at eco-friendly lodges and local homestays near adventure sites for a comfortable and immersive experience.',
                'Custom Itinerary Flexibility' => 'Option to extend your trip with additional activities like a visit to Semenggoh Nature Reserve or a relaxing day at Damai Beach.',
            ],
        ],
    ],

    'Selangor' => [
        'Top Attractions' => [
            'Day 1' => [
                'Title' => 'Exploring Iconic Landmarks in Selangor',
                'Morning' => 'Begin your day at Batu Caves, one of Malaysia’s most famous landmarks. Climb the colorful stairs and explore the stunning cave temples.',
                'Afternoon' => 'Continue to the Sultan Salahuddin Abdul Aziz Shah Mosque (Blue Mosque) in Shah Alam, known for its magnificent Islamic architecture and impressive blue dome. Enjoy lunch nearby with dishes like Nasi Kerabu and Rojak.',
                'Evening' => 'Relax and explore i-City in Shah Alam, where you’ll experience the mesmerizing City of Digital Lights. For dinner, GoLokal recommends trying Satay Kajang at a nearby restaurant for an authentic taste of Selangor.',
            ],
            'Day 2' => [
                'Title' => 'Cultural and Historical Exploration',
                'Morning' => 'Start the day with a visit to the Sultan Abdul Aziz Royal Gallery in Klang, where you’ll learn about Selangor’s royal history through artifacts and exhibits.',
                'Afternoon' => 'Explore Pulau Ketam, a unique fishing village on stilts, where you can experience traditional Chinese community life. Have lunch with local seafood delicacies like Salted Fish and Steamed Fish.',
                'Evening' => 'Return to Klang for a heritage walk around the Royal Klang Heritage Walk. For dinner, try Mee Rebus or Asam Laksa to round off the day.',
            ],
            'Day 3' => [
                'Title' => 'Shopping and Leisure',
                'Morning' => 'Head to Sunway Lagoon for a day of fun and adventure with water rides, amusement parks, and wildlife encounters.',
                'Afternoon' => 'Enjoy lunch at Sunway Pyramid Mall and spend the afternoon shopping. Try local favorites such as Chicken Rice and Char Kway Teow at the mall’s food court.',
                'Evening' => 'Conclude your trip with a stroll at the Paya Indah Wetlands, where you can relax, bird-watch, or enjoy the peaceful natural surroundings. GoLokal recommends trying local desserts like Cendol and Kuih Lapis to end your journey on a sweet note.',
            ],
            'GoLokal Offerings' => [
                'Guided Tours' => 'Professional guides available for Batu Caves, Pulau Ketam, and Royal Klang Heritage Walk, providing insights into Selangor’s culture and history.',
                'Transportation Arrangements' => 'Convenient transport options between Shah Alam, Klang, and other major attractions, ensuring a smooth travel experience across Selangor.',
                'Dining Recommendations' => 'A curated list of local eateries and must-try dishes like Satay Kajang and Nasi Kerabu for a complete culinary journey.',
                'Accommodation Suggestions' => 'Stay at hotels in Shah Alam or near Sunway for convenient access to key attractions.',
                'Custom Itinerary Flexibility' => 'Option to extend your trip with additional visits to FRIM Canopy Walk or a relaxing evening at Bukit Melawati.',
            ],
        ],

        'Cultural Heritage' => [
            'Day 1' => [
                'Title' => 'Exploring Historic Landmarks and Temples in Selangor',
                'Morning' => 'Start your cultural journey with a visit to Batu Caves, an iconic Hindu pilgrimage site with colorful stairs leading to the main temple within a limestone cave.',
                'Afternoon' => 'Head to the Sultan Salahuddin Abdul Aziz Shah Mosque (Blue Mosque), renowned for its stunning blue dome and Islamic architecture. For lunch, try Nasi Ambeng or Rendang Tok nearby for an authentic local experience.',
                'Evening' => 'Explore the Royal Klang Heritage Walk, visiting key historical sites such as the Kota Darul Ehsan Arch and Istana Alam Shah. For dinner, GoLokal recommends trying Satay Kajang for a local treat.',
            ],
            'Day 2' => [
                'Title' => 'Immersive Cultural Workshops and Heritage Visits',
                'Morning' => 'Visit the Mah Meri Cultural Village to learn about the customs and traditions of the indigenous Mah Meri people, including mask carving and dance performances.',
                'Afternoon' => 'Enjoy lunch at a local restaurant and try Laksa Selangor and Mee Rebus. Continue to the Malay Heritage Museum for cultural workshops, where you can participate in traditional crafts like batik painting and weaving.',
                'Evening' => 'Return to the Sri Shakti Devasthanam Temple, a beautifully designed Hindu temple known for its intricate carvings and spiritual ambiance. For dinner, savor local favorites like Roti Canai and Teh Tarik.',
            ],
            'Day 3' => [
                'Title' => 'Local Markets and Selangor’s Traditional Experiences',
                'Morning' => 'Begin your day with a visit to the Tugu Keris Klang, a monument symbolizing the strength of the Selangor Sultanate. Continue to explore local markets for souvenirs and traditional items.',
                'Afternoon' => 'Have lunch at a food court or hawker center, enjoying dishes such as Char Kway Teow and Ikan Bakar (grilled fish).',
                'Evening' => 'Conclude your trip with a walk through Pulau Ketam, an idyllic fishing village on stilts, where you can sample fresh seafood and experience the serene lifestyle of the local Chinese community.',
            ],
            'GoLokal Offerings' => [
                'Guided Tours' => 'Expert guides for Batu Caves, Mah Meri Cultural Village, and Royal Klang Heritage Walk to provide insights into Selangor’s history and cultural diversity.',
                'Transportation Arrangements' => 'Convenient transport options to cover key locations across Shah Alam, Klang, and nearby cultural sites.',
                'Dining Recommendations' => 'Curated list of must-try dishes like Nasi Ambeng, Satay Kajang, and Rendang Tok for a comprehensive culinary experience.',
                'Accommodation Suggestions' => 'Stay options in Shah Alam or Klang for convenient access to attractions.',
                'Custom Itinerary Flexibility' => 'Options to extend the journey with activities such as a visit to Sepang International Circuit or Forest Research Institute Malaysia (FRIM) for more adventure.',
            ],
        ],

        'Adventure' => [
            'Day 1' => [
                'Title' => 'Thrills and Heights at Skytrex Adventure',
                'Morning' => 'Start the day at Skytrex Adventure in Shah Alam, where you can enjoy ziplining, obstacle courses, and tree-top challenges for an adrenaline-packed experience.',
                'Afternoon' => 'Have lunch nearby and try Nasi Ambeng or Mee Rebus for a taste of local cuisine.',
                'Evening' => 'Relax in the evening with a scenic stroll or grab some snacks at nearby food stalls. Try Pisang Goreng (fried banana) and Teh Tarik (pulled tea) for a classic Malaysian treat.',
            ],
            'Day 2' => [
                'Title' => 'Fun and Action at Sunway Lagoon',
                'Morning' => 'Head to Sunway Lagoon Theme Park for a day of adventure activities, including paintball, go-karting, and water slides.',
                'Afternoon' => 'For lunch, enjoy local dishes at the park’s food court or nearby eateries with options like Ayam Penyet (smashed fried chicken) and Satay.',
                'Evening' => 'End the day with some relaxation at the park’s beach area or explore Sunway Pyramid Mall for shopping and dining. Try Cendol or ABC (Ais Batu Campur) for a refreshing dessert.',
            ],
            'Day 3' => [
                'Title' => 'Sunrise Hiking at Bukit Broga',
                'Early Morning' => 'Set out early for a sunrise hike at Bukit Broga in Semenyih. Enjoy panoramic views as the sun rises over Selangor’s hills and valleys.',
                'Morning' => 'After the hike, recharge with a traditional Malaysian breakfast nearby, including Roti Canai and Nasi Lemak.',
                'Afternoon' => 'For a relaxed end to your trip, visit Kuala Selangor Nature Park to experience mangroves and bird-watching, or try the nearby Sasaran Sky Mirror for unique photography during low tide.',
            ],
            'GoLokal Offerings' => [
                'Guided Tours' => 'Adventure guides are available at Skytrex Adventure and Sunway Lagoon for safety and a richer experience.',
                'Transportation Arrangements' => 'Convenient travel options between Shah Alam, Sunway, and Semenyih for a seamless journey across Selangor.',
                'Dining Recommendations' => 'Taste authentic Selangor dishes such as Nasi Ambeng, Satay Kajang, and Roti Canai to enhance your adventure experience.',
                'Accommodation Suggestions' => 'Stay options near Shah Alam or in Kuala Lumpur for easy access to adventure spots.',
                'Custom Itinerary Flexibility' => 'Additional activities like paragliding at Jugra Hill or rafting at Selangor River can be arranged for more thrill-seekers.',
            ],
        ],
    ],

    'Terengganu' => [
        'Top Attractions' => [
            'Day 1' => [
                'Title' => 'Cultural Exploration and Iconic Landmarks',
                'Morning' => 'Start your journey by visiting the Crystal Mosque, a unique architectural marvel made of glass and crystal along the Terengganu River.',
                'Afternoon' => 'Explore the Terengganu State Museum, the largest museum complex in Malaysia, showcasing Terengganu’s rich culture and history.',
                'Evening' => 'End the day with a local dining experience at a nearby eatery, trying traditional dishes such as Nasi Dagang (rice with fish curry) and Keropok Lekor (fish sausage).',
            ],
            'Day 2' => [
                'Title' => 'Local Markets and Handicrafts',
                'Morning' => 'Visit the Central Market in Kuala Terengganu to explore the local handicrafts, batik, and woven products that showcase traditional Terengganu artistry.',
                'Afternoon' => 'Continue with a tour of Kuala Terengganu Chinatown for a mix of Chinese-Malay culture, vibrant architecture, and street food.',
                'Evening' => 'Dine on Chinese-Malay fusion dishes at a Chinatown restaurant, sampling Loh Mee (braised noodles) and Hainanese Chicken Rice.',
            ],
            'Day 3' => [
                'Title' => 'Island Relaxation and Natural Beauty',
                'Morning' => 'Take a boat ride to Redang Island for a day of beach relaxation. Enjoy snorkeling and diving in the crystal-clear waters surrounded by vibrant coral reefs.',
                'Afternoon' => 'Have a picnic-style lunch with fresh seafood on the island or try Ikan Bakar (grilled fish) from local vendors.',
                'Evening' => 'Return to the mainland and conclude your trip with a sunset view along the coast at Marang.',
            ],
            'GoLokal Offerings' => [
                'Guided Tours' => 'Knowledgeable guides at the Terengganu State Museum and Crystal Mosque provide insights into the cultural heritage of Terengganu.',
                'Transportation Arrangements' => 'Convenient boat transfers to Redang Island and guided tours through Kuala Terengganu’s cultural sites.',
                'Dining Recommendations' => 'Experience authentic Terengganu flavors with recommendations for Nasi Dagang, Keropok Lekor, and fresh seafood dishes.',
                'Accommodation Suggestions' => 'Stay options in Kuala Terengganu city center for easy access to cultural sites and local eateries.',
                'Custom Itinerary Flexibility' => 'Additional activities such as exploring Kapas Island or hiking near Bukit Puteri for panoramic views of the region.',
            ],
        ],

        'Cultural Heritage' => [
            'Day 1' => [
                'Title' => 'Islamic Heritage and Cultural Exploration',
                'Morning' => 'Begin your day at the Islamic Civilization Park where you can explore replicas of famous Islamic structures worldwide and learn about Islamic heritage.',
                'Afternoon' => 'Visit the iconic Crystal Mosque nearby, which is known for its breathtaking glass and steel design on the Terengganu River.',
                'Evening' => 'For dinner, GoLokal recommends trying local dishes like Nasi Kerabu (blue rice with herbs) and Ayam Percik (grilled chicken with coconut gravy) at a popular local restaurant.',
            ],
            'Day 2' => [
                'Title' => 'Traditional Handicrafts and Artisans',
                'Morning' => 'Head to the Masarang Traditional Crafts Centre to watch artisans at work, including batik painting and songket weaving demonstrations.',
                'Afternoon' => 'Explore Kampung China (Chinatown) for its vibrant streets, traditional Chinese architecture, and cultural festivals. Enjoy a local lunch with dishes like Laksa Terengganu or Keropok Lekor (fish crackers).',
                'Evening' => 'For dinner, try a mix of local Chinese-Malay flavors at a nearby eatery, with Mee Goreng (fried noodles) and Kuih-muih (local desserts) on the menu.',
            ],
            'Day 3' => [
                'Title' => 'Fishing Villages and Boat-Making Traditions',
                'Morning' => 'Take a boat ride along the Marang River to visit traditional fishing villages, where you can learn about local fishing techniques and village life.',
                'Afternoon' => 'Visit Pulau Duyong to see the heritage of wooden boat-making. Witness craftsmen creating wooden boats, a skill passed down through generations.',
                'Evening' => 'Conclude your journey with a sunset dinner along the coast, savoring Ikan Bakar (grilled fish) and Sotong Celup Tepung (fried squid).',
            ],
            'GoLokal Offerings' => [
                'Guided Tours' => 'Local guides at the Islamic Civilization Park and Marang River villages provide in-depth knowledge about Terengganu’s cultural and religious heritage.',
                'Transportation Arrangements' => 'Seamless transportation between cultural sites, including boat rides on the Marang River and easy access to local markets.',
                'Dining Recommendations' => 'A curated list of local eateries and must-try dishes, including Nasi Kerabu, Ayam Percik, and Terengganu’s signature Laksa.',
                'Accommodation Suggestions' => 'Stay at coastal resorts or traditional guesthouses to enhance your cultural experience in Terengganu.',
                'Custom Itinerary Flexibility' => 'Options to extend your stay with additional activities such as visiting Bukit Puteri or exploring Losong Museum for more insights into Terengganu’s culture.',
            ],
        ],

        'Adventure' => [
            'Day 1' => [
                'Title' => 'Island Diving and Snorkeling at Redang Island',
                'Morning' => 'Begin your adventure with a boat trip to Redang Island, known for its pristine beaches and clear waters.',
                'Afternoon' => 'Engage in scuba diving and snorkeling to explore vibrant coral reefs and marine life around the island.',
                'Evening' => 'For dinner, GoLokal recommends trying Terengganu specialties like Nasi Dagang (rice steamed in coconut milk with fish curry) and Ikan Bakar (grilled fish) at a beachside restaurant.',
            ],
            'Day 2' => [
                'Title' => 'Exploring Marine Life at Perhentian Islands',
                'Morning' => 'Head to the Perhentian Islands for a day filled with beach activities, snorkeling, and kayaking in the calm, turquoise waters.',
                'Afternoon' => 'Discover the diverse marine life with snorkeling tours, where you may spot sea turtles, tropical fish, and more.',
                'Evening' => 'Enjoy local delicacies such as Sotong Celup Tepung (fried squid) and Keropok Lekor (fish crackers) at a nearby island café before returning to the mainland.',
            ],
            'Day 3' => [
                'Title' => 'Jungle Trekking in Taman Negara (Terengganu Section)',
                'Morning' => 'Start early with a trek through Taman Negara Terengganu. Enjoy jungle trails, bird-watching, and encounters with local wildlife.',
                'Afternoon' => 'After your trek, relax with a packed picnic lunch featuring local flavors like Pulut Lepa (glutinous rice wrapped in banana leaves) and Kuih Akok (sweet egg-based snack).',
                'Evening' => 'For your final meal, indulge in Terengganu’s seafood offerings like Udang Sambal Petai (prawns in spicy sambal with petai) at a recommended restaurant.',
            ],
            'GoLokal Offerings' => [
                'Guided Tours' => 'Experienced guides at Redang and Perhentian Islands provide insights into the underwater ecosystem and conservation efforts.',
                'Transportation Arrangements' => 'Convenient boat transfers to Redang and Perhentian Islands, as well as guided treks in Taman Negara.',
                'Dining Recommendations' => 'Suggestions for the best local eateries serving Terengganu favorites like Nasi Dagang and Ikan Bakar, along with fresh seafood options.',
                'Accommodation Suggestions' => 'Stay options ranging from beach resorts to eco-lodges near Taman Negara, offering comfort and proximity to natural attractions.',
                'Custom Itinerary Flexibility' => 'Options to extend your stay with more activities, such as kayaking at Kenyir Lake or visiting the hot springs at La for relaxation.',
            ],
        ],
    ],
];


// Get the specific itinerary for the selected state and plan
$selected_itinerary = isset($state_itineraries[$state][$plan_name]) ? $state_itineraries[$state][$plan_name] : [];

// Map states to background images
$state_images = [
    'Johor' => 'assets/image/Johor/Flag Johor.png',
    'Kedah' => 'assets/image/Kedah/Flag Kedah.png',
    'Kelantan' => 'assets/image/Kelantan/Flag Kelantan.png',
    'Melaka' => 'assets/image/Melaka/Flag Melaka.png',
    'Negeri Sembilan' => 'assets/image/Negeri Sembilan/Flag Negeri Sembilan.png',
    'Pahang' => 'assets/image/Pahang/Flag Pahang.png',
    'Perak' => 'assets/image/Perak/Flag Perak.png',
    'Perlis' => 'assets/image/Perlis/Flag Perlis.png',
    'Penang' => 'assets/image/Pulau Pinang/Penang Flag.png',
    'Sabah' => 'assets/image/Sabah/Flag Sabah.png',
    'Sarawak' => 'assets/image/Sarawak/Flag Sarawak.png',
    'Selangor' => 'assets/image/Selangor/Flag Selangor.png',
    'Terengganu' => 'assets/image/Terengganu/Flag Terengganu.png',
];


// Determine the state image (fallback to default image if not available)
$state_image = isset($state_images[$state]) && !empty($state_images[$state]) ? $state_images[$state] : 'assets/image/default_image.jpg';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Journey Details - <?php echo htmlspecialchars($plan_name); ?> in <?php echo htmlspecialchars($state); ?></title>
    <link rel="stylesheet" href="assets/css/journey.css">
    <link rel="icon" type="image/png" href="assets/image/GoLokal Logo.png">
</head>

<body>

    <!-- Hero Section with Background Image -->
    <div class="hero" style="background-image: url('<?php echo htmlspecialchars($state_image); ?>'); background-size: cover; background-position: center;">
        <div class="hero-overlay"></div>
        <div class="hero-text"><?php echo htmlspecialchars($state); ?></div>
    </div>

    <h1><?php echo htmlspecialchars($plan_name); ?> in <?php echo htmlspecialchars($state); ?></h1>

    <h2>Journey: 3 Days, 2 Nights</h2>

    <?php if (isset($selected_itinerary) && is_array($selected_itinerary)) { ?>
        <ul>
            <?php foreach ($selected_itinerary as $day => $activities) { ?>
                <li><strong><?php echo htmlspecialchars($day); ?>:</strong></li>
                <ul>
                    <?php if (is_array($activities)) { ?>
                        <?php foreach ($activities as $time => $description) { ?>
                            <?php if (is_string($description)) { ?>
                                <li><strong><?php echo htmlspecialchars($time); ?>:</strong> <?php echo htmlspecialchars($description); ?></li>
                            <?php } ?>
                        <?php } ?>
                    <?php } else { ?>
                        <li><?php echo htmlspecialchars($activities); ?></li>
                    <?php } ?>
                </ul>
            <?php } ?>
        </ul>
    <?php } else { ?>
        <p>No itinerary available for this plan in <?php echo htmlspecialchars($state); ?>.</p>
    <?php } ?>

    <a href="../Tour/Tour.php">Back to Home</a>

</body>

</html>