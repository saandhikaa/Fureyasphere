<main id="fuclouds-search">
    <form action="" method="post">
        <h2>Search for Files</h2>
        <p>Use the search bar below to find a file you need.</p>
        
        <label for="keyword">Keyword: </label>
        <section>
            <input type="text" id="keyword" name="keyword" required>
            <input type="button" class="clear" value="Clear">
            <input type="submit" name="submit" value="Search">
        </section>
    </form>
    
    <a href="<?= BASEURL . '/' . $data['app']?>/upload">Upload</a>
</main>