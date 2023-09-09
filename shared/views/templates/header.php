<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $data["title"] ?></title>
    
    <link rel="stylesheet" href="<?= BASEURL . '/' . $data["mainApp"] ?>/assets/css/style.css">
    <?= isset($data["styles"]) ? $data["styles"] : "" ?>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@400;500&display=swap" rel="stylesheet">
</head>

<body>
    <header id="page-header">
        <h1><?= ucfirst($data["app"]) ?></h1>
        <button type="button" class="openNav nav-button"><?= isset($_SESSION["sign-in"]["username"]) ? '<span>' . strtoupper($_SESSION["sign-in"]["username"][0]) . '</span>' : (function() { readfile(__DIR__ . '/../../assets/images/icons/menu_FILL0_wght400_GRAD0_opsz24.svg'); })() ?></button>
    </header>
    
    <div class="navigation-container closeNav">
        <nav class="navigation">
            <header>
                <section>
                    <h1><?= isset($_SESSION["sign-in"]["username"]) ? $_SESSION["sign-in"]["username"] : "hello" ?></h1>
                </section>
                <button type="button" class="closeNav nav-button"><?php readfile(__DIR__ . '/../../assets/images/icons/close_FILL0_wght400_GRAD0_opsz24.svg') ?></button>
                <span class="separator bottom"></span>
            </header>
            
            <section class="list">
                <ul class="main-list row">
                    <li><a href="<?= BASEURL ?>/home"><?php readfile(__DIR__ . '/../../assets/images/icons/home_FILL0_wght400_GRAD0_opsz24.svg') ?>Home</a></li>
                    <li><a href="<?= BASEURL ?>/account"><?php readfile(__DIR__ . '/../../assets/images/icons/person_FILL0_wght400_GRAD0_opsz24.svg') ?>Account</a></li>
                </ul>
                <span class="separator"></span>
                <ul class="app-list row">
                    <h6>Services</h6>
                    <?php foreach (App::getAppListNavigation() as $appControllers): ?>
                        <?php foreach ($appControllers as $controller): ?>
                            <li><a href="<?= BASEURL .  '/' . strtolower($controller) ?>"><?= $controller ?></a></li>
                        <?php endforeach ?>
                    <?php endforeach ?>
                </ul>
            </section>
            
            <footer>
                <span class="separator top"></span>
                <ul class="row">
                    <li><a href="https://github.com/saandhikaa" target="_blank">Follow me on GitHub</a></li>
                    <li><a href="">Leave a comment</a></li>
                </ul>
                <p class="copyright"><span></span> <?= ME ?>.</p>
                <ul class="footer-list">
                    <li><a href="">About</a></li>
                    <li><a href="">Resources</a></li>
                    <li><a href="">Terms</a></li>
                    <li><a href="">Privacy</a></li>
                </ul>
            </footer>
        </nav>
    </div>