<?php
    require "../functions.php";
    date_default_timezone_set("Asia/Jakarta");

    purging("../");

    session_start();
    if (!isset($_SESSION["login"])){
        header("Location: login.php");
    }

    $logline = querying("SELECT * FROM logging");
    $lasting = querying("SELECT * FROM blackhole");

    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Alternative</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro&display=swap" rel="stylesheet">

</head>

<body style="background-color: white;">
    <a href="../">BLACKHOLE</a><br>
    <a href="login.php?action=logout">LOGOUT</a><br><br>

    <div class="list">
        <?php if (!empty($lasting)): ?>
            <h2>Lasting</h2>
            <table>
                <tr>
                    <th>No.</th>
                    <th>Codename</th>
                    <th>Sector</th>
                    <th>File name</th>
                    <th>Listed</th>
                </tr>
                <?php for ($i = 0; $i < count($lasting); $i++): ?>
                    <tr>
                        <td><?=$i+1?></td>
                        <td><?=$lasting[$i]['codename_']?></td>
                        <td><?=$lasting[$i]['sector_']?></td>
                        <td><?=$lasting[$i]['name_']?></td>
                        <td><?= date("d/m/Y -- H:i:s", $lasting[$i]['id'])." WIB"?></td>
                    </tr>
                <?php endfor ?>
            </table><br><br>
        <?php endif ?>
    </div>
    
    <div class="list">
        <h2>Logging</h2>
        <table class="list">
            <tr>
                <th>No.</th>
                <th>Codename</th>
                <th>File name</th>
                <th>Listed</th>
            </tr>
            <?php for ($i = count($logline) - 1; $i >= 0; $i--): ?>
                <tr>
                    <td><?=count($logline) - $i?></td>
                    <td><?=$logline[$i]['codename_']?></td>
                    <td><?=$logline[$i]['name_']?></td>
                    <td><?= date("d/m/Y -- H:i:s", $logline[$i]['id'])." WIB"?></td>
                </tr>
            <?php endfor ?>
        </table>
    </div>
</body>
</html>