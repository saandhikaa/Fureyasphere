<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $data["title"] ?></title>
    
    <?php if (isset($data["styles"])): ?>
        <?= $data["styles"] ?>
    <?php endif ?>
</head>
    
<body>
    <div id="container">
        <header>
            <h1><?= $data["app"] ?></h1>
            <div class="nav-button">
                <?php if (isset($_SESSION["sign-in"])): ?>
                    <strong><?= $_SESSION["sign-in"]["username"] ?></strong>
                <?php endif ?>
                <button type="button">menu</button>
            </div>
        </header>