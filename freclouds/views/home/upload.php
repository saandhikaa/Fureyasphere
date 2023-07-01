<div class="upload">
    <?php
        if (isset($_POST["submit"])) {
            $handler->upload();
        }
    ?>
    
    <form action="" method="post" enctype="multipart/form-data">
        <label for="file">open file: </label>
        <input type="file" id="file" name="file">
        <br>
        <label for="codename">codename: </label>
        <input type="text" id="codename" name="codename">
        <br>
        <input type="submit" name="submit" value="Upload">
    </form>
</div>