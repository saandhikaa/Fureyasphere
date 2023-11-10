<main id="darkcloud-search">
    <section class="header">
        <h2>Search for Files</h2>
        <p>Use the search bar below to find a file you need.</p>
    </section>
    
    <form action="" method="post">
        <section class="group-input">
            <label for="keyword">Keyword: </label>
            <div class="field">
                <input type="text" id="keyword" name="keyword" autocomplete="off" placeholder="Input keyword.. " required>
                <input type="submit" name="submit" value="Search">
            </div>
        </section>
    </form>
    
    <section class="go desktop">
        <a class="upload" href="<?= BASEURL . '/' . $data['class']?>/upload">Go to Upload page</a>
    </section>
    
    <nav class="go mobile">
        <ul>
            <li><a href="<?= BASEURL . '/' . $data["class"] . '/about' ?>"><?php readfile(__DIR__ . "/../../assets/images/icons/question_mark_FILL0_wght400_GRAD0_opsz24.svg") ?></a></li>
            <li><a href="<?= BASEURL . '/' . $data['class'] . '/upload' ?>"><?php readfile(__DIR__ . "/../../assets/images/icons/cloud_upload_FILL0_wght400_GRAD0_opsz24.svg") ?></a></li>
        </ul>
        <span><button class="scrollTop"><?php readfile(__DIR__ . "/../../../" . SHARED_DIR . "/assets/images/icons/arrow_upward_FILL0_wght400_GRAD0_opsz24.svg") ?></button></span>
    </nav>
</main>