<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= $data["title"] ?></title>
    
    <style>
        p {
            margin-top: 20vh;
            padding: 0 20px;
            font-size: 1.5rem;
        }
    </style>
</head>

<body>
    <p>
        <strong><?= $data["strong"] ?></strong>
        <br>
        <br>
        <?= $data["normal"] ?>
    </p>
</body>

</html>