<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $data["title"] ?></title>
    <?php
        if (isset($data["styles"])) {
            echo $data["styles"];
        }
    ?>
</head>
    
<body>
    <?php if (isset($_SESSION["sign-in"])): ?>
        <strong><?= $_SESSION["sign-in"]["username"] ?></strong>
        <br>
        <br>
        <br>
    <?php endif ?>