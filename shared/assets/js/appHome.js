Scanning.prototype.newComment = element => {
    if (element.getAttribute('data-isLoggedIn')) {
        document.querySelector('#comment').classList.add('show');
    } else {
        if (window.confirm('Access denied, sign in needed.\n\nDo you wish to proceed to the sign-in page?')) {
            window.location.href = document.querySelector('.root-path').textContent + '/account/signin/home/comment';
        }
    }
};

Scanning.prototype.newReply = element => {
    if (element.getAttribute('data-isLoggedIn')) {
        document.querySelector('#comment').classList.add('show');
        document.querySelector('input#reply').value = element.getAttribute('data-commentId');
    } else {
        if (window.confirm('Access denied, sign in needed.\n\nDo you wish to proceed to the sign-in page?')) {
            window.location.href = document.querySelector('.root-path').textContent + '/account/signin/home/comment';
        }
    }
};
