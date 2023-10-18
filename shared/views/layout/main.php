<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= $data["title"] ?></title>
    
    <?= isset($data["navigation"]) && $data["navigation"] ? '<link rel="stylesheet" href="' . BASEURL . '/' . SHARED_DIR . '/assets/css/main.css">' : '' ?>
    <?php if (isset($data["style"])): ?>
        <?php foreach ($data["style"] as $style): ?>
            <?= $style ?>
        <?php endforeach ?>
    <?php endif ?>
    
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
    
    <?php require_once $data["body"] ?>
    
    <?= isset($data["navigation"]) && $data["navigation"] ? '<script src="' . BASEURL . '/' . SHARED_DIR . '/assets/js/main.js"></script>' : '' ?>
    <?php if (isset($data["script"])): ?>
        <?php foreach ($data["script"] as $script): ?>
            <?= $script ?>
        <?php endforeach ?>
    <?php endif ?>
</body>
</html>