<h1><?= "welcome " . $_SESSION["sign-in"]["username"] ?></h1>

<br>
<br>

<a href="<?= BASEURL . '/' . $data['class'] ?>/signout">Sign Out</a>