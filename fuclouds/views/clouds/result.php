<div>
    <?php if ($data["status"] === "uploaded"): ?>
        <p>Your files uploaded successfully with keyword <strong style="font-family: monospace;"><?= $data["keyword"] ?> </strong></p>
    <?php endif ?>
    
    <ul>
        <?php foreach ($data["result"] as $file): ?>
            <li>
                <div>
                    <p><?= $file["filename_"] ?></p>
                    <p><?= $file["filesize_"] ?></p>
                </div>
                <form action="<?= BASEURL ?>/Clouds/result" method="post">
                    <?php $filepath = $file["time_"] . "_" . $file["filename_"] ?>
                    <input type="hidden" name="codename" value="<?= $file['codename_'] ?>">
                    <input type="hidden" name="key" value="<?= $file['key_'] ?>">
                    <input type="hidden" name="filename" value="<?= $file['filename_'] ?>">
                    <input type="hidden" name="filepath" value="<?= $filepath ?>">
                    <input type="submit" name="submit" value="Download">
                </form>
            </li>
        <?php endforeach ?>
    </ul>
    
    <?php if (count($data["result"]) > 1): ?>
        <form action="<?= BASEURL ?>/Clouds/result" method="post">
            <?php $filepath = $data["result"][0]["codename_"] . "_" . $data["result"][0]["key_"] . ".zip" ?>
            <input type="hidden" name="codename" value="<?= $file['codename_'] ?>">
            <input type="hidden" name="key" value="<?= $file['key_'] ?>">
            <input type="hidden" name="filename" value="<?= $filepath ?>">
            <input type="hidden" name="filepath" value="<?= $filepath ?>">
            <input type="submit" name="submit" value="Download All as Zip">
        </form>
        <br>
        <br>
    <?php endif ?>
    
    <?php if (empty($data["result"])): ?>
        <p>invalid keyword or the file is gone</p>
    <?php endif ?>
</div>