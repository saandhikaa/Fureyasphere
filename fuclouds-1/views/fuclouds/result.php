<main id="fuclouds-result">
    <?php if ($data["status"] === "uploaded"): ?>
        <p class="status">Your files uploaded successfully with keyword <strong style="font-family: monospace;"><?= $data["keyword"] ?> </strong></p>
    <?php endif ?>
    
    <ul>
        <?php foreach ($data["result"] as $file): ?>
            <li>
                <section>
                    <p class="fileName"><?= $file["filename_"] ?></p>
                    <p class="fileSize"><?= FileHandler::formatBytes($file["filesize_"]) ?></p>
                </section>
                <form action="" method="post">
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
        <form action="" method="post">
            <?php $filepath = $data["result"][0]["codename_"] . "_" . $data["result"][0]["key_"] . ".zip" ?>
            <input type="hidden" name="codename" value="<?= $file['codename_'] ?>">
            <input type="hidden" name="key" value="<?= $file['key_'] ?>">
            <input type="hidden" name="filename" value="<?= $filepath ?>">
            <input type="hidden" name="filepath" value="<?= $filepath ?>">
            <input type="submit" name="submit" value="Download All as Zip">
        </form>
    <?php endif ?>
    
    <?php if (empty($data["result"])): ?>
        <p>invalid keyword or the file is gone</p>
    <?php endif ?>
</main>