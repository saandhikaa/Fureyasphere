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