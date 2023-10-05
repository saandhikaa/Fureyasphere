<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= $data["title"] ?></title>
</head>

<body>
    <h1><?= $data["page-title"] ?></h1>
    
    <?php foreach ($data["body"] as $section): ?>
        <?php readfile($section) ?>
    <?php endforeach ?>
    
    <!-- Eruda for mobile -->
    <script src="//cdn.jsdelivr.net/npm/eruda"></script>
    <script>eruda.init();</script>
    
</body>
</html>