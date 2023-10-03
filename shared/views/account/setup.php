<?php
    $columns = [
        "id" => "INT(11) AUTO_INCREMENT PRIMARY KEY",
        "time_" => "INT(10) NOT NULL", 
        "username_" => "VARCHAR(12) NOT NULL", 
        "password_" => "VARCHAR(255) NOT NULL", 
        "level_" => "INT(2) NOT NULL"
    ];
?>

<style>
    input {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        padding: 5px 20px;
    }
</style>

<main>
    <?php $confirm = 'A new [' . $data["table-name"] . '] will be created with the following default account credentials:\n\nUsername\t:   ' .  ADMIN_USERNAME . '\nPassword\t:   ' . ADMIN_PASSWORD . '\n\nPlease confirm if you wish to proceed.' ?>
    <form action="" method="post" onsubmit="return confirm('<?= $confirm ?>');">
        <?= TableMaster::generateFormFields($columns) ?>
        <input type="submit" name="submit" value="CREATE TABLE USERS">
    </form>
</main>
