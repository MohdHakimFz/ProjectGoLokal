document.addEventListener("DOMContentLoaded", () => {
 // Add loading state to weather cards
 const weatherCards = document.querySelectorAll(".weather-card");

 // Refresh weather data every 30 minutes
 const REFRESH_INTERVAL = 30 * 60 * 1000; // 30 minutes in milliseconds

 // Function to format time
 function formatTime(date) {
  return date.toLocaleTimeString("en-US", {
   hour: "2-digit",
   minute: "2-digit",
  });
 }

 // Function to add last updated time
 function addLastUpdatedTime() {
  const now = new Date();
  weatherCards.forEach((card) => {
   const timeDiv =
    card.querySelector(".last-updated") || document.createElement("div");
   timeDiv.className = "last-updated";
   timeDiv.innerHTML = `Last updated: ${formatTime(now)}`;
   if (!card.querySelector(".last-updated")) {
    card.appendChild(timeDiv);
   }
  });
 }

 // Function to handle weather card hover effects
 function handleCardHover() {
  weatherCards.forEach((card) => {
   card.addEventListener("mouseenter", () => {
    card.style.transform = "translateY(-5px)";
    card.style.boxShadow = "0 6px 20px rgba(0, 0, 0, 0.12)";
   });

   card.addEventListener("mouseleave", () => {
    card.style.transform = "translateY(0)";
    card.style.boxShadow = "0 4px 15px rgba(0, 0, 0, 0.08)";
   });
  });
 }

 // Function to handle weather icon animations
 function animateWeatherIcons() {
  const weatherIcons = document.querySelectorAll(".weather-info img");
  weatherIcons.forEach((icon) => {
   icon.style.transition = "transform 0.3s ease";
   icon.addEventListener("mouseenter", () => {
    icon.style.transform = "scale(1.1)";
   });
   icon.addEventListener("mouseleave", () => {
    icon.style.transform = "scale(1)";
   });
  });
 }

 // Function to handle temperature unit conversion (Celsius to Fahrenheit)
 function enableTemperatureConversion() {
  const tempValues = document.querySelectorAll(".temp-value");
  tempValues.forEach((temp) => {
   temp.style.cursor = "pointer";
   temp.setAttribute("title", "Click to convert temperature");

   temp.addEventListener("click", () => {
    const text = temp.textContent;
    if (text.includes("°C")) {
     const celsius = parseFloat(text);
     const fahrenheit = (celsius * 9) / 5 + 32;
     temp.textContent = `${Math.round(fahrenheit)}°F`;
    } else {
     const fahrenheit = parseFloat(text);
     const celsius = ((fahrenheit - 32) * 5) / 9;
     temp.textContent = `${Math.round(celsius)}°C`;
    }
   });
  });
 }

 // Function to handle weather tips interaction
 function initializeWeatherTips() {
  const tips = document.querySelectorAll(".tip");
  tips.forEach((tip) => {
   tip.addEventListener("click", () => {
    // Remove active class from all tips
    tips.forEach((t) => t.classList.remove("active"));
    // Add active class to clicked tip
    tip.classList.add("active");
   });
  });
 }

 // Function to add loading animation
 function addLoadingState(element) {
  element.classList.add("loading");
  const loader = document.createElement("div");
  loader.className = "loader";
  element.appendChild(loader);
 }

 // Function to remove loading animation
 function removeLoadingState(element) {
  element.classList.remove("loading");
  const loader = element.querySelector(".loader");
  if (loader) {
   loader.remove();
  }
 }

 // Initialize all features
 function initializeWeatherFeatures() {
  addLastUpdatedTime();
  handleCardHover();
  animateWeatherIcons();
  enableTemperatureConversion();
  initializeWeatherTips();

  // Add corresponding CSS for loading animation
  const style = document.createElement("style");
  style.textContent = `
            .loading {
                position: relative;
                opacity: 0.7;
            }
            .loader {
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                width: 30px;
                height: 30px;
                border: 3px solid #f3f3f3;
                border-top: 3px solid #f8c102;
                border-radius: 50%;
                animation: spin 1s linear infinite;
            }
            @keyframes spin {
                0% { transform: translate(-50%, -50%) rotate(0deg); }
                100% { transform: translate(-50%, -50%) rotate(360deg); }
            }
            .tip.active {
                background: #fff5d6;
                transform: translateY(-5px);
            }
            .last-updated {
                text-align: right;
                font-size: 0.8rem;
                color: #666;
                margin-top: 10px;
            }
        `;
  document.head.appendChild(style);
 }

 // Refresh weather data periodically
 function setupWeatherRefresh() {
  setInterval(() => {
   weatherCards.forEach((card) => {
    addLoadingState(card);
    // Simulate API refresh (replace with actual API call if needed)
    setTimeout(() => {
     removeLoadingState(card);
     addLastUpdatedTime();
    }, 1000);
   });
  }, REFRESH_INTERVAL);
 }

 // Initialize everything
 initializeWeatherFeatures();
 setupWeatherRefresh();
});

document.addEventListener("DOMContentLoaded", () => {
 const dropdownToggle = document.getElementById("dropdownToggle");
 const dropdownMenu = document.getElementById("dropdownMenu");

 if (dropdownToggle && dropdownMenu) {
  // Ensure dropdown is closed when clicking outside
  document.addEventListener("click", (event) => {
   if (
    !dropdownToggle.contains(event.target) &&
    !dropdownMenu.contains(event.target)
   ) {
    dropdownMenu.classList.remove("show"); // Close dropdown by removing 'show' class
   }
  });

  // Toggle dropdown visibility when clicking the arrow or image
  dropdownToggle.addEventListener("click", (event) => {
   event.stopPropagation(); // Prevent the click from propagating
   dropdownMenu.classList.toggle("show"); // Toggle visibility using 'show' class
  });
 }
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
