<main id="fuclouds-upload">
    <section class="header">
        <h2>Upload Files</h2>
        <p>Use the form below to upload your files.</p>
    </section>
    
    <form action="" method="post" enctype="multipart/form-data">
        <section id="file-input-container">
            <p class="heading">Selected files:</p>
            <p class="empty">No file selected</p>
            <ul id="filtered-file"></ul>
        </section>
        
        <section class="input-form">
            <?= isset($_SESSION["sign-in"]["username"]) ? '<input type="hidden" name="owner" value="' . $_SESSION["sign-in"]["username"] . '">' : '' ?>
            
            <section class="browse-file">
                <label for="trigger-input">Select a file:</label>
                <button type="button" id="trigger-input" class="triggerInput action-button">Browse file</button>
            </section>
            
            <section class="group-input">
                <label for="codename">Give a keyword:</label>
                <div class="field">
                    <input type="text" id="codename" name="codename" <?= isset($_SESSION["sign-in"]["username"]) ? 'value="' . $_SESSION["sign-in"]["username"] . '"' : '' ?> placeholder="Input keyword..." autocomplete="off" required>
                    <input type="submit" id="up-submit" name="submit" value="Upload" disabled>
                </div>
            </section>
        </section>
    </form>
    
    <section class="go desktop">
        <a class="search" href="<?= BASEURL . '/' . $data['class'] ?>">Go to Search page</a>
    </section>
    
    <nav class="go mobile">
        <ul>
            <li><a href="<?= BASEURL . '/' . $data["class"] . '/about' ?>"><?php readfile(__DIR__ . "/../../assets/images/icons/question_mark_FILL0_wght400_GRAD0_opsz24.svg") ?></a></li>
            <li><a href="<?= BASEURL . '/' . $data['class'] ?>"><?php readfile(__DIR__ . "/../../assets/images/icons/search_FILL0_wght400_GRAD0_opsz24.svg") ?></a></li>
        </ul>
        <span><button class="scrollTop"><?php readfile(__DIR__ . "/../../../" . SHARED_DIR . "/assets/images/icons/arrow_upward_FILL0_wght400_GRAD0_opsz24.svg") ?></button></span>
    </nav>
</main>