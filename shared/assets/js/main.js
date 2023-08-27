const greenhex = '#04BA71';
const redhex = '#FF0000';

function passwordStatus() {
    const password = document.querySelector('#password');
    const confirmPassword = document.querySelector('#confirm-password');
    const passwordMatchStatus = document.querySelector('#password-match-status');

    if (password.value === confirmPassword.value) {
        passwordMatchStatus.textContent = 'Passwords match';
        passwordMatchStatus.style.color = greenhex;
    } else {
        passwordMatchStatus.textContent = 'Passwords do not match';
        passwordMatchStatus.style.color = redhex;
    }
}

function toggleVisibility(id) {
    const input = document.querySelector(`#${id}`);
    const button = document.querySelector(`#toggle-${id}-visibility`);

    if (input.type === 'password') {
        input.type = 'text';
        button.textContent = 'Hide';
    } else {
        input.type = 'password';
        button.textContent = 'Show';
    }
}


function checkUsernameAvailability() {
    const usernameInput = document.getElementById("username");
    const messageElement = document.getElementById("username-message");
    const username = usernameInput.value;

    let typingTimer;
    let url = window.location.href;
    url.slice(0, url.lastIndexOf('/'));
        
    // Clear the previous timer
    clearTimeout(typingTimer);
    messageElement.textContent = "";
    
    // Start the timer after the user stops typing for a certain interval
    if (username.length > 3) {
        typingTimer = setTimeout(() => {
            // Perform AJAX request to the server
            fetch(url + "usernameavailability", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded"
                },
                body: `username=${encodeURIComponent(username)}`
            })
            .then(response => response.text())
            .then(text => {
                if (text === "taken") {
                    messageElement.textContent = "Already taken.";
                    messageElement.style.color = redhex;
                } else {
                    messageElement.textContent = "Available.";
                    messageElement.style.color = greenhex;
                }
            });
        }, 1000);
    } else {
        // Clear the message and reset the color
        messageElement.textContent = "";
    }
}