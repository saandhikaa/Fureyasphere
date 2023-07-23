<article class="setup">
    <?php
        $headers = $tableMaster->getList();
        $tables = array_keys($headers);
        
        if (isset($_POST["push"])) {
            $expectedTables = array(
                array(
                    "cloudfiles",
                    "CREATE TABLE cloudfiles (
                    id INT(10) PRIMARY KEY,
                    owner_ VARCHAR(20) NOT NULL,
                    codename_ VARCHAR(20) NOT NULL,
                    key_ INT(2) NOT NULL,
                    filename_ VARCHAR(100) NOT NULL,
                    size_ INT(11) NOT NULL,
                    duration_ INT(4) NOT NULL
                    )"
                ),
                array(
                    "logging",
                    "CREATE TABLE logging ( 
                    id INT(10) PRIMARY KEY,
                    owner_ VARCHAR(20) NOT NULL,
                    codename_ VARCHAR(20) NOT NULL,
                    filename_ VARCHAR(100) NOT NULL,
                    size_ INT(11) NOT NULL
                    )"
                )
            );
            
            for ($i = 0; $i < count($expectedTables); $i++) {
                if (in_array($expectedTables[$i][0], $tables)) {
                    $tableMaster->drop($expectedTables[$i][0]);
                }
                $tableMaster->create($expectedTables[$i][1]);
            }
            $headers = $tableMaster->getList();
        }
    ?>
    
    <section>
        <?php foreach ($headers as $table => $headerlist): ?>
            <h2><?= $table ?></h2>
            <ul>
                <?php foreach ($headerlist as $header): ?>
                    <li><?= $header ?></li>
                <?php endforeach ?>
            </ul>
        <?php endforeach ?>
        <br>
        <form action="", method="post">
            <input type="submit", name="push", value="reset">
        </form>
    </section>
</article>