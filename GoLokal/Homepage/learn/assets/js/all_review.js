document.addEventListener("DOMContentLoaded", function () {
 // Dropdown menu functionality
 const dropdownToggle = document.getElementById("dropdownToggle");
 const dropdownMenu = document.getElementById("dropdownMenu");

 dropdownToggle.addEventListener("click", function (e) {
  e.stopPropagation();
  dropdownMenu.classList.toggle("show");
 });

 // Close dropdown when clicking outside
 document.addEventListener("click", function (e) {
  if (!dropdownMenu.contains(e.target) && !dropdownToggle.contains(e.target)) {
   dropdownMenu.classList.remove("show");
  }
 });

 // Show loading state when navigating pages
 document.querySelectorAll(".pagination a").forEach((link) => {
  link.addEventListener("click", function () {
   document.getElementById("loading").style.display = "block";
  });
 });

 // Handle image loading errors
 document.querySelectorAll("img").forEach((img) => {
  img.addEventListener("error", function () {
   this.src = "assets/image/default-avatar.png";
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
