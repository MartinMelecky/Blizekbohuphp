<?php require_once("config.php");
      include("./layout/hlava.php");
      include("./layout/navbar.php");
      require("common.php");
      require("database.php"); ?>
<?php

// Ověření, zda je uživatel přihlášen
if (!isset($_SESSION['user_id'])) {
    echo "Musíte být přihlášený, abyste mohl přidat komentář.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Připojení k databázi

    if ($mysqli->connect_error) {
        die("Spojení s databází selhalo: " . $mysqli->connect_error);
    }

    // Získání komentáře a ID uživatele
    $komentar = $_POST['komentar'];
    $uzivatel_id = $_SESSION['user_id'];

    // Vložení komentáře do databáze
    $stmt = $mysqli->prepare("INSERT INTO komenatre (user_id, koment) VALUES (?, ?)");
    $stmt->bind_param("is", $uzivatel_id, $komentar);

    if ($stmt->execute()) {
        echo "Komentář byl úspěšně přidán!"; {
        header("Location: komentare.php");
        }
        
    } else {
        echo "Chyba při přidávání komentáře: " . $stmt->error;
    }

    $stmt->close();
    $mysqli->close();
}
?>

<link rel="stylesheet" href="./cssform/form.css">
<div id="cerna">
  <h1>Zpětná vazba</h1>
<form method="post">
<h3>komentáře zde =><a href="komentare.php" class="btn">komentáře</a></h3>
  <textarea name="komentar" class="feedback-input" placeholder="text"></textarea>
  <input type="submit" value="ODESLAT"/>
</form>
</div>