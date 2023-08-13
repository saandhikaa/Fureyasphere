<div class="upload">
    
    <form action="<?= BASEURL ?>/Clouds/result" method="post" enctype="multipart/form-data">
        <ul id="staged-files"></ul>
        <div id="file-upload-container"></div>
        <br>
        <button type="button" onclick="clickActiveInput()">Browse file</button>
        <br>
        <br>
        <label for="codename">codename: </label>
        <input type="text" id="codename" name="codename" oninput="validateInput(this)" autocomplete="off" required>
        <br>
        <br>
        <input type="hidden" name="token" value="<?= UP_TOKEN ?>">
        <input type="submit" name="submit" value="Upload">
    </form>
    
    <br>
    <br>
    <a href="<?= BASEURL ?>/Clouds/index">back home</a>
</div>