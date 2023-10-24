<main id="account">
    <h1><?= "welcome " . $_SESSION["sign-in"]["username"] ?></h1>
    
    <?php if ($_SESSION["sign-in"]["username"] === ADMIN_USERNAME): ?>
        <a href="<?= BASEURL . '/' . $data['class'] ?>/setup">Setup</a>
    <?php else: ?>
        <form action="<?= BASEURL . '/' . $data['class'] ?>/delete" method="post" onsubmit="return confirm('Are you sure you want to delete your account?');">
            <input type="submit" value="Delete my account">
        </form>
    <?php endif ?>
    
    <a href="<?= BASEURL . '/' . $data['class'] ?>/signout">Sign Out</a>
</main>