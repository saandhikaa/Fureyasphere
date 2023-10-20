<h1><?= "welcome " . $_SESSION["sign-in"]["username"] ?></h1>

<br>
<br>

<?php if ($_SESSION["sign-in"]["username"] === ADMIN_USERNAME): ?>
    <a href="<?= BASEURL . '/' . $data['class'] ?>/setup">Setup</a>
<?php else: ?>
    <form action="<?= BASEURL . '/' . $data['class'] ?>/delete" method="post"><input type="submit" value="Deleted my account"></form>
<?php endif ?>

<br>
<br>

<a href="<?= BASEURL . '/' . $data['class'] ?>/signout">Sign Out</a>