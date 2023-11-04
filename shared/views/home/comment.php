<main id="comment">
    <h1>Comment section</h1>
    
    <ul class="comment-list root">
        <?php foreach ($data["comment-lists"] as $comment): ?>
            <li>
                <p class="username"><strong><?= $comment["username"] ?></strong> <span class="time"><?= $comment["time"] ?></span></p>
                <p class="message"><?= $comment["message"] ?></p>
                <ul class="comment-action">
                    <li><button class="likeThis" data-commentId="<?= $comment["id"] ?>" data-isLoggedIn="<?= isset($_SESSION["sign-in"]) ? $_SESSION["sign-in"]["username"] : false ?>">Like</button></li>
                    <li><button class="newReply" data-commentId="<?= $comment["id"] ?>" data-isLoggedIn="<?= isset($_SESSION["sign-in"]) ? $_SESSION["sign-in"]["username"] : false ?>">Reply</button></li>
                    <li><button class="showReplies" data-commentId="<?= $comment["id"] ?>">Show replies</button></li>
                </ul>
                
                <section class="comment-replies">
                    <ul class="comment-list">
                        <?php foreach ($comment["replies"] as $reply): ?>
                            <li>
                                <p class="username"><strong><?= $reply["username"] ?></strong> <span class="time"><?= $reply["time"] ?></span></p>
                                <p class="message"><?= $reply["message"] ?></p>
                                <ul class="comment-action">
                                    <li><button class="likeThis" data-commentId="<?= $reply["id"] ?>" data-isLoggedIn="<?= isset($_SESSION["sign-in"]) ? $_SESSION["sign-in"]["username"] : false ?>">Like</button></li>
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
</main>