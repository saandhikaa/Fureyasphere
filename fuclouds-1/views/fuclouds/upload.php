<main id="fuclouds-upload">
    <form action="" method="post" enctype="multipart/form-data">
        <section id="file-input-container"></section>
        <ul id="filtered-file"></ul>
        
        <section class="field">
            <label for="trigger-input">Select a file:</label>
            <button type="button" id="trigger-input" class="triggerInput">Browse file</button>
        </section>
        
        <section class="field">
            <label for="codename">Give a keyword:</label>
            <input type="text" id="codename" name="codename" autocomplete="off" required>
        </section>
        
        <?= isset($_SESSION["sign-in"]["username"]) ? '<input type="hidden" name="owner" value="' . $_SESSION["sign-in"]["username"] . '">' : '' ?>
        
        <input type="submit" id="up-submit" name="submit" value="Upload" disabled>
    </form>
    
    <a href="<?= BASEURL . '/' . $data['app'] ?>">Search</a>
</main>