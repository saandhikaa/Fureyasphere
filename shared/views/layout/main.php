<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= $data["title"] ?></title>
    
    <?php foreach ($data["style"] as $style): ?>
        <?= $style ?>
    <?php endforeach ?>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@400;500&display=swap" rel="stylesheet">
</head>

<body id="body">
    <?php if (isset($data["navigation"]) && $data["navigation"]): ?>
        <?php require_once __DIR__ . "/navigation.php" ?>
    <?php else: ?>
        <h1><?= $data["page-title"] ?></h1>
    <?php endif ?>
    
    <main id="<?= $data["main-id"] ?>">
        <?php foreach ($data["body"] as $section): ?>
            <?php file_exists($section) ? require_once $section : false ?>
        <?php endforeach ?>
    </main>
    
    <?php foreach ($data["script"] as $script): ?>
        <?= $script ?>
    <?php endforeach ?>
</body>
</html>