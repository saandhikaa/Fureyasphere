<main id="fuclouds-search">
    <form action="" method="post">
        <h2>Search for Files</h2>
        <p>Use the search bar below to find a file you need.</p>
        
        <section class="group-input">
            <label for="keyword">Keyword: </label>
            <div class="field">
                <input type="text" id="keyword" name="keyword" autocomplete="off" placeholder="Input keyword.. " required>
                <input type="submit" name="submit" value="Search">
            </div>
        </section>
    </form>
    
    <a href="<?= BASEURL . '/' . $data['app']?>/upload">Upload</a>
</main>