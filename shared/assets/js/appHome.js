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
        const cid = element.getAttribute('data-commentId');
        
        document.querySelector('#comment').classList.add('show');
        document.querySelector('input#reply').value = cid;
        document.querySelector('label[for="comment-message"] span').textContent = 'Reply';
        
        const comment = document.querySelector(`[data-cid="${cid}"]`);
        const reply = document.querySelector('section.reply-status');
        
        const replyTitle = document.createElement('p');
        replyTitle.className = 'reply-title';
        replyTitle.textContent = comment.querySelector('p.comment-title').textContent;
        
        const replyMessage = document.createElement('p');
        replyMessage.className = 'reply-message';
        replyMessage.innerHTML = comment.querySelector('p.comment-message').innerHTML;
        
        reply.append(replyTitle, replyMessage);
    } else {
        if (window.confirm('Access denied, sign in needed.\n\nDo you wish to proceed to the sign-in page?')) {
            window.location.href = document.querySelector('.root-path').textContent + '/account/signin/home/comment';
        }
    }
};
