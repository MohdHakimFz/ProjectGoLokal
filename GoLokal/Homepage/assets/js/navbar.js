document.addEventListener("DOMContentLoaded", () => {
 const hamburger = document.querySelector(".hamburger");
 const navElements = document.querySelector(".nav-elements");

 hamburger.addEventListener("click", () => {
  navElements.classList.toggle("active");
  hamburger.classList.toggle("active");
 });

 // Close menu when clicking outside
 document.addEventListener("click", (e) => {
  if (!hamburger.contains(e.target) && !navElements.contains(e.target)) {
   navElements.classList.remove("active");
   hamburger.classList.remove("active");
  }
 });
});
