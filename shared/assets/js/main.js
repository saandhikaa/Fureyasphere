const greenhex = '#04BA71';
const redhex = '#FF0000';

function Scanning(){}
const scan = new Scanning();

document.body.addEventListener('click', element => {
    const classes = element.target.className.split(' ');
    
    classes.forEach(className => {
        if (className in scan) {
            scan[className](element.target);
        }
    });
    
    element.stopPropagation();
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



const signUpConfirmPassword = document.querySelector('#sign-up #confirm-password');
if (signUpConfirmPassword) {
    signUpConfirmPassword.addEventListener('input', element => {
        const password = element.target.parentElement.parentElement.querySelector('#password');
        const passwordMatchStatus = element.target.parentElement.parentElement.querySelector('#password-match-status');
        
        if (password.value === element.target.value) {
            passwordMatchStatus.textContent = 'Passwords match';
            passwordMatchStatus.style.color = greenhex;
        } else {
            passwordMatchStatus.textContent = 'Passwords do not match';
            passwordMatchStatus.style.color = redhex;
        }
    });
}

const signUpUsername = document.querySelector('#sign-up #username');
if (signUpUsername) {
    signUpUsername.addEventListener('input', element => {
        const messageElement = element.target.parentElement.querySelector('#username-availability');
        
        let typingTimer;
        
        // Clear the previous timer
        clearTimeout(typingTimer);
        messageElement.textContent = "";
        
        // Start the timer after the user stops typing for a certain interval
        if (element.target.value.length > 3) {
            typingTimer = setTimeout(() => {
                // Perform AJAX request to the server
                const url = window.location.href + '/checkusernameavailability';
                fetch(url, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded"
                    },
                    body: `username=${encodeURIComponent(element.target.value)}`
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
}