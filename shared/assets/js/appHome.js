commentMSG = document.querySelector('#comment-message');
if (commentMSG) {
    commentMSG.addEventListener('blur', () => {
        const selectedElements = document.querySelectorAll(".selected");
        selectedElements.forEach(element => {
            element.classList.remove("selected");
        }); 
    });
}

Scanning.prototype.replyThis = element => {
    document.querySelector('input#reply').value = element.getAttribute('data-commentId');
    document.querySelector('form label span').textContent = "Reply";
    
    element.closest('.comment-container').classList.add('selected');
    
    commentMSG.focus();
};
