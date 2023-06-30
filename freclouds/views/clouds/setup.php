<article class="setup">
    <?php
        $tables = $tableMaster->getList();
        $tableList = array_keys($tables);
    ?>
    
    <section>
        <?php foreach ($tables as $table => $headers): ?>
            <h2><?= $table ?></h2>
            <ul>
                <?php foreach ($headers as $header): ?>
                    <li><?= $header ?></li>
                <?php endforeach ?>
            </ul>
        <?php endforeach ?>
    </section>
</article>