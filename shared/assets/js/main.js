const greenhex = '#04BA71';
const redhex = '#FF0000';

function Scanning(){}
const scan = new Scanning();

document.body.addEventListener("click", event => {
    const classes = event.target.className.split(' ');
    
    classes.forEach(className => {
        if (className in scan) {
            scan[className](event.target);
        }
    });
    
    event.stopPropagation();
});

Scanning.prototype.passwordVisibility = element => {
    const input = element.parentElement.querySelector('input');
    
    if (input.type === 'password') {
        input.type = 'text';
        element.textContent = 'Hide';
    } else {
        input.type = 'password';
        element.textContent = 'Show';
    }
};



document.querySelector('#sign-up #confirm-password').addEventListener('input', () => {
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
});

document.querySelector('#sign-up #username').addEventListener('input', () => {
    const usernameInput = document.querySelector('#sign-up #username').value;
    const messageElement = document.querySelector('#sign-up #username-availability');

    let typingTimer;
    
    // Clear the previous timer
    clearTimeout(typingTimer);
    messageElement.textContent = "";
    
    // Start the timer after the user stops typing for a certain interval
    if (usernameInput.length > 3) {
        typingTimer = setTimeout(() => {
            let url = window.location.href;
            url += "/checkusernameavailability";
            
            // Perform AJAX request to the server
            fetch(url, {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded"
                },
                body: `username=${encodeURIComponent(usernameInput)}`
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
});