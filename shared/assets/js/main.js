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

var typingTimer;
var doneTypingInterval = 1000; // 1 second

function checkUsernameAvailability() {
    var usernameInput = document.getElementById("username");
    var messageElement = document.getElementById("username-message");
    var username = usernameInput.value;

    // Clear the previous timer
    clearTimeout(typingTimer);
    messageElement.textContent = "";
    
    // Start the timer after the user stops typing for a certain interval
    if (username.length > 3) {
        typingTimer = setTimeout(function() {
            // Perform AJAX request to the server
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "http://127.0.0.1:8080/fureya-cloud-service/Users/usernameavailability", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    if (xhr.responseText === "taken") {
                        messageElement.textContent = "Already taken.";
                        messageElement.style.color = redhex;
                    } else {
                        messageElement.textContent = "Available.";
                        messageElement.style.color = greenhex;
                    }
                }
            };
            xhr.send("username=" + encodeURIComponent(username));
        }, doneTypingInterval);
    } else {
        // Clear the message and reset the color
        messageElement.textContent = "";
    }
}
