function passwordStatus() {
    const password = document.querySelector('#password');
    const confirmPassword = document.querySelector('#confirm-password');
    const passwordMatchStatus = document.querySelector('#password-match-status');

    if (password.value === confirmPassword.value) {
        passwordMatchStatus.textContent = 'Passwords match';
    } else {
        passwordMatchStatus.textContent = 'Passwords do not match';
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