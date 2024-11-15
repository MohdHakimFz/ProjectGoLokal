document.addEventListener("DOMContentLoaded", function () {
 const deleteButtons = document.querySelectorAll(".delete-btn");
 const approveButtons = document.querySelectorAll(".approve-btn");

 deleteButtons.forEach((button) => {
  button.addEventListener("click", function () {
   const recordId = this.getAttribute("data-id");

   if (confirm("Are you sure you want to delete this record?")) {
    window.location.href = `delete_record.php?id=${recordId}`;
   }
  });
 });

 approveButtons.forEach((button) => {
  button.addEventListener("click", function () {
   const recordId = this.getAttribute("data-id");

   if (confirm("Are you sure you want to approve this proof image?")) {
    window.location.href = `approve_record.php?id=${recordId}`;
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
