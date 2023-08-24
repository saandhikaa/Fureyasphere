<h1><?= "welcome " . $_SESSION["sign-in"]["username"] ?></h1>

<br>
<br>

<form action="<?= $data['link']['signout'] ?>" method="post">
    <input type="submit" name="submit" value="Sign Out">
</form>