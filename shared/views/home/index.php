<?php
    function getDesc($path) {
        $fileLines = file($path);
        
        if ($fileLines !== false) {
            foreach ($fileLines as $line) {
                $trimmedLine = trim($line);
                if (!empty($trimmedLine) && $trimmedLine[0] !== '#') {
                    return $trimmedLine;
                    break;
                }
            }
        }
    }
?>

<h1>Welcome to <?= SITE_TITLE ?></h1>

<p><?= getDesc(__DIR__ . "/../../../README.md") ?></p>

<ul class="app-list">
    <?php foreach (App::getAppList() as $app): ?>
        <li>
            <h2><?= $app["dir"][1] ?></h2>
            <p><?= getDesc(__DIR__ . "/../../../" . $app["dir"][0] . "/README.md") ?></p>
            <span><a href="<?= BASEURL . "/" . strtolower($app["class"][0]) ?>">Open</a></span>
        </li>
    <?php endforeach ?>
</ul>