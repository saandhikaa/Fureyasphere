<div class="upload">
    <form action="" method="post" enctype="multipart/form-data">
        <ul id="staged-files"></ul>
        <div id="file-upload-container"></div>
        <button type="button" onclick="clickActiveInput()">Browse file</button>
        <br>
        <br>
        <label for="codename">Give some keyword: </label>
        <br>
        <input type="text" id="codename" name="codename" oninput="validateInput(this)" autocomplete="off" required>
        <br>
        <br>
        <input type="submit" id="up-submit" name="submit" value="Upload" disabled>
    </form>
    <br>
    <br>
    <a href="<?= BASEURL . '/' . $data['app'] ?>">Search</a>
</div>