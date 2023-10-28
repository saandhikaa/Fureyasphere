Scanning.prototype.passwordVisibility = async element => {
    const input = element.parentElement.querySelector('input');
    const imagePath = document.querySelector('.image-path').textContent;
    
    input.focus();
    
    if (input.type === 'password') {
        input.type = 'text';
        element.innerHTML = await fetch(imagePath + 'icons/visibility_FILL0_wght400_GRAD0_opsz24.svg').then(response => response.text());
    } else {
        input.type = 'password';
        element.innerHTML = await fetch(imagePath + 'icons/visibility_off_FILL0_wght400_GRAD0_opsz24.svg').then(response => response.text());
    }
    
    input.setSelectionRange(input.value.length, input.value.length);
    thicknessSVG('.passwordVisibility path', '15');
};



const signInUsername = document.querySelector('#sign-in #username');
if (signInUsername) {
    groupInput(signInUsername, event, 8);
}
const signInPassword = document.querySelector('#sign-in #password');
if (signInPassword) {
    groupInput(signInPassword, event, 8);
}

let typingTimer;
const signUpUsername = document.querySelector('#sign-up #username');
if (signUpUsername) {
    groupInput(signUpUsername, event, 8);
    
    signUpUsername.addEventListener('input', element => {
        document.querySelector('.validation.username-availability').classList.remove('pass');
        document.querySelector('.validation.username-availability').classList.remove('not-pass');
        signUpValidation();
        clearTimeout(typingTimer);
        
        if (element.target.value.length >= 3 && element.target.value.length <= 12) {
            typingTimer = setTimeout(async () => {
                const url = window.location.href + '/checkusernameavailability';
                await fetch(url, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded"
                    },
                    body: `username=${encodeURIComponent(element.target.value)}`
                })
                .then(response => response.text())
                .then(text => {
                    if (text === "available") {
                        document.querySelector('.validation.username-availability').classList.add('pass');
                        document.querySelector('.validation.username-availability').classList.remove('not-pass');
                    } else {
                        document.querySelector('.validation.username-availability').classList.remove('pass');
                        document.querySelector('.validation.username-availability').classList.add('not-pass');
                    }
                    signUpValidation();
                });
            }, 1000);
            
            document.querySelector('.validation.username-length').classList.add('pass');
        } else if (element.target.value.length > 12) {
            document.querySelector('.validation.username-availability').classList.remove('pass');
            document.querySelector('.validation.username-availability').classList.add('not-pass');
            document.querySelector('.validation.username-length').classList.remove('pass');
            document.querySelector('.validation.username-length').classList.add('not-pass');
        } else {
            document.querySelector('.validation.username-availability').classList.remove('pass');
            document.querySelector('.validation.username-availability').classList.remove('not-pass');
            document.querySelector('.validation.username-length').classList.remove('pass');
            document.querySelector('.validation.username-length').classList.remove('not-pass');
        }
        
        if (element.target.value.length > 0) {
            if (usernameFormat(element.target.value.trim())) {
                document.querySelector('.validation.username-format').classList.add('pass');
                document.querySelector('.validation.username-format').classList.remove('not-pass');
            } else {
                document.querySelector('.validation.username-format').classList.remove('pass');
                document.querySelector('.validation.username-format').classList.add('not-pass');
            }
        } else {
            document.querySelector('.validation.username-format').classList.remove('pass');
            document.querySelector('.validation.username-format').classList.remove('not-pass');
        }
        
        signUpValidation();
    });
}

const signUpPassword = document.querySelector('#sign-up #password');
if (signUpPassword) {
    groupInput(signUpPassword, event, 8);
    signUpPassword.addEventListener('input', () => matchingPassword());
}

const signUpConfirmPassword = document.querySelector('#sign-up #confirm-password');
if (signUpConfirmPassword) {
    groupInput(signUpConfirmPassword, event, 8);
    signUpConfirmPassword.addEventListener('input', () => matchingPassword());
}

const signUpAgreement = document.querySelector('#sign-up .agreement input[type="checkbox"]');
if (signUpAgreement) {
    signUpAgreement.addEventListener('change', () => matchingPassword());
}



function matchingPassword() {
    const password = document.querySelector('#sign-up #password').value;
    const confirm = document.querySelector('#sign-up #confirm-password').value;
    
    if (password.length > 0 && confirm.length > 0) {
        if (password === confirm) {
            document.querySelector('.validation.passwords-match').classList.add('pass');
            document.querySelector('.validation.passwords-match').classList.remove('not-pass');
        } else {
            document.querySelector('.validation.passwords-match').classList.remove('pass');
            document.querySelector('.validation.passwords-match').classList.add('not-pass');
        }
    } else {
        document.querySelector('.validation.passwords-match').classList.remove('pass');
        document.querySelector('.validation.passwords-match').classList.remove('not-pass');
    }
    
    signUpValidation();
}

function signUpValidation() {
    const paths = Array.from(document.querySelectorAll('.validation path'));
    let required = 0;
    
    paths.forEach(path => {
        const validation = path.parentElement.parentElement.classList;
        if (validation.contains('pass')) {
            path.setAttribute('fill', '#04BA71');
            required++;
        } else if (validation.contains('not-pass')) {
            path.setAttribute('fill', '#FF0000');
        } else {
            path.setAttribute('fill', '#AAAAAA');
        }
    });
    
    document.querySelector('#su-submit').disabled = required != paths.length || !signUpAgreement.checked;
}

function usernameFormat(inputString) {
    let pattern = /^[a-zA-Z0-9-]+$/;
    return pattern.test(inputString);
}
