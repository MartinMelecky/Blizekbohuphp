<?php require_once("config.php");
      include("./layout/hlava.php");
      include("./layout/navbar.php");
      require("common.php");
      require("database.php"); ?>
<?php


// SQL dotaz pro získání všech komentářů a jejich autorů
$sql = "SELECT k.koment, k.datum, u.jmeno FROM komenatre k JOIN user u ON k.user_id = u.id ORDER BY k.datum DESC";
$result = $mysqli->query($sql);

// HTML pro zobrazení komentářů
?>
<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seznam komentářů</title>
    <link rel="stylesheet" href="./css/komet.css"> <!-- Odkaz na externí CSS soubor -->
    <style>
        /* CSS kód je možné také vložit přímo sem, pokud ho nechceš mít v externím souboru */
    </style>
</head>
<body>

<div class="container">
    <h2>Diskuze</h2>

    <?php
    if ($result->num_rows > 0) {
        // Zobrazíme každý komentář
        while ($row = $result->fetch_assoc()) {
            // Formátování data
            $formatted_date = date('d.m.Y H:i:s', strtotime($row['datum']));
            ?>
            <div class="komentar">
                <p class="jmeno"><?php echo htmlspecialchars($row['jmeno']); ?> <span class="datum"> - <?php echo $formatted_date; ?></span></p>
                <p><?php echo nl2br(htmlspecialchars($row['koment'])); ?></p>
            </div>
            <hr>
            <?php
        }
    } else {
        echo "<p>Žádné komentáře nebyly nalezeny.</p>";
    }

    $mysqli->close();
    ?>

</div>

</body>
</html>
