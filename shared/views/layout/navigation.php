<header id="page-header">
    <h1 class="app"><?= $data["page-title"] ?></h1>
    <button type="button" class="openNav nav-button mobile"><?= isset($_SESSION["sign-in"]["username"]) ? '<span>' . strtoupper($_SESSION["sign-in"]["username"][0]) . '</span>' : (function() { readfile(__DIR__ . '/../../assets/images/icons/menu_FILL0_wght400_GRAD0_opsz24.svg'); })() ?></button>
    <section class="desktop">
        <?= isset($_SESSION["sign-in"]["username"]) ? '<h1>Hi, ' . $_SESSION["sign-in"]["username"] . '</h1>' : '<h1 class="nav-greeting"></h1>' ?>
    </section>
</header>

<div class="navigation-container closeNav">
    <nav class="navigation">
        <header class="mobile">
            <section>
                <?= isset($_SESSION["sign-in"]["username"]) ? '<h1>Hi, ' . $_SESSION["sign-in"]["username"] . '</h1>' : '<h1 class="nav-greeting"></h1>' ?>
            </section>
            <button type="button" class="closeNav nav-button"><?php readfile(__DIR__ . '/../../assets/images/icons/close_FILL0_wght400_GRAD0_opsz24.svg') ?></button>
            <span class="separator bottom"></span>
        </header>
        
        <section class="list">
            <ul class="main-list row">
                <li><a href="<?= BASEURL ?>/home"><?php readfile(__DIR__ . '/../../assets/images/icons/home_FILL0_wght400_GRAD0_opsz24.svg') ?><span>Home</span></a></li>
                <li><a href="<?= BASEURL ?>/account"><?php readfile(__DIR__ . '/../../assets/images/icons/person_FILL0_wght400_GRAD0_opsz24.svg') ?><span>Account</span></a></li>
            </ul>
            <ul class="app-list row">
                <h6>Services</h6>
                <?php foreach (App::getAppList() as $app): ?>
                    <li><a href="<?= BASEURL .  '/' . strtolower($app["class"][0]) ?>"><?= $app["dir"][1] ?></a></li>
                <?php endforeach ?>
            </ul>
        </section>
        
        <footer>
            <span class="separator top"></span>
            <ul class="row feedback-list">
                <li><a href="<?= BASEURL . '/home/comment' ?>">Leave a Comment</a></li>
                <li><a href="<?= GITHUB . '/' . SITE_TITLE . '/issues' ?>" target="_blank">Create an Issue on GitHub</a></li>
            </ul>
            <p class="copyright">&copy; <?= ME ?> <span></span>.</p>
            <ul class="footer-list mobile">
                <li><a href="<?= BASEURL . '/' . ($data['class'] == 'account' ? 'home' : $data['class']) ?>/about">About</a></li>
                <li><a href="<?= BASEURL ?>/home/resources" target="_blank">Resources</a></li>
                <li><a href="<?= BASEURL ?>/home/terms" target="_blank">Terms</a></li>
                <li><a href="<?= BASEURL ?>/home/privacy" target="_blank">Privacy</a></li>
            </ul>
        </footer>
    </nav>
</div>