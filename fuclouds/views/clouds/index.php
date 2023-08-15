<div>
    <form action="<?= BASEURL ?>/Clouds/result" method="post" id="sr-form">
        <label for="codename">codename: </label><br/>
        <input type="text" id="codename" name="codename" oninput="validateInput(this)" required><br/>
        <label for="key">key: </label><br/>
        <input type="number" id="key" name="key" required><br/><br/>
        <input type="submit" name="submit" value="Search" id="sr-submit" onclick="updateURL()">
    </form>
    <br/>
    <br/>
    <a href="<?= BASEURL ?>/Clouds/upload">Upload</a>
</div>