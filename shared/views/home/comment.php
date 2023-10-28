<main id="comment">
    <ul class="comment-root">
        <?php foreach ($data["comment-lists"] as $comment): ?>
            <li class="comment-field">
                <p><strong><?= $comment["username"] ?></strong> <span class="time"><?= $comment["time"] ?></span></p>
                <p><?= $comment["message"] ?></p>
                <ul class="comment-action">
                    <li><button class="likeThis" data-commentId="<?= $comment["id"] ?>">Like</button></li>
                    <li><button class="replyThis" data-commentId="<?= $comment["id"] ?>">Reply</button></li>
                    <li><button class="showReplies" data-commentId="<?= $comment["id"] ?>">Show replies</button></li>
                </ul>
                <?php if (!empty($comment["replies"])): ?>
                    <ul class="comment-child">
                        <?php foreach ($comment["replies"] as $reply): ?>
                            <li class="comment-field">
                                <p><strong><?= $reply["username"] ?></strong> <span class="time"><?= $reply["time"] ?></span></p>
                                <p><?= $reply["message"] ?></p>
                                <ul class="comment-action">
                                    <li><button class="likeThis" data-commentId="<?= $reply["id"] ?>">Like</button></li>
                                    <li><button class="mentionThis" data-commentId="<?= $reply["id"] ?>">Reply</button></li>
                                </ul>
                            </li>
                        <?php endforeach ?>
                    </ul>
                <?php endif ?>
            </li>
        <?php endforeach ?>
    </ul>
    
    <section class="add-comment">
        <?php if (isset($_SESSION["sign-in"])): ?>
            <form action="" method="post">
                <input id="reply" type="hidden" name="replied" value="0">
                
                <section class="field">
                    <label for="comment-message"><span class="status">Comment</span> as <?= $_SESSION["sign-in"]["username"] ?></label>
                    <textarea id="comment-message" name="message" rows="1"></textarea>
                </section>
                
                <input type="submit" name="submit" value="send">
            </form>
        <?php else: ?>
            <a href="<?= BASEURL . '/account/signin' ?>" class="redirect">Sign in to Comment</a>
        <?php endif ?>
    </section>
</main>