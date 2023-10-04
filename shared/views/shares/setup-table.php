<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= $data["title"] ?></title>
    
    <style>
        input {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            padding: 5px 20px;
        }
    </style> 
</head>

<body>
    <form action="" method="post" onsubmit="return confirm('<?= $data["confirm"] ?>');">
        <?= TableMaster::generateFormFields($data["columns"]) ?>
        <input type="submit" name="submit" value="<?= $data["button"] ?>">
    </form>
</body>

</html>