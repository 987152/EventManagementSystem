// Unsplash API credentials (you will need your own Unsplash access key)
const accessKey = 'KeB7mdNjCBg9D9l87--kloLnw6UTaqk9LvpmAaCxafg'; // Your Unsplash access key

/**
 * Fetch a random image from Unsplash and set it as the background image of the specified element
 * @param {string} query - The search term for Unsplash (e.g., 'event', 'conference')
 * @param {string} elementId - The ID of the element to set the background image
 */
async function fetchUnsplashImage(query, elementId) {
    try {
        const response = await fetch(`https://api.unsplash.com/photos/random?query=${query}&client_id=${accessKey}`);
        const data = await response.json();
        
        // Set the background image of the element
        document.getElementById(elementId).style.backgroundImage = `url(${data.urls.regular})`;
    } catch (error) {
        console.error('Error fetching image from Unsplash:', error);
    }
}

// Load images for the homepage (hero section) when the DOM is loaded
window.addEventListener('DOMContentLoaded', () => {
    fetchUnsplashImage('event', 'hero-section'); // Fetch a random event image for the hero section
});

/**
 * Form validation function
 * Validates form inputs for scheduling events or registering/logging in users
 */
function validateForm() {
    const forms = document.querySelectorAll('form');
    
    forms.forEach(form => {
        form.addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent form from submitting immediately
            
            let isValid = true;
            const requiredFields = form.querySelectorAll('input[required], textarea[required], select[required]');
            
            // Check if required fields are filled
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    isValid = false;
                    field.classList.add('is-invalid');
                    field.nextElementSibling.innerText = `${field.getAttribute('name')} is required.`;
                } else {
                    field.classList.remove('is-invalid');
                    field.nextElementSibling.innerText = '';
                }
            });

            // If valid, submit the form
            if (isValid) {
                form.submit();
            }
        });
    });
}

// Run form validation function on DOM load
window.addEventListener('DOMContentLoaded', validateForm);

/**
 * Function to toggle password visibility on login and registration forms
 */
function togglePasswordVisibility() {
    const passwordFields = document.querySelectorAll('.toggle-password');

    passwordFields.forEach(field => {
        field.addEventListener('click', function() {
            const passwordInput = this.previousElementSibling;
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                this.innerText = 'Hide';
            } else {
                passwordInput.type = 'password';
                this.innerText = 'Show';
            }
        });
    });
}

// Run toggle password visibility on DOM load
window.addEventListener('DOMContentLoaded', togglePasswordVisibility);


// Validate the login form before submission
document.getElementById('loginForm').addEventListener('submit', function(event) {
    let isValid = true;
    
    const username = document.getElementById('username');
    const password = document.getElementById('password');
    
    // Simple validation for empty fields
    if (username.value.trim() === '') {
        username.classList.add('is-invalid');
        isValid = false;
    } else {
        username.classList.remove('is-invalid');
    }
    
    if (password.value.trim() === '') {
        password.classList.add('is-invalid');
        isValid = false;
    } else {
        password.classList.remove('is-invalid');
    }
    
    // If not valid, prevent form submission
    if (!isValid) {
        event.preventDefault();
    }
});

