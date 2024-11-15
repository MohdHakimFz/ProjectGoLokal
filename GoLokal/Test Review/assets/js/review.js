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

// SLIDER FUNCTIONALITY
const slides = document.querySelector(".slides");
const prevBtn = document.querySelector(".prev");
const nextBtn = document.querySelector(".next");
const dots = document.querySelectorAll(".dot");
const destinationBoxes = document.querySelectorAll(".destination-box"); // All destination info boxes

let currentSlide = 0;
const totalSlides = document.querySelectorAll(".slide").length;

if (slides && prevBtn && nextBtn) {
 // Trigger text animation on destination box
 function triggerTextAnimation() {
  if (destinationBoxes[currentSlide]) {
   const currentDestinationBox = destinationBoxes[currentSlide];

   // Remove previous visibility states
   currentDestinationBox.classList.remove("visible", "hidden");

   // Add zoom-out animation (hidden state)
   currentDestinationBox.classList.add("hidden");

   // Wait until zoom-out finishes, then zoom-in
   setTimeout(() => {
    currentDestinationBox.classList.remove("hidden");
    currentDestinationBox.classList.add("visible");
   }, 500); // Match with CSS transition duration
  }
 }

 // Update the slider position and handle animations
 function updateSlide() {
  const slideWidth = document.querySelector(".slider").offsetWidth;
  slides.style.transform = `translateX(-${currentSlide * slideWidth}px)`; // Use backticks for string interpolation

  // Trigger zoom-in animation after slide change
  setTimeout(() => {
   const currentDestinationBox = destinationBoxes[currentSlide];
   if (currentDestinationBox) {
    currentDestinationBox.classList.remove("hidden");
    currentDestinationBox.classList.add("visible");
   }
  }, 500); // Match with CSS animation duration

  // Update the dots to reflect the active slide
  updateDots();
 }

 // Handle the click on the next button
 nextBtn.addEventListener("click", () => {
  triggerTextAnimation(); // Trigger zoom-out animation
  setTimeout(() => {
   currentSlide = (currentSlide + 1) % totalSlides; // Increment the slide
   updateSlide(); // Update the slider position
  }, 500); // Delay to match the animation
 });

 // Handle the click on the previous button
 prevBtn.addEventListener("click", () => {
  triggerTextAnimation(); // Trigger zoom-out animation
  setTimeout(() => {
   currentSlide = (currentSlide - 1 + totalSlides) % totalSlides; // Decrement the slide
   updateSlide(); // Update the slider position
  }, 500); // Delay to match the animation
 });

 // Update the active dot (pagination)
 function updateDots() {
  dots.forEach((dot, index) => {
   dot.classList.remove("active-dot");
   if (index === currentSlide) {
    dot.classList.add("active-dot");
   }
  });
 }

 // Initial call to set the first dot as active
 updateDots();
}

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
