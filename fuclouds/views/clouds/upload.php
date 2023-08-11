<div class="upload">
    
    <form action="<?= BASEURL ?>/Clouds/result" method="post" enctype="multipart/form-data">
        <ul id="staged-files"></ul>
        <div id="file-upload-container"></div>
        <br>
        <label for="codename">codename: </label>
        <input type="text" id="codename" name="codename" oninput="validateInput(this)" required>
        <br>
        <br>
        <input type="hidden" name="token" value="<?= UP_TOKEN ?>">
        <input type="submit" name="submit" value="Upload">
    </form>
</div>