document.addEventListener("DOMContentLoaded", function () {
 const newsletterForm = document.getElementById("newsletterForm");

 if (newsletterForm) {
  newsletterForm.addEventListener("submit", function (e) {
   e.preventDefault();

   const emailInput = this.querySelector('input[type="email"]');
   const submitButton = this.querySelector("button");
   const formContainer = document.querySelector(".newsletter-container");

   // Add basic email validation
   const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
   if (!emailRegex.test(emailInput.value)) {
    showNotification("Please enter a valid email address", "error");
    shakeElement(emailInput);
    return;
   }

   // Disable form while submitting
   emailInput.disabled = true;
   submitButton.disabled = true;

   // Add loading animation to button
   submitButton.innerHTML = '<span class="spinner"></span> Subscribing';
   submitButton.classList.add("loading");

   fetch("subscribe.php", {
    method: "POST",
    headers: {
     "Content-Type": "application/x-www-form-urlencoded",
    },
    body: `email=${encodeURIComponent(emailInput.value)}`,
   })
    .then((response) => {
     if (!response.ok) {
      throw new Error(`HTTP error! status: ${response.status}`);
     }
     return response.json();
    })
    .then((data) => {
     if (data.status === "success") {
      showNotification(data.message, "success");
      newsletterForm.reset();

      // Success animation
      formContainer.classList.add("success");
      setTimeout(() => {
       formContainer.classList.remove("success");
      }, 3000);
     } else {
      showNotification(data.message, "error");
      shakeElement(emailInput);
     }
    })
    .catch((error) => {
     console.error("Error:", error);
     showNotification("An error occurred. Please try again later.", "error");
     shakeElement(formContainer);
    })
    .finally(() => {
     // Re-enable form
     emailInput.disabled = false;
     submitButton.disabled = false;
     submitButton.innerHTML = "Subscribe";
     submitButton.classList.remove("loading");
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

 // Add positioning styles
 notification.style.position = "fixed";
 notification.style.top = "20px";
 notification.style.right = "20px";
 notification.style.zIndex = "1000";

 // Add animation classes
 notification.classList.add("notification-slide-in");

 document.body.appendChild(notification);

 // Remove notification after delay
 setTimeout(() => {
  notification.classList.add("notification-fade-out");
  setTimeout(() => {
   notification.remove();
  }, 300);
 }, 5000);
}

function shakeElement(element) {
 element.classList.add("shake");
 setTimeout(() => {
  element.classList.remove("shake");
 }, 500);
}
