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

/* Sticky Header (on Scroll) */
window.addEventListener("scroll", function () {
 const header = document.querySelector("header");
 header.classList.toggle("sticky", window.scrollY > 50);
});
