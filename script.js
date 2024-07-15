document.addEventListener("DOMContentLoaded", function() {
    // Function to handle redirecting to a specific page
    function redirectTo(page) {
        window.location.href = page;
    }

    document.addEventListener('DOMContentLoaded', function() {
        const flashMessage = document.createElement('div');
        flashMessage.classList.add('flash-message');
        flashMessage.textContent = 'Form submitted successfully!';
        document.body.appendChild(flashMessage);

        setTimeout(function() {
            flashMessage.style.display = 'none';
        }, 3000); // 3000 milliseconds = 3 seconds
    });
    
    // Function to handle form submission
    function handleFormSubmission(formElement, nextFormId, finalForm = false) {
        formElement.addEventListener("submit", function(event) {
            event.preventDefault(); // Prevent form submission

            // Send form data to PHP endpoint using fetch API
            fetch(formElement.action, {
                method: 'POST',
                body: new FormData(formElement)
            })
            .then(response => response.text())
            .then(data => {
                alert(data); // Display server response (for testing)
                if (data.includes("successfully")) {
                    sessionStorage.setItem('loggedIn', true);
                    if (finalForm) {
                        displayFlashMessage("All forms submitted. Thank you!"); // Display flash message
                        setTimeout(() => {
                            redirectTo("home.html"); // Redirect to home.html after message display
                        }, 2000); // Redirect after 2 seconds
                    } else {
                        displayFlashMessage("Form submitted. Proceeding to next form."); // Display flash message
                        setTimeout(() => {
                            redirectTo(nextFormId); // Redirect to next form after message display
                        }, 2000); // Redirect after 2 seconds
                    }
                } else {
                    console.error('Submission failed:', data); // Log error if submission fails
                }
            })
            .catch(error => console.error('Fetch Error:', error)); // Catch any fetch API errors
        });
    }

    // Define form elements and their next form IDs
    const formElements = [
        { form: document.getElementById("per_info_form"), nextFormId: "education_info.html" },
        { form: document.getElementById("education_info"), nextFormId: "home_fam_info.html" },
        { form: document.getElementById("home_fam_info"), nextFormId: "health_info.html" },
        { form: document.getElementById("health_info"), nextFormId: "interests.html" },
        { form: document.getElementById("interests"), nextFormId: "results.html" },
        { form: document.getElementById("results"), nextFormId: "significant.html", finalForm: true } // Final form
    ];

    // Attach event listeners to each form element
    formElements.forEach(element => {
        if (element.form) {
            handleFormSubmission(element.form, element.nextFormId, element.finalForm);
        }
    });

    // Function to handle logout and redirect to landing page
    function logout() {
        sessionStorage.removeItem('loggedIn');
        redirectTo("landing.html");
    }

    // Add click event listener to Logout button
    const logoutBtn = document.querySelector(".logout-btn");
    if (logoutBtn) {
        logoutBtn.addEventListener("click", logout);
    }

    // Function to handle redirecting to home page if logged in, otherwise to landing page
    function handleHomeButton() {
        if (sessionStorage.getItem('loggedIn')) {
            redirectTo("home.html");
        } else {
            redirectTo("landing.html");
        }
    }

    // Add click event listeners to all Home buttons
    const homeBtns = document.querySelectorAll(".home-btn");
    homeBtns.forEach(button => {
        button.addEventListener("click", handleHomeButton);
    });

    // Function to handle redirecting to signup page
    function redirectToSignup() {
        redirectTo("signup.html");
    }

    // Add click event listeners to all Sign Up buttons
    const signupBtns = document.querySelectorAll(".signup-btn");
    signupBtns.forEach(button => {
        button.addEventListener("click", redirectToSignup);
    });

    // Function to handle redirecting to login page
    function redirectToLogin() {
        redirectTo("login.html");
    }

    // Add click event listeners to all Log In buttons
    const loginBtns = document.querySelectorAll(".login-btn");
    loginBtns.forEach(button => {
        button.addEventListener("click", redirectToLogin);
    });

    // Function to handle redirecting to Get Started page
    function redirectToGetStarted() {
        redirectTo("per_info.html");
    }

    // Add click event listener to Get Started button
    const getStartedBtn = document.querySelector(".started-btn");
    if (getStartedBtn) {
        getStartedBtn.addEventListener("click", redirectToGetStarted);
    }

    // Add click event listener to Submit button in significant.html
    const significantSubmitBtn = document.getElementById("significantSubmitBtn");
    if (significantSubmitBtn) {
        significantSubmitBtn.addEventListener("click", function(event) {
            event.preventDefault(); // Prevent form submission (optional if used within a form)
            displayFlashMessage("Form submitted. Thank you!");
            setTimeout(() => {
                redirectTo("home.html"); // Redirect to home.html after message display
            }, 2000); // Redirect after 2 seconds
        });
    }

    // Function to handle form submission for Sign In button in Sign Up form
    function handleSignIn(event) {
        event.preventDefault(); // Prevent form submission

        fetch("http://localhost/Final_forms/signup.php", {
            method: 'POST',
            body: new FormData(document.getElementById("signupForm"))
        })
        .then(response => response.text())
        .then(data => {
            alert(data);
            if (data.includes("successfully")) {
                sessionStorage.setItem('loggedIn', true);
                redirectToHome();
            }
        })
        .catch(error => console.error('Fetch Error:', error));
    }

    // Add submit event listener to Sign In button in Sign Up form
    const signinBtn = document.querySelector(".signin-btn");
    if (signinBtn) {
        signinBtn.addEventListener("click", handleSignIn);
    }

    // Function to handle form submission for Log In button in Log In form
    function handleLogIn(event) {
        event.preventDefault(); // Prevent form submission

        fetch("http://localhost/Final_forms/login.php", {
            method: 'POST',
            body: new FormData(document.getElementById("loginForm"))
        })
        .then(response => response.text())
        .then(data => {
            alert(data);
            if (data.includes("successful")) {
                sessionStorage.setItem('loggedIn', true);
                redirectToHome();
            }
        })
        .catch(error => console.error('Fetch Error:', error));
    }

    // Add submit event listener to Log In button in Log In form
    const loginaccBtn = document.querySelector(".loginacc-btn");
    if (loginaccBtn) {
        loginaccBtn.addEventListener("click", handleLogIn);
    }
});
