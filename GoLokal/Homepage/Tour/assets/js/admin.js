document.addEventListener("DOMContentLoaded", function () {
 const dropdownToggle = document.getElementById("dropdownToggle");
 const dropdownMenu = document.getElementById("dropdownMenu");

 // Toggle the dropdown menu when the button is clicked
 dropdownToggle.addEventListener("click", function () {
  dropdownMenu.classList.toggle("show");
 });

 // Close the dropdown menu if the user clicks outside of it
 window.addEventListener("click", function (event) {
  if (
   !event.target.matches("#dropdownToggle") &&
   !dropdownMenu.contains(event.target)
  ) {
   if (dropdownMenu.classList.contains("show")) {
    dropdownMenu.classList.remove("show");
   }
  }
 });
});

document
 .getElementById("dropdownToggle")
 .addEventListener("click", function () {
  var menu = document.getElementById("dropdownMenu");
  menu.style.display = menu.style.display === "block" ? "none" : "block";
 });
document.querySelector(".nav-toggle").addEventListener("click", function () {
 document.querySelector(".nav-menu").classList.toggle("active");
});
