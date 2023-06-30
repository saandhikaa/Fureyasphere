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
                    sector_ VARCHAR(2) NOT NULL, 
                    name_ VARCHAR(50) NOT NULL,
                    savedname_ VARCHAR(71) NOT NULL,
                    size_ VARCHAR(11) NOT NULL,
                    hours_ INT(4) NOT NULL
                    )"
                ),
                array(
                    "logging",
                    "CREATE TABLE logging ( 
                    id INT(10) PRIMARY KEY, 
                    owner_ VARCHAR(20) NOT NULL, 
                    codename_ VARCHAR(20) NOT NULL, 
                    name_ VARCHAR(255) NOT NULL, 
                    size_ VARCHAR(11) NOT NULL 
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