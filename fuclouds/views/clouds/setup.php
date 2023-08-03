<section>
    <?php if ($data["table"]): ?>
    <h1>Table Structure</h1>
        <table style="border-collapse: collapse; width: 80%;">
            <tr>
                <th style="border: 1px solid black; padding: 8px; text-align: left;">Field</th>
                <th style="border: 1px solid black; padding: 8px; text-align: left;">Type</th>
                <th style="border: 1px solid black; padding: 8px; text-align: left;">Null</th>
                <th style="border: 1px solid black; padding: 8px; text-align: left;">Key</th>
                <th style="border: 1px solid black; padding: 8px; text-align: left;">Default</th>
                <th style="border: 1px solid black; padding: 8px; text-align: left;">Extra</th>
            </tr>
            <?php foreach ($data["table"] as $row): ?>
                <tr>
                    <td style="border: 1px solid black; padding: 8px; text-align: left;"><?php echo $row["Field"]; ?></td>
                    <td style="border: 1px solid black; padding: 8px; text-align: left;"><?php echo $row["Type"]; ?></td>
                    <td style="border: 1px solid black; padding: 8px; text-align: left;"><?php echo $row["Null"]; ?></td>
                    <td style="border: 1px solid black; padding: 8px; text-align: left;"><?php echo $row["Key"]; ?></td>
                    <td style="border: 1px solid black; padding: 8px; text-align: left;"><?php echo $row["Default"]; ?></td>
                    <td style="border: 1px solid black; padding: 8px; text-align: left;"><?php echo $row["Extra"]; ?></td>
                </tr>
            <?php endforeach ?>
        </table>
    <?php endif ?>
</section>