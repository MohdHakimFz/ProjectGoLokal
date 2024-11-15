document.addEventListener("DOMContentLoaded", function () {
 const formElements = document.querySelectorAll("form");

 formElements.forEach((form) => {
  form.addEventListener("submit", function (event) {
   const proofFile = this.querySelector('input[type="file"]').files[0];

   if (!proofFile) {
    alert("Please upload proof before submitting!");
    event.preventDefault(); // Prevent form submission
   } else {
    const fileType = proofFile.type;
    const validImageTypes = ["image/jpeg", "image/png", "image/gif"];

    if (!validImageTypes.includes(fileType)) {
     alert("Invalid file type. Please upload a JPEG, PNG, or GIF image.");
     event.preventDefault(); // Prevent form submission
    }
   }
  });
 });
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

// Add this to your earn.js file or in a script tag
document.addEventListener("DOMContentLoaded", function () {
 const messages = document.querySelectorAll(".message");

 messages.forEach((message) => {
  // Hide message after 5 seconds
  setTimeout(() => {
   message.classList.add("hide");
   // Remove from DOM after animation completes
   setTimeout(() => {
    message.remove();
   }, 500);
  }, 5000);
 });
});
