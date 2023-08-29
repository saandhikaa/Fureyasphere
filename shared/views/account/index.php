<h1><?= "welcome " . $_SESSION["sign-in"]["username"] ?></h1>

<br>
<br>

<a href="<?= BASEURL . '/' . $data['app'] ?>/signout">Sign Out</a>