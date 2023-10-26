<main id="comment">
    <ul class="comment-root">
        <?php foreach ($data["comment-lists"] as $comment): ?>
            <li class="comment-field">
                <p><strong><?= $comment["username"] ?></strong> <span class="time"><?= $comment["time"] ?></span></p>
                <p><?= $comment["message"] ?></p>
                <ul class="comment-action">
                    <li><button>Like</button></li>
                    <li><button>Reply</button></li>
                    <li><button>Show replies</button></li>
                </ul>
            </li>
        <?php endforeach ?>
    </ul>
    
    <section class="add-comment">
        <?php if (isset($_SESSION["sign-in"])): ?>
            <form action="" method="post">
                <input type="hidden" name="replied" value="0">
                
                <section class="field">
                    <label for="comment-message">Comment</label>
                    <input type="text" id="comment-message" name="message">
                </section>
                
                <input type="submit" name="submit" value="send">
            </form>
        <?php else: ?>
            <a href="<?= BASEURL . '/account/signin' ?>" class="redirect">Sign in to Comment</a>
        <?php endif ?>
    </section>
</main>