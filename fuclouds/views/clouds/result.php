<div>
    <?php if (isset($data["result"]["status"])): ?>
        <p>
            Your files uploaded successfully with codename <strong style="font-family: monospace;"><?= $data["result"]["status"]["codename"] ?> </strong>
            and key <strong style="font-family: monospace;"><?php echo $data["result"]["status"]["key"]; ?></strong>
        </p>
    <?php endif ?>
    
    <ul>
        <?php foreach ($data["result"]["files"] as $file): ?>
            <li>
                <div>
                    <p><?= $file["filename_"] ?></p>
                    <p><?= $file["filesize_"] ?></p>
                </div>
                <form action="<?= BASEURL ?>/Clouds/result" method="post">
                    <?php $filepath = $file["time_"] . "_" . $file["filename_"] ?>
                    <input type="hidden" name="filename" value="<?= $file['filename_'] ?>">
                    <input type="hidden" name="filepath" value="<?= $filepath ?>">
                    <input type="submit" name="submit" value="Download">
                </form>
            </li>
        <?php endforeach ?>
    </ul>
    
    <?php if (count($data["result"]["files"]) > 1): ?>
        <form action="<?= BASEURL ?>/Clouds/result" method="post">
            <?php $filepath = $data["result"]["files"][0]["codename_"] . "_" . $data["result"]["files"][0]["key_"] . ".zip"?>
            <input type="hidden" name="filename" value="<?= $filepath ?>">
            <input type="hidden" name="filepath" value="<?= $filepath ?>">
            <input type="submit" name="submit" value="Download All as Zip">
        </form>
        <br>
        <br>
    <?php endif ?>
    
    <?php if (empty($data["result"]["files"])): ?>
        <p>wrong codename/key or the file is gone</p>
    <?php endif ?>
    
    <a href="<?= BASEURL ?>/Clouds/index">back home</a>
</div>