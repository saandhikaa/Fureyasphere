<div>
    <form action="<?= BASEURL ?>/Clouds/result" method="post" id="searching">
        <label for="codename">codename: </label><br/>
        <input type="text" id="codename" name="codename" required><br/>
        <label for="key">key: </label><br/>
        <input type="text" id="key" name="key" required><br/><br/>
        <input type="hidden" name="token" value="<?= SR_TOKEN ?>">
        <input type="submit" name="action" value="Search" id="search" onclick="updateURL()">
    </form>
    <br/>
    <br/>
    <a href="<?= BASEURL ?>/Clouds/upload">Upload</a>
</div>