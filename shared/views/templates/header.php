<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $data["title"] ?></title>
    
    <link rel="stylesheet" href="<?= BASEURL . '/' . $data["mainApp"] ?>/assets/css/style.css">
    <?= isset($data["styles"]) ? $data["styles"] : "" ?>
</head>

<body>
    <header id="page-header">
        <h1><?= ucfirst($data["app"]) ?></h1>
        <button type="button" class="openNav"><span class="openNav"><?= isset($_SESSION["sign-in"]["username"]) ? strtoupper($_SESSION["sign-in"]["username"][0]) : '' ?></span></button>
    </header>
    
    <nav class="navigation closeNav">
        <div class="container">
            <header>
                <h1><?= isset($_SESSION["sign-in"]["username"]) ? $_SESSION["sign-in"]["username"] : "" ?></h1>
                <button type="button" class="closeNav"><span class="closeNav"><?= isset($_SESSION["sign-in"]["username"]) ? strtoupper($_SESSION["sign-in"]["username"][0]) : '' ?></span></button>
            </header>
            <ul>
                <li><a href="<?= BASEURL ?>/home">Home</a></li>
                <li><a href="<?= BASEURL ?>/account">Account</a></li>
            </ul>
            
            <ul>
                <?php foreach (App::getAppListNavigation() as $appControllers): ?>
                    <?php foreach ($appControllers as $controller): ?>
                        <li><a href="<?= BASEURL .  '/' . strtolower($controller) ?>"><?= $controller ?></a></li>
                    <?php endforeach ?>
                <?php endforeach ?>
            </ul>
        </div>
    </nav>