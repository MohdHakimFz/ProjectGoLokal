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
});

function handleReview(reviewId, action) {
 if (!confirm(`Are you sure you want to ${action} this review?`)) {
  return;
 }

 const formData = new FormData();
 formData.append("review_id", reviewId);
 formData.append("action", action);

 fetch("handle_review.php", {
  method: "POST",
  body: formData,
 })
  .then((response) => response.json())
  .then((data) => {
   if (data.success) {
    // Remove the review card from the UI
    const reviewCard = document.querySelector(`[data-review-id="${reviewId}"]`);
    reviewCard.style.animation = "fadeOut 0.5s";
    setTimeout(() => {
     reviewCard.remove();

     // Check if there are no more reviews
     const remainingReviews = document.querySelectorAll(".review-card");
     if (remainingReviews.length === 0) {
      const reviewsContainer = document.querySelector(".reviews-container");
      reviewsContainer.innerHTML = `
                        <div class="no-reviews">
                            <i class="fas fa-check-circle"></i>
                            <h2>All Caught Up!</h2>
                            <p>There are no pending reviews to approve at the moment.</p>
                        </div>
                    `;
     }
    }, 500);

    // Update the pending reviews count
    const pendingCount = document.querySelector(".stat-item span");
    const currentCount = parseInt(pendingCount.textContent.match(/\d+/)[0]);
    pendingCount.textContent = `Pending Reviews: ${currentCount - 1}`;

    // Show success message
    showNotification(data.message, "success");
   } else {
    showNotification(data.message, "error");
   }
  })
  .catch((error) => {
   showNotification("An error occurred while processing your request", "error");
   console.error("Error:", error);
  });
}

function showNotification(message, type) {
 const notification = document.createElement("div");
 notification.className = `notification ${type}`;
 notification.textContent = message;

 document.body.appendChild(notification);

 // Remove notification after 3 seconds
 setTimeout(() => {
  notification.style.animation = "fadeOut 0.5s";
  setTimeout(() => notification.remove(), 500);
 }, 3000);
}

// Handle image loading errors
document.querySelectorAll("img").forEach((img) => {
 img.addEventListener("error", function () {
  this.src = "uploads/default.png";
 });
});

/* Sticky Header (on Scroll) */
window.addEventListener("scroll", function () {
 const header = document.querySelector("header");
 header.classList.toggle("sticky", window.scrollY > 50);
});
