<main id="fuclouds-result">
    <?php if (!empty($data["result"])): ?>
        <?php if ($data["action"] === "uploaded"): ?>
            <section class="header">
                <h2>Upload Results</h2>
                <p>Your files uploaded successfully.</p>
            </section>
            <p class="status"><?= FileHandler::uploadSuccess($data["keyword"]) ?></p>
        <?php else: ?>
            <section class="header">
                <h2>Search Results</h2>
                <p>Here are the files that match your search keyword:</p>
            </section>
        <?php endif ?>
    <?php else: ?>
        <p>invalid keyword or the file is gone</p>
    <?php endif ?>
    
    <ul class="file-list">
        <?php foreach ($data["result"] as $file): ?>
            <li>
                <section class="file-info">
                    <?php if (file_exists(__DIR__ . '/../../assets/images/file-type-icon/' . pathinfo($file['filename_'], PATHINFO_EXTENSION) . '.png')): ?>
                        <img src="<?= BASEURL . '/' . $data['appDir'] . '/assets/images/file-type-icon/' . pathinfo($file['filename_'], PATHINFO_EXTENSION) . '.png' ?>" alt="">
                    <?php else: ?>
                        <img src="<?= BASEURL . '/' . $data['appDir'] . '/assets/images/file-type-icon/others.png' ?>" alt="">
                    <?php endif ?>
                    
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
            <button type="submit" name="submit" id="download-all" class="action-button">Download all as Zip <?php readfile(__DIR__ . '/../../assets/images/icons/download_FILL0_wght400_GRAD0_opsz24.svg') ?></button>
        </form>
    <?php endif ?>
    
    <section class="go desktop">
        <a class="search" href="<?= BASEURL . '/' . $data['class'] ?>">Go to Search page</a>
        <a class="upload" href="<?= BASEURL . '/' . $data['class']?>/upload">Go to Upload page</a>
    </section>
    
    <nav class="go mobile">
        <ul>
            <li><a href="<?= BASEURL . '/' . $data["class"] . '/about' ?>"><?php readfile(__DIR__ . "/../../assets/images/icons/question_mark_FILL0_wght400_GRAD0_opsz24.svg") ?></a></li>
            <li><a href="<?= BASEURL . '/' . $data['class'] ?>"><?php readfile(__DIR__ . "/../../assets/images/icons/search_FILL0_wght400_GRAD0_opsz24.svg") ?></a></li>
            <li><a href="<?= BASEURL . '/' . $data['class'] . '/upload' ?>"><?php readfile(__DIR__ . "/../../assets/images/icons/cloud_upload_FILL0_wght400_GRAD0_opsz24.svg") ?></a></li>
        </ul>
        <span><button class="scrollTop"><?php readfile(__DIR__ . "/../../../" . SHARED_DIR . "/assets/images/icons/arrow_upward_FILL0_wght400_GRAD0_opsz24.svg") ?></button></span>
    </nav>
</main>