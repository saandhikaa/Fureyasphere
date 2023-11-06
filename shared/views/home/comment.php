<main id="comment">
    <h1>Comment section</h1>
    
    <ul class="comment-list root">
        <?php foreach ($data["comment-lists"] as $comment): ?>
            <li data-cid="<?= $comment["id"] ?>">
                <p class="comment-title"><strong><?= $comment["username"] ?></strong> at <span class="time"><?= $comment["time"] ?></span></p>
                <p class="comment-message"><?= $comment["message"] ?></p>
                <ul class="comment-action">
                    <li><button class="newReply" data-commentId="<?= $comment["id"] ?>" data-isLoggedIn="<?= isset($_SESSION["sign-in"]) ? $_SESSION["sign-in"]["username"] : false ?>">Reply</button></li>
                    <?php if (!empty($comment["replies"])): ?><li><button class="showReplies" data-commentId="<?= $comment["id"] ?>"><span>Show</span><?= count($comment["replies"]) > 1 ? " " . count($comment["replies"]) . " replies" : " a reply"?></button></li><?php endif ?>
                </ul>
                
                <section class="comment-replies">
                    <ul class="comment-list">
                        <?php foreach ($comment["replies"] as $reply): ?>
                            <li data-cid="<?= $reply["id"] ?>">
                                <p class="comment-title"><strong><?= $reply["username"] ?></strong> at <span class="time"><?= $reply["time"] ?></span></p>
                                <p class="comment-message"><?= $reply["message"] ?></p>
                                <ul class="comment-action">
                                    <li><button class="newReplyMention" data-commentId="<?= $reply["id"] ?>" data-isLoggedIn="<?= isset($_SESSION["sign-in"]) ? $_SESSION["sign-in"]["username"] : false ?>">Reply</button></li>
                                </ul>
                            </li>
                        <?php endforeach ?>
                    </ul>
                </section>
            </li>
        <?php endforeach ?>
    </ul>
    
    <button class="newComment" data-isLoggedIn="<?= isset($_SESSION["sign-in"]) ? $_SESSION["sign-in"]["username"] : false ?>">Add comment</button>
    
    <?php if (isset($_SESSION["sign-in"])): ?>
        <div class="comment-container closeCommentPopup">
            <section class="comment-popup">
                <form action="" method="post">
                    <input id="reply" type="hidden" name="replied" value="0">
                    <section class="reply-status"></section>
                    
                    <label for="comment-message"><span>Comment</span> as <?= $_SESSION["sign-in"]["username"] ?></label>
                    <textarea id="comment-message" spellcheck="false" name="message" placeholder="Enter your message... <b> and <i> tags are available"></textarea>
                    
                    <section class="action">
                        <button type="button" class="button cancel closeCommentPopup">Cancel</button>
                        <input type="submit" name="submit" class="button send" value="Send">
                    </section>
                </form>
            </section>
        </div>
    <?php endif ?>
</main>