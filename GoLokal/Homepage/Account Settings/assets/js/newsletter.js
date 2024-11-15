document.addEventListener("DOMContentLoaded", function () {
 const newsletterForm = document.getElementById("newsletterForm");

 if (newsletterForm) {
  newsletterForm.addEventListener("submit", function (e) {
   e.preventDefault();

   const emailInput = this.querySelector('input[type="email"]');
   const submitButton = this.querySelector("button");

   // Disable form while submitting
   emailInput.disabled = true;
   submitButton.disabled = true;
   submitButton.innerHTML = "Subscribing...";

   fetch("subscribe.php", {
    method: "POST",
    headers: {
     "Content-Type": "application/x-www-form-urlencoded",
    },
    body: `email=${encodeURIComponent(emailInput.value)}`,
   })
    .then((response) => response.json())
    .then((data) => {
     if (data.status === "success") {
      showNotification(data.message, "success");
      newsletterForm.reset();
     } else {
      showNotification(data.message, "error");
     }
    })
    .catch((error) => {
     console.error("Error:", error);
     showNotification("An error occurred. Please try again later.", "error");
    })
    .finally(() => {
     // Re-enable form
     emailInput.disabled = false;
     submitButton.disabled = false;
     submitButton.innerHTML = "Subscribe";
    });
  });
 }
});

function showNotification(message, type) {
 // Remove any existing notifications
 const existingNotifications = document.querySelectorAll(".notification");
 existingNotifications.forEach((notification) => notification.remove());

 // Create new notification
 const notification = document.createElement("div");
 notification.className = `notification ${type}`;
 notification.textContent = message;

 document.body.appendChild(notification);

 // Remove notification after delay
 setTimeout(() => {
  notification.classList.add("hide");
  setTimeout(() => {
   notification.remove();
  }, 500);
 }, 5000);
}
