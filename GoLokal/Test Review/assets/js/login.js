const signUpButton = document.getElementById('signUp');
const signInButton = document.getElementById('signIn');
const container = document.getElementById('container');

// Show Sign Up form and move overlay to the right
signUpButton.addEventListener('click', () => {
  container.classList.add("right-panel-active");
});

// Show Sign In form and move overlay back to the left
signInButton.addEventListener('click', () => {
  container.classList.remove("right-panel-active");
});

document.getElementById('signupForm').addEventListener('submit', function(event) {
  event.preventDefault(); // Prevent form from submitting normally

  // Get form data
  const formData = new FormData(this);

  // Send form data via AJAX to signup.php
  fetch('signup.php', {
      method: 'POST',
      body: formData
  })
  .then(response => response.json()) // Parse JSON response
  .then(data => {
      const statusMessage = document.getElementById('statusMessage');
      
      if (data.status === 'success') {
          statusMessage.innerHTML = data.message;
          statusMessage.style.color = 'green';

          // Redirect to login.html after 3 seconds
          setTimeout(() => {
              window.location.href = 'login.html';
          }, 3000);
      } else {
          statusMessage.innerHTML = data.message;
          statusMessage.style.color = 'red';
      }
  })
  .catch(error => console.error('Error:', error));
});

