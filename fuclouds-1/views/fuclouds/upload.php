<main id="fuclouds-upload">
    <form action="" method="post" enctype="multipart/form-data">
        <section id="file-input-container"></section>
        <ul id="filtered-file"></ul>
        
        <?= isset($_SESSION["sign-in"]["username"]) ? '<input type="hidden" name="owner" value="' . $_SESSION["sign-in"]["username"] . '">' : '' ?>
        
        <section class="browse-file">
            <label for="trigger-input">Select a file:</label>
            <button type="button" id="trigger-input" class="triggerInput">Browse file</button>
        </section>
        
        <section class="group-input">
            <label for="codename">Give a keyword:</label>
            <div class="field">
                <input type="text" id="codename" name="codename" <?= isset($_SESSION["sign-in"]["username"]) ? 'value="' . $_SESSION["sign-in"]["username"] . '"' : '' ?> placeholder="Input keyword..." autocomplete="off" required>
                <input type="submit" id="up-submit" name="submit" value="Upload" disabled>
            </div>
        </section>
    </form>
    
    <a href="<?= BASEURL . '/' . $data['app'] ?>">Search</a>
</main>