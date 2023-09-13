<main id="fuclouds-search">
    <section class="header">
        <h2>Search for Files</h2>
        <p>Use the search bar below to find a file you need.</p>
    </section>
    
    <form action="" method="post">
        <section class="group-input">
            <label for="keyword">Keyword: </label>
            <div class="field">
                <input type="text" id="keyword" name="keyword" autocomplete="off" placeholder="Input keyword.. " required>
                <input type="submit" name="submit" value="Search">
            </div>
        </section>
    </form>
    
    <section class="go">
        <a class="upload" href="<?= BASEURL . '/' . $data['app']?>/upload">Go to Upload page</a>
    </section>
</main>