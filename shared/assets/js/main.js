const greenhex = '#04BA71';
const redhex = '#FF0000';

const navContainer = document.querySelector('.navigation-container');
const navigation = document.querySelector('.navigation-container nav.navigation');
const navGroup = Array.from(navigation.children);
const navGap = parseFloat(window.getComputedStyle(navGroup[0]).getPropertyValue('margin-bottom'));
navGroup[2].style.top = (navGroup[0].offsetHeight + navGap + navGroup[1].offsetHeight + navGap) + 'px';
navGroup[2].style.bottom = (navGroup[3].offsetHeight + navGap) + 'px';



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

Scanning.prototype.openNav = () => {
    navigation.style.width = navGroup[0].offsetWidth + 'px';
    navContainer.style.width = '100vw';
    document.body.style.overflow = 'hidden';
};

Scanning.prototype.closeNav = () => {
    navigation.style.width = '0';
    navContainer.style.width = '0';
    document.body.style.overflow = 'auto';
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
        
        if (element.target.value.length > 12) {
            element.target.value = element.target.value.slice(0, 12);
        } 
        
        if (element.target.value.length >= 4) {
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