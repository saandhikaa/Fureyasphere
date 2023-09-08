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
        <button type="button" class="openNav"><?= isset($_SESSION["sign-in"]["username"]) ? '<span class="openNav">' . strtoupper($_SESSION["sign-in"]["username"][0]) . '</span>' : '<img class="openNav" src="' . BASEURL . '/' . $data["mainApp"] . '/assets/images/icons/menu_FILL0_wght400_GRAD0_opsz24.svg" alt="">' ?></button>
    </header>
    
    <div class="navigation-container closeNav">
        <nav class="navigation">
            <header>
                <section>
                    <h1><?= isset($_SESSION["sign-in"]["username"]) ? $_SESSION["sign-in"]["username"] : "hello" ?></h1>
                </section>
                <button type="button" class="closeNav"><img class="closeNav" src="<?= BASEURL . '/' . $data["mainApp"] ?>/assets/images/icons/close_FILL0_wght400_GRAD0_opsz24.svg" alt=""></button>
                <span class="separator bottom"></span>
            </header>
            
            <section class="main-list">
                <ul class="row">
                    <li><a href="<?= BASEURL ?>/home"><img src="<?= BASEURL . '/' . $data["mainApp"] ?>/assets/images/icons/home_FILL0_wght400_GRAD0_opsz24.svg" alt="">Home</a></li>
                    <li><a href="<?= BASEURL ?>/account"><img src="<?= BASEURL . '/' . $data["mainApp"] ?>/assets/images/icons/person_FILL0_wght400_GRAD0_opsz24.svg" alt="">Account</a></li>
                </ul>
                <span class="separator bottom"></span>
            </section>
            
            <section class="app-list">
                <ul class="row">
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
                    <li><a href="">Terms</a></li>
                    <li><a href="">Privacy</a></li>
                </ul>
            </footer>
        </nav>
    </div>