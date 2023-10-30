<main id="comment">
    <h1>Comment section</h1>
    <ul class="comment-list-level1">
        <?php foreach ($data["comment-lists"] as $comment): ?>
            <li class="level1">
                <section class="comment-container">
                    <p><strong><?= $comment["username"] ?></strong> <span class="time"><?= $comment["time"] ?></span></p>
                    <p><?= $comment["message"] ?></p>
                    <ul class="comment-action">
                        <li><button class="likeThis" data-commentId="<?= $comment["id"] ?>">Like</button></li>
                        <li><button class="replyThis" data-commentId="<?= $comment["id"] ?>">Reply</button></li>
                        <li><button class="showReplies" data-commentId="<?= $comment["id"] ?>">Show replies</button></li>
                    </ul>
                </section>
                
                <?php if (!empty($comment["replies"])): ?>
                    <ul class="comment-list-level2">
                        <?php foreach ($comment["replies"] as $reply): ?>
                            <li class="comment-container level2">
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
                
                <label for="comment-message"><span class="status">Comment</span> as <?= $_SESSION["sign-in"]["username"] ?></label>
                <section class="field">
                    <textarea id="comment-message" name="message" rows="1" placeholder="Write a comment (<b> and <i> tags available)"></textarea>
                    <input type="submit" name="submit" value="send">
                </section>
            </form>
        <?php else: ?>
            <a href="<?= BASEURL . '/account/signin' ?>" class="redirect">Sign in to Comment</a>
        <?php endif ?>
    </section>
</main>