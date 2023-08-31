<form action="" method="post" enctype="multipart/form-data">
    <section id="file-input-container"></section>
    <ul id="filtered-file"></ul>
    
    <section class="field">
        <label for="input-file">Select a file:</label>
        <button type="button" id="input-file">Browse file</button>
    </section>
    
    <section class="field">
        <label for="codename">Give a keyword:</label>
        <input type="text" id="codename" name="codename" autocomplete="off" required>
    </section>
    
    <input type="submit" id="up-submit" name="submit" value="Upload" disabled>
</form>

<a href="<?= BASEURL . '/' . $data['app'] ?>">Search</a>