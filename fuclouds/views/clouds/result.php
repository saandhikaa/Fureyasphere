<div>
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
                    <input type="hidden" name="codename" value="<?= $file['codename_'] ?>">
                    <input type="hidden" name="key" value="<?= $file['key_'] ?>">
                    <input type="hidden" name="token" value="<?= DL_TOKEN ?>">
                    <input type="submit" value="Download">
                </form>
            </li>
        <?php endforeach; ?>
    </ul>
</div>