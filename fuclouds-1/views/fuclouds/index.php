<div>
    <form action="" method="post">
        <label for="keyword">Keyword: </label>
        <br>
        <input type="text" id="keyword" name="keyword" required>
        <br>
        <br>
        <input type="submit" name="submit" value="Search">
    </form>
    <br>
    <br>
    <a href="<?= BASEURL . '/' . $data['app']?>/upload">Upload</a>
</div>