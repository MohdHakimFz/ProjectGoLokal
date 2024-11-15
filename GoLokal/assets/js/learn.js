// Navbar toggle for mobile
const menuToggle = document.querySelector(".menu-toggle");
const navMenu = document.querySelector(".nav-menu");

if (menuToggle) {
 menuToggle.addEventListener("click", () => {
  navMenu.classList.toggle("active");
 });
}

document.addEventListener("DOMContentLoaded", () => {
 const dropdownToggle = document.getElementById("dropdownToggle");
 const dropdownMenu = document.getElementById("dropdownMenu");

 if (dropdownToggle && dropdownMenu) {
  // Toggle dropdown visibility when clicking the toggle button
  dropdownToggle.addEventListener("click", (event) => {
   event.stopPropagation(); // Prevent the event from bubbling up
   dropdownMenu.classList.toggle("show"); // Toggle the 'show' class
  });

  // Close dropdown if clicking outside
  document.addEventListener("click", (event) => {
   if (
    !dropdownToggle.contains(event.target) &&
    !dropdownMenu.contains(event.target)
   ) {
    dropdownMenu.classList.remove("show"); // Hide dropdown
   }
  });
 }
});

document.addEventListener("DOMContentLoaded", () => {
 const flagItems = document.querySelectorAll(".flag-item");
 const dictionary = document.querySelector(".dictionary");

 // Object containing loghat data for each state
 const stateData = {
  Kedah: {
   description:
    "Kedah is known for its rice paddies and agricultural landscape.",
   loghat: [
    "Cekelat = Coklat (Chocolate)",
    "Habaq = Beritahu (Tell)",
    "Mai = Mari (Come)",
    "Dok = Duduk (Sit)",
    "Tara = Tiada (None)",
    "Kome = Awak (You)",
    "Sakan = Berlebihan (Excessive)",
    "Pasiaq = Pasir (Sand)",
    "Takek = Ketuk (Kick)",
    "Tahaq = Tahan (Hold)",
    "Lamaq = Lama (Long)",
    "Cemuih = Bosan (Bored)",
    "Tokak = Gigit Besar (Big Bite)",
    "Ketegaq = Degil (Stubborn)",
   ],
  },

  Perlis: {
   description: "Perlis is the smallest state in Malaysia.",
   loghat: [
    "Bakaq = Bakar (Burn)",
    "Kenai = Kenal (Recognize)",
    "Lapaq = Lapar (Hungry)",
    "Tang =  Di mana (Where)",
    "Kayu = Bodoh (Stupid)",
    "Mengai = Mancing (Fishing) ",
    "Bertedak = Mengada-ngada (Fussy)",
    "Habaq = Bagitahu (Tell) ",
    "Bertampek = Berkumpul (Gather)",
    "Tegheling = Jatuh (Fall)",
    "Nyior = Kelapa (Coconut)",
    "Hang = Awak (You)",
    "Mai = Mari (Come)",
    "Camca = Sudu (Spoon)",
    "Pi = Pergi (Go)",
   ],
  },

  Penang: {
   description: "Penang is an island state known for its vibrant food scene.",
   loghat: [
    "Hang = Awak (You)",
    "Tarak = Tidak ada (Not available)",
    "Pi = Pergi (Go)",
    "Mai pi = Mari pergi (Come and go)",
    "Habih = Habis (Finished)",
    "Teruk = Parah (Serious)",
    "Gerek = Kawan (Friend)",
    "Ketegaq = Degil (Stubborn)",
    "Tidoq = Tidur (Sleep)",
    "Habaq = Beritahu (Tell)",
    "Sempoi – Santai (Chill)",
    "Bang = Azan(Prayer)",
    "Hangpa = Korang (You Guys)",
    "Kalut = Kelam Kabut (I can't wait)",
    "Kemarin = Semalam (Yesterday)",
   ],
  },

  Perak: {
   description: "Perak is famous for its tin-mining history.",
   loghat: [
    "Kome = Kamu (You)",
    "Temenung = Berfikir jauh (Deep thought)",
    "Kecik molek = Comel (Cute)",
    "Nyeghang = Berteriak (Shout)",
    "Meroyan = Marah-marah (Ranting)",
    "Cengey = Garang (Fierce)",
    "Nganga = Mulut terbuka (Open mouth)",
    "Lenggang kangkung = Jalan bersahaja (Casual walk)",
    "Ngam = Sesuai (Fit) - “Pakaian itu ngam.” - That outfit fits well.",
    "Kebulor = Lapar(Hungry)",
    "Perok = Jakun(never seen anything)",
    "Biot = Degil(Stubborn)",
    "Meroloh = Tidur(Sleep)",
    "Muncah = Banyak Duit(rich)",
    "ingke = seronok yang melampau(Too Much Fun)",
   ],
  },
  Kelantan: {
   description: "Kelantan is a state in the northeast known for its culture.",
   loghat: [
    "Demo – Kamu (You)",
    "Kecek – Cakap (Speak)",
    "Make – Makan (Eat)",
    "Royak – Beritahu (Tell)",
    "Kelik – Balik (Go home)",
    "Seghoti – Betul-betul (Truly)",
    "Gapo – Apa (What)",
    "Pueh – Puas (Satisfied)",
    "Soh – Suruh (Instruct)",
    "Bilo – Bila (When)",
    "Pitih – Duit (Money)",
    "Bawak – Bawa (Bring)",
    "Cokoh – Duduk (Sit)",
    "Geng – Kumpulan (Group)",
    "Samah – 50 Sen (50 Cent)",
   ],
  },

  Pahang: {
   description: "Pahang is the largest state in Peninsular Malaysia by area.",
   loghat: [
    "Kaweh = Kawan(Friend)",
    "Awok = Awak(You)",
    "Hok Tu = Yang Itu (That One)",
    "Hok Ini = Yang Ini (This One)",
    "Royek = Beritahu (Tell)",
    "Kabo = Khabar(News)",
    "Muktan = Rambutan(Rambutan)",
    "Reloh = Tidur(Sleep)",
    "Jabir = Plastik(Plastic)",
    "Maleh = Malas (Lazy)",
    "Budu = Pede ()",
    "Lece = Tilam (Mattress)",
    "Rahang = Tangis (Cry)",
    "Sesemut = Kebas Kaki (Numb Feet)",
    "Jenih = Jenis (Type)",
   ],
  },
  Johor: {
   description: "Johor is located in the southern part of Peninsular Malaysia.",
   loghat: [
    "Air Tawo = Air Tawar",
    "Anu = Sesuatu",
    "Belajor = Belajar",
    "Bobos = Bocor",
    "Buboh = Letak",
    "Calor = Calar",
    "Dedor = Tak Sihat",
    "Hangen = Angin",
    "Jotos = Sekel",
    "Katup = Tutup",
    "Kendian = Kemudian",
    "Selipor = Selipar",
    "Sandor = Sandar",
    "Bopeng = Segan",
    "Anu = Minta Tolong Sesuatu",
   ],
  },

  Melaka: {
   description: "Malacca is famous for its historical significance.",
   loghat: [
    "Kojap = Sekejap (A while)",
    "Keriau = Jerit (Scream)",
    "Senteng = Singkat (Short)",
    "Besau = Besar (Big)",
    "Kasau = Kasar (Rough)",
    "Belajau = Belajar (Learn)",
    "Ulau = Ular (Snake)",
    "Suratkhabau = Surat Khabar (Newspaper)",
    "Kite = Kita (We)",
    "Ape = Apa (What)",
    "Melake = Melaka (Malacca)",
    "Kerete = Kereta (Car)",
    "Beledi = Baldi (Bald)",
    "Gumah = Rumah (House)",
    "Berdighi = Berdiri (Stand)",
   ],
  },

  "Negeri Sembilan": {
   description: "Negeri Sembilan is known for its unique Minangkabau culture.",
   loghat: [
    "Tompang – Tumpang (Hitch a ride)",
    "Apo – Apa (What)",
    "Kok – Kalau (If)",
    "Natang – Binatang (Animal, insult term)",
    "Menceceh – Membebel (Nagging)",
    "Sebunyi – Sembunyi (Hide)",
    "Baghu – Baru (New)",
    "Gombang – Berguling (Roll over)",
    "Buek – Buat (Come)",
    "Sobab – Sebab (Street)",
    "Sodagho – Sedara (Eat)",
    "Seghonok – Fun (Seronok)",
    "Solamat – Safe (Selamat)",
    "Cubo – Try (Cuba)",
    "Belanjo – Treat (To pay for someone)",
   ],
  },

  Selangor: {
   description:
    "Selangor is known for its diverse culture and urban development.",
   loghat: [
    "Geng – Kumpulan (Group)",
    "Tapau – Bungkus (Takeaway)",
    "Coy – Kawan (Friend)",
    "Lengchai – Lelaki kacak (Handsome boy)",
    "Lenglui – Gadis cantik (Beautiful girl)",
    "Syok – Suka (Enjoy)",
    "Ngam – Sesuai (Fit)",
    "Lek lu – Tunggu sebentar (Wait a moment)",
    "Selit – Masuk dengan licik (Sneak in)",
    "Tengah syok – Seronok (Having fun)",
    "Jalan – Jalan (Street)",
    "Hati-hati – Berhati-hati (Be careful)",
    "Beli – Buy (Beli)",
    "Masak – Cook (Masak)",
    "Selesai – Finish (Selesai)",
   ],
  },

  Sabah: {
   description:
    "Sabah is located on the island of Borneo and known for its natural beauty.",
   loghat: [
    "Babat = Gemuk (Fat)",
    "Bertabiat = Buat Hal (Doing )",
    "Tingu = Tengok (Look)",
    "Ping = Sejuk (Cold)",
    "Ging = Member (Friends)",
    "Biut = Senget (Not Straight)",
    "Gerigitan = Geram ()",
    "Saaaaana = Tempat Yang Jauh (Far Away)",
    "Palis-Palis = Minta Dijauhkan Benda Tidak Baik (Bad Behaviour)",
    "Sinang = Tenang (Calm)",
    "Malar = Selalu (Always)",
    "Bah = Baiklah (Okey)",
    "Siok = Seronok (Fun)",
    "Tapuk = Sembunyi (Hide)",
    "Bobot = Kejar (Catch)",
   ],
  },

  Sarawak: {
   description:
    "Sarawak is the largest state in Malaysia located on Borneo island.",
   loghat: [
    "Beloya = berborak (Chatting)",
    "Kitak gi sine? = Awak pergi mana? (Where are you going?)",
    "Kitak apa polah? = Awak buat apa? (What are you doing?)",
    "Kitak dah makan? = Awak dah makan? (Have you eaten?)",
    "Apa polah kitak kinek tok? = Awak buat apa sekarang? (What are you doing right now?)",
    "Kitak apa khabar tek? = Awak apa khabar? (How are you?)",
    "Boleh nolong kamek sik? = Boleh bantu saya tak? (Can you help me?)",
    "Tinggi nar semengat kitak juak? = Semangat awak tinggi betul (You have a really high spirit)",
    "Apa reti makan hati? = Apa maksud makan hati? (What does makan hati mean?)",
    "Bila kitak nak nikah gik? = Bila awak nak kawin?  (When are you getting married?)",
    "Aok ajak la = Ye la tu (Yeah, right)",
    "Kacak na kitak aritok = Awak nampak cantik hari ni (You look beautiful today)",
    "Lawa kitak owh.. = Sombongnya awak (You're so arrogant)",
    "Kitak dah mandik lom? = Awak dah mandi ke belum? (Have you showered yet?)",
    "Lepas tok pegi sine? = Lepas ini pergi mana pulak? (Where are you going after this?)",
   ],
  },

  Terengganu: {
   description:
    "Terengganu is known for its islands and traditional Malay culture.",
   loghat: [
    "Acu = Cuba (try)",
    "Bakpe = Kenapa (why)",
    "BBaloh = Gaduh (fight)",
    "Carik = Koyak (tear)",
    "Derak = Jalan-Jalan (stroll)",
    "Igak = Tangkap (catch)",
    "Jangok = Bergaya (stylish)",
    "Kekoh = Gigit (bite)",
    "Kelih = Tengok (look)",
    "Lesek = Sapu (wipe)",
    "Parok = Teruk (severe/bad)",
    "Plekong = Baling (throw)",
    "Puahsang = Bosan (bored)",
    "Ralik = Leka (careless/absorbed)",
    "Reboh = Jatuh (fall)",
   ],
  },
 };

 // Add click event listener to each flag item
 flagItems.forEach((item) => {
  item.addEventListener("click", () => {
   // Remove active class from currently active flag item
   document.querySelector(".flag-item.active").classList.remove("active");
   // Add active class to the clicked flag item
   item.classList.add("active");

   // Update the dictionary section with relevant state information
   const stateName = item.getAttribute("data-state");
   const stateInfo = stateData[stateName];

   // Generate loghat dictionary list
   const loghatList = stateInfo.loghat
    .map((term) => `<li>${term}</li>`)
    .join("");

   dictionary.innerHTML = `
        <h3>${stateName} Language Dictionary</h3>
        <p>${stateInfo.description}</p>
        <h4>Common Loghat Terms:</h4>
        <ul>${loghatList}</ul>
      `;
  });
 });
});

