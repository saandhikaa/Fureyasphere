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
            <h1><?= ucfirst($data["app"]) ?></h1>
            <div class="nav-button">
                <?php if (isset($_SESSION["sign-in"])): ?>
                    <strong><?= $_SESSION["sign-in"]["username"] ?></strong>
                <?php endif ?>
                <button type="button">menu</button>
            </div>
        </header>
        
        <nav>
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
        </nav>