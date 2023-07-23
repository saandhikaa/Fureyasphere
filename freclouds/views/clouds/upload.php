<div class="upload">
    <?php
        if (isset($_POST["submit"])) {
            print_r($_POST);
            print_r($_FILES); die;
            $handler->upload();
        }
    ?>
    
    <form action="" method="post" enctype="multipart/form-data">
        <div id="file-upload-container">
            <div class="file-input-container">
                <input type="file" name="file[]" class="file-input" onchange="handleFileSelection(this)" required>
            </div>
        </div>
        <br>
        <label for="codename">codename: </label>
        <input type="text" id="codename" name="codename" required>
        <br>
        <br>
        <input type="submit" name="submit" value="Upload">
    </form>
</div>