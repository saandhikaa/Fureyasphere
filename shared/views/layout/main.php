<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= $data["title"] ?></title>
    
    <?php if (isset($data["navigation"]) && $data["navigation"]) echo '<link rel="stylesheet" href="' . BASEURL . '/' . SHARED_DIR . '/assets/css/main.css">' ?>
    <?php if (isset($data["style"])): ?>
        <?php foreach ($data["style"] as $style) echo $style ?>
    <?php endif ?>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fira+Sans:wght@200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
</head>

<body id="body">
    <?php if (isset($data["navigation"]) && $data["navigation"]) require_once __DIR__ . "/navigation.php" ?>
    
    <p class="root-path" style="display: none"><?= BASEURL ?></p>
    <?php if (isset($data["dir"])) echo '<p class="image-path" style="display: none">' . BASEURL . '/' . $data["dir"] . '/assets/images/</p>' ?>
    
    <?php if (file_exists($content)) require_once $content; else echo $data["content"]; ?>
    
    <div id="toast"></div>

    <?php if (isset($data["navigation"]) && $data["navigation"]) echo '<script src="' . BASEURL . '/' . SHARED_DIR . '/assets/js/main.js"></script>' ?>
    <?php if (isset($data["script"])): ?>
        <?php foreach ($data["script"] as $script) echo $script ?>
    <?php endif ?>
</body>
</html>