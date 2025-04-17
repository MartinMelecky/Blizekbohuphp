<?php 
require_once("config.php");
include("./layout/hlava.php");
include("./layout/navbar.php");
require("common.php");
require("database.php");

// Zpracování formuláře pro přidání komentáře
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $koment = $_POST['koment'];
    $parent_id = $_POST['parent_id'] === "NULL" ? NULL : intval($_POST['parent_id']);
    $user_id = $_SESSION['user_id']; // Předpokládáme, že uživatel je přihlášen

    $stmt = $mysqli->prepare("INSERT INTO komenatre (koment, datum, user_id, parent_id) VALUES (?, NOW(), ?, ?)");
    $stmt->bind_param("sii", $koment, $user_id, $parent_id);
    $stmt->execute();
    $stmt->close();

    header("Location: komentare.php");
    exit;
}

if (isset($_GET['comment_id'])) {
    $comment_id = intval($_GET['comment_id']);

    // Načtení konkrétního komentáře
    $stmt = $mysqli->prepare("SELECT k.id, k.koment, k.datum, u.jmeno FROM komenatre k JOIN user u ON k.user_id = u.id WHERE k.id = ?");
    $stmt->bind_param("i", $comment_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $highlighted_comment = $result->fetch_assoc();
    $stmt->close();
}

// Funkce pro zobrazení komentářů a odpovědí
function zobrazKomentare($parent_id = NULL, $hloubka = 0) {
    global $mysqli;

    $stmt = $mysqli->prepare("SELECT k.id, k.koment, k.datum, u.jmeno FROM komenatre k JOIN user u ON k.user_id = u.id WHERE k.parent_id <=> ? ORDER BY k.datum DESC");
    $stmt->bind_param("i", $parent_id);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $formatted_date = date('d.m.Y H:i:s', strtotime($row['datum']));
        $isReply = $parent_id !== NULL; // Kontrola, zda jde o odpověď
        $commentClass = $isReply ? 'reply' : 'original'; // Třída pro odpověď nebo původní komentář

        echo '<div class="komentar ' . $commentClass . '" style="margin-left: ' . ($hloubka * 20) . 'px;">';
        echo '<p class="jmeno">' . htmlspecialchars($row['jmeno']) . ' <span class="datum"> - ' . $formatted_date . '</span></p>';
        echo '<p>' . nl2br(htmlspecialchars($row['koment'])) . '</p>';
        echo '<button class="reply-button" onclick="showReplyForm(' . $row['id'] . ')">Odpovědět</button>';
        echo '<div id="reply-form-' . $row['id'] . '" class="reply-form" style="display: none;">
                <form action="komentare.php" method="POST" class="reply-form">
                    <textarea name="koment" rows="3" placeholder="Napište odpověď..." required></textarea>
                    <input type="hidden" name="parent_id" value="' . $row['id'] . '">
                    <button type="submit" class="add-comment-button">Odeslat odpověď</button>
                </form>
              </div>';
        echo '</div>';
        zobrazKomentare($row['id'], $hloubka + 1); // Rekurzivní volání pro odpovědi
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seznam komentářů</title>
    <link rel="stylesheet" href="./css/komet.css"> <!-- Odkaz na externí CSS soubor -->
    
    <script>
        function showReplyForm(commentId) {
            const form = document.getElementById(`reply-form-${commentId}`);
            form.style.display = form.style.display === 'none' ? 'block' : 'none';
        }
    </script>
</head>
<body>

<div class="container">
    <h1>Diskuze / Komentáře</h1>

    <?php
    // Zobrazení hlavních komentářů
    zobrazKomentare();
    ?>

    <div class="add-comment">
        <h2>Přidat komentář</h2>
        <form action="komentare.php" method="POST" class="add-comment-form"> 
            <textarea name="koment" rows="4" placeholder="Napište svůj komentář..." required></textarea>
            <input type="hidden" name="parent_id" value="NULL"> <!-- Pro hlavní komentáře -->
            <button type="submit">Odeslat</button>
        </form>
    </div>

</div>

</body>
</html>
