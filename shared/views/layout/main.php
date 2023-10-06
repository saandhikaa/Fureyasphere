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
</head>

<body>
    <main id="<?= $data["main-id"] ?>">
        <h1><?= $data["page-title"] ?></h1>
        
        <?php foreach ($data["body"] as $section): ?>
            <?php file_exists($section) ? readfile($section) : false ?>
        <?php endforeach ?>
    </main>
    
    <?php foreach ($data["script"] as $script): ?>
        <?= $script ?>
    <?php endforeach ?>
</body>
</html>