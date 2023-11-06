Scanning.prototype.newComment = element => {
    if (element.getAttribute('data-isLoggedIn')) {
        document.querySelector('#comment').classList.add('show');
        
        document.body.style.overflow = 'hidden';
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
        replyTitle.innerHTML = comment.querySelector('p.comment-title').innerHTML;
        
        const replyMessage = document.createElement('p');
        replyMessage.className = 'reply-message';
        replyMessage.innerHTML = comment.querySelector('p.comment-message').innerHTML;
        
        reply.append(replyTitle, replyMessage);
        
        document.body.style.overflow = 'hidden';
    } else {
        if (window.confirm('Access denied, sign in needed.\n\nDo you wish to proceed to the sign-in page?')) {
            window.location.href = document.querySelector('.root-path').textContent + '/account/signin/home/comment';
        }
    }
};

Scanning.prototype.newReplyMention = element => {
    if (element.getAttribute('data-isLoggedIn')) {
        const cid = element.getAttribute('data-commentId');
        
        document.querySelector('#comment').classList.add('show');
        document.querySelector('input#reply').value = cid;
        document.querySelector('label[for="comment-message"] span').textContent = 'Reply';
        
        const comment = document.querySelector(`[data-cid="${cid}"]`);
        const reply = document.querySelector('section.reply-status');
        
        const replyTitle = document.createElement('p');
        replyTitle.className = 'reply-title';
        replyTitle.innerHTML = comment.querySelector('p.comment-title').innerHTML;
        
        const replyMessage = document.createElement('p');
        replyMessage.className = 'reply-message';
        replyMessage.innerHTML = comment.querySelector('p.comment-message').innerHTML;
        
        reply.append(replyTitle, replyMessage);
        
        const replyMention = document.createElement('input');
        replyMention.setAttribute('type', 'hidden');
        replyMention.setAttribute('name', 'mention');
        replyMention.setAttribute('value', '1');
        document.querySelector('form').appendChild(replyMention);
        
        document.body.style.overflow = 'hidden';
    } else {
        if (window.confirm('Access denied, sign in needed.\n\nDo you wish to proceed to the sign-in page?')) {
            window.location.href = document.querySelector('.root-path').textContent + '/account/signin/home/comment';
        }
    }
};

Scanning.prototype.showReplies = element => {
    element.closest('li[data-cid]').querySelector('section.comment-replies').classList.add('show');
    
    element.classList.remove('showReplies');
    element.classList.add('hideReplies');
    element.querySelector('span').textContent = 'Hide';
};

Scanning.prototype.hideReplies = element => {
    element.closest('li[data-cid]').querySelector('section.comment-replies').classList.remove('show');
    
    element.classList.add('showReplies');
    element.classList.remove('hideReplies');
    element.querySelector('span').textContent = 'Show';
};

Scanning.prototype.closeCommentPopup = () => {
    document.querySelector('#comment').classList.remove('show');
    setTimeout(function() {
        document.querySelector('section.reply-status').innerHTML = '';
    }, 1000);
    
    document.body.style.overflow = 'auto';
};