/* Sticky Header (on Scroll) */
window.addEventListener("scroll", function () {
 const header = document.querySelector("header");
 header.classList.toggle("sticky", window.scrollY > 50);
});

// chat bot ai
document.addEventListener("DOMContentLoaded", function () {
 const chatToggle = document.getElementById("chat-toggle");
 const chatContainer = document.getElementById("chatbot-container");
 const minimizeChat = document.getElementById("minimize-chat");
 const sendMessage = document.getElementById("send-message");
 const userInput = document.getElementById("user-input");
 const chatMessages = document.getElementById("chat-messages");

 // Your Gemini API key - should be stored securely in production
 const API_KEY = "AIzaSyCZlqLB-chqgJbiIhonq7bBqT7eRyMk2Vk";
 const API_URL =
  "https://generativelanguage.googleapis.com/v1beta/models/gemini-pro:generateContent";

 chatToggle.addEventListener("click", () => {
  chatContainer.style.display = "flex";
  chatToggle.style.display = "none";
 });

 minimizeChat.addEventListener("click", () => {
  chatContainer.style.display = "none";
  chatToggle.style.display = "flex";
 });

 async function sendToGemini(message) {
  try {
   const response = await fetch(`${API_URL}?key=${API_KEY}`, {
    method: "POST",
    headers: {
     "Content-Type": "application/json",
    },
    body: JSON.stringify({
     contents: [
      {
       parts: [
        {
         text: message,
        },
       ],
      },
     ],
    }),
   });

   const data = await response.json();
   return data.candidates[0].content.parts[0].text;
  } catch (error) {
   console.error("Error:", error);
   return "Sorry, I encountered an error. Please try again later.";
  }
 }

 async function handleUserMessage() {
  const message = userInput.value.trim();
  if (!message) return;

  // Add user message to chat
  const userMessageDiv = document.createElement("div");
  userMessageDiv.className = "user-message";
  userMessageDiv.textContent = message;
  chatMessages.appendChild(userMessageDiv);

  // Clear input
  userInput.value = "";

  // Get bot response
  const response = await sendToGemini(message);

  // Add bot response to chat
  const botMessageDiv = document.createElement("div");
  botMessageDiv.className = "bot-message";
  botMessageDiv.textContent = response;
  chatMessages.appendChild(botMessageDiv);

  // Scroll to bottom
  chatMessages.scrollTop = chatMessages.scrollHeight;
 }

 sendMessage.addEventListener("click", handleUserMessage);
 userInput.addEventListener("keypress", (e) => {
  if (e.key === "Enter") {
   handleUserMessage();
  }
 });
});
