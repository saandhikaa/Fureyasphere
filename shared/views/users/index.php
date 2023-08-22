<h1><?= "welcome " . $_SESSION["sign-in"]["username"] ?></h1>
<a href="<?= BASEURL ?>/Clouds">Clouds service</a>

<br>
<br>
<br>

<form action="<?= BASEURL ?>/Users/login" method="post">
    <input type="submit" name="submit" value="Sign Out">
</form>