document.addEventListener("DOMContentLoaded", function () {
 const form = document.querySelector("form");

 form.addEventListener("submit", function (event) {
  const title = form.title.value.trim();
  const description = form.description.value.trim();
  const challengePoints = form.challenge_points.value.trim();
  const proofImage = form.proof_image_path.files.length;

  if (!title || !description || !challengePoints || proofImage === 0) {
   alert("Please fill in all fields and upload a proof image.");
   event.preventDefault(); // Prevent form submission
  }
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
