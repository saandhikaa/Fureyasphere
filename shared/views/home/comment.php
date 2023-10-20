<main id="comment">
    <?php foreach ($data["comment-lists"] as $comment): ?>
        <p><strong><?= $comment["username"] ?></strong> <span class="time"><?= $comment["time"] ?></span></p>
        <p><?= $comment["message"] ?></p>
        <br>
    <?php endforeach ?>
    
    <?php if (isset($_SESSION["sign-in"])): ?>
        <form action="" method="post">
            <label for="comment-message">Comment</label>
            <input type="text" id="comment-message" name="message">
            
            <input type="hidden" name="mentioned" value="0">
            
            <input type="submit" name="submit" value="send">
        </form>
    <?php else: ?>
        <a href="<?= BASEURL . '/account/signin' ?>">Sign in to Comment</a>
    <?php endif ?>
</main>