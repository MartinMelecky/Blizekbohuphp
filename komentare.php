<?php require_once("config.php");
      include("./layout/hlava.php");
      require("./layout/navbar.php");
      require("common.php");
      require("./cssform/form.css"); ?>
        
<?php


$commentsQuery = "SELECT k.koment, k.datum, u.jmeno FROM komentare k JOIN user u ON k.user_id = u.id ORDER BY k.datum DESC";
$result = $conn->query($commentsQuery);

echo '<h2>Komentáře</h2>';

while ($row = $result->fetch_assoc()) {
    echo "<p><strong>" . htmlspecialchars($row['jemno']) . "</strong> (" . $row['datum'] . "): " . htmlspecialchars($row['koment']) . "</p>";
}

if (isset($_SESSION['user_id'])) {
    // Uživatel je přihlášen
    echo '<form method="POST" action="post_comment.php">
            <textarea name="komment" required></textarea>
            <button type="submit">Přidat komentář</button>
          </form>';
} else {
    echo "<p>Pro přidání komentáře se musíte přihlásit.</p>";
}
?>
