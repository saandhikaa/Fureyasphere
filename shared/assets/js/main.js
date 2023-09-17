const greenhex = '#04BA71';
const redhex = '#FF0000';

const navContainer = document.querySelector('.navigation-container');
const navigation = document.querySelector('.navigation-container nav.navigation');
const navGroup = Array.from(navigation.children);
navGroup[1].style.top = navGroup[0].offsetHeight + 'px';
navGroup[1].style.bottom = navGroup[2].offsetHeight + 'px';

document.querySelector('.copyright span').innerHTML = `&copy; ${new Date().getFullYear()}`;



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

Scanning.prototype.passwordVisibility = async element => {
    const input = element.parentElement.querySelector('input');
    const imagePath = document.querySelector('.image-path').textContent;
    
    if (input.type === 'password') {
        input.type = 'text';
        element.innerHTML = await fetch(imagePath + 'icons/visibility_FILL0_wght400_GRAD0_opsz24.svg').then(response => response.text());
    } else {
        input.type = 'password';
        element.innerHTML = await fetch(imagePath + 'icons/visibility_off_FILL0_wght400_GRAD0_opsz24.svg').then(response => response.text());
    }
    
    input.focus();
    thicknessSVG('.passwordVisibility path', '15');
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



const signInUsername = document.querySelector('#sign-in #username');
if (signInUsername) {
    groupInput(signInUsername, event);
}
const signInPassword = document.querySelector('#sign-in #password');
if (signInPassword) {
    groupInput(signInPassword, event);
}

const signUpUsername = document.querySelector('#sign-up #username');
if (signUpUsername) {
    groupInput(signUpUsername, event);
    
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

const signUpPassword = document.querySelector('#sign-up #password');
if (signUpPassword) {
    groupInput(signUpPassword, event);
}

const signUpConfirmPassword = document.querySelector('#sign-up #confirm-password');
if (signUpConfirmPassword) {
    groupInput(signUpConfirmPassword, event);
    
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



function groupInput(element, event) {
    element.addEventListener('focus', event => {
        event.target.parentElement.style.border = '2px solid dodgerblue';
        event.target.parentElement.style.padding = '9px';
    });
    element.addEventListener('blur', event => {
        event.target.parentElement.style.border = '1px solid #999999';
        event.target.parentElement.style.padding = '10px';
    });
}

function thicknessSVG(selector, thickness) {
    const paths = Array.from(document.querySelectorAll(selector));
    paths.forEach(path => {
        path.setAttribute('stroke', 'white');
        path.setAttribute('stroke-width', thickness);
        path.setAttribute('fill', '#333333');
    });
}



const mainListSVG = Array.from(document.querySelectorAll('nav.navigation .main-list path'));
mainListSVG.forEach(path => {
    path.setAttribute('stroke', 'white' );
    path.setAttribute('stroke-width', '20' );
    path.setAttribute('fill', '#333333');
});