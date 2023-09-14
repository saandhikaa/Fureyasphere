<main id="fuclouds-result">
    <section class="header">
        <h2>Search Results</h2>
        <p>Here are the files that match your search keyword:</p>
    </section>
    
    <?php if ($data["action"] === "uploaded"): ?>
        <p class="status"><?= FileHandler::uploadSuccess($data["keyword"]) ?></p>
    <?php endif ?>
    
    <ul class="file-list">
        <?php foreach ($data["result"] as $file): ?>
            <li>
                <section class="file-info">
                    <img src="<?= BASEURL . '/' . basename(dirname(dirname(dirname(__FILE__)))) . '/assets/images/file-type-icon/' . pathinfo($file["filename_"], PATHINFO_EXTENSION) . '.png' ?>" alt="">
                    <section class="file-dec">
                        <p class="file-name"><?= $file["filename_"] ?></p>
                        <p class="file-size"><?= FileHandler::formatBytes($file["filesize_"]) ?></p>
                    </section>
                </section>
                <form action="" method="post">
                    <?php $filepath = $file["time_"] . "_" . $file["filename_"] ?>
                    <input type="hidden" name="codename" value="<?= $file['codename_'] ?>">
                    <input type="hidden" name="key" value="<?= $file['key_'] ?>">
                    <input type="hidden" name="filename" value="<?= $file['filename_'] ?>">
                    <input type="hidden" name="filepath" value="<?= $filepath ?>">
                    <button type="submit" name="submit" class="file-action"><?php readfile(__DIR__ . '/../../assets/images/icons/download_FILL0_wght400_GRAD0_opsz24.svg') ?></button>
                </form>
            </li>
        <?php endforeach ?>
    </ul>
    
    <?php if (count($data["result"]) > 1): ?>
        <form action="" method="post" class="download-all">
            <?php $filepath = $data["result"][0]["codename_"] . "_" . $data["result"][0]["key_"] . ".zip" ?>
            <input type="hidden" name="codename" value="<?= $file['codename_'] ?>">
            <input type="hidden" name="key" value="<?= $file['key_'] ?>">
            <input type="hidden" name="filename" value="<?= $filepath ?>">
            <input type="hidden" name="filepath" value="<?= $filepath ?>">
            <button type="submit" name="submit" id="download-all">Download all as Zip <?php readfile(__DIR__ . '/../../assets/images/icons/download_FILL0_wght400_GRAD0_opsz24.svg') ?></button>
        </form>
    <?php endif ?>
    
    <?php if (empty($data["result"])): ?>
        <p>invalid keyword or the file is gone</p>
    <?php endif ?>
    
    <section class="go">
        <a class="search" href="<?= BASEURL . '/' . $data['app'] ?>">Go to Search page</a>
        <a class="upload" href="<?= BASEURL . '/' . $data['app']?>/upload">Go to Upload page</a>
    </section>
</main>