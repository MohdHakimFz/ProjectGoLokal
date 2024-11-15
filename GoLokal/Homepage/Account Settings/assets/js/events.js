document.addEventListener("DOMContentLoaded", function () {
 const calendar = {
  date: new Date(),
  events: [], // Will be populated with PHP events data

  init: function () {
   this.monthDisplay = document.getElementById("currentMonth");
   this.daysContainer = document.getElementById("calendarDays");
   this.prevButton = document.getElementById("prevMonth");
   this.nextButton = document.getElementById("nextMonth");

   // Get events from DOM
   document.querySelectorAll(".event-card").forEach((card) => {
    this.events.push({
     date: new Date(card.dataset.date),
     state: card.dataset.state,
     element: card,
    });
   });

   this.bindEvents();
   this.render();
  },

  bindEvents: function () {
   this.prevButton.addEventListener("click", () => {
    this.date.setMonth(this.date.getMonth() - 1);
    this.render();
   });

   this.nextButton.addEventListener("click", () => {
    this.date.setMonth(this.date.getMonth() + 1);
    this.render();
   });
  },

  render: function () {
   const year = this.date.getFullYear();
   const month = this.date.getMonth();

   // Update month display
   this.monthDisplay.textContent = new Date(year, month, 1).toLocaleDateString(
    "en-US",
    { month: "long", year: "numeric" }
   );

   // Clear previous days
   this.daysContainer.innerHTML = "";

   // Get first day of month and total days
   const firstDay = new Date(year, month, 1).getDay();
   const totalDays = new Date(year, month + 1, 0).getDate();

   // Add empty cells for days before first of month
   for (let i = 0; i < firstDay; i++) {
    this.daysContainer.appendChild(this.createDayElement());
   }

   // Add days of month
   for (let day = 1; day <= totalDays; day++) {
    const date = new Date(year, month, day);
    const dayElement = this.createDayElement(day, date);

    // Check for events on this day
    const dayEvents = this.events.filter(
     (event) =>
      event.date.getDate() === day &&
      event.date.getMonth() === month &&
      event.date.getFullYear() === year
    );

    if (dayEvents.length > 0) {
     dayElement.classList.add("has-events");
     dayElement.appendChild(this.createEventDot(dayEvents.length));

     // Add click handler to show events
     dayElement.addEventListener("click", () => {
      this.showEvents(dayEvents);
     });
    }

    this.daysContainer.appendChild(dayElement);
   }
  },

  createDayElement: function (day, date) {
   const div = document.createElement("div");
   div.className = "calendar-day";

   if (day) {
    div.textContent = day;

    // Check if this is today
    const today = new Date();
    if (date.toDateString() === today.toDateString()) {
     div.classList.add("today");
    }
   }

   return div;
  },

  createEventDot: function (count) {
   const dot = document.createElement("span");
   dot.className = "event-dot";
   return dot;
  },

  showEvents: function (events) {
   // Hide all event cards
   document.querySelectorAll(".event-card").forEach((card) => {
    card.style.display = "none";
   });

   // Show only events for selected day
   events.forEach((event) => {
    event.element.style.display = "block";
   });

   // Update selected state in calendar
   document.querySelectorAll(".calendar-day").forEach((day) => {
    day.classList.remove("selected");
   });
   event.currentTarget.classList.add("selected");
  },
 };

 // Initialize calendar
 calendar.init();

 // State filter handling
 const stateFilter = document.getElementById("stateFilter");
 stateFilter.addEventListener("change", function () {
  const selectedState = this.value;

  document.querySelectorAll(".event-card").forEach((card) => {
   if (!selectedState || card.dataset.state.includes(selectedState)) {
    card.style.display = "block";
   } else {
    card.style.display = "none";
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
