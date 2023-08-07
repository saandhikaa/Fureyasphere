<?php
    var_dump($data);
?>

<div>
    <ul>
        <?php foreach ($data["result"]["files"] as $file): ?>
            <li>Filename: <?php echo $file["filename_"]; ?>, Filesize: <?php echo $file["filesize_"]; ?></li>
        <?php endforeach; ?>
    </ul>
</div>