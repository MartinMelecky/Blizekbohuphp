<?php require_once("config.php");
      include("./layout/hlava.php");
      require("./layout/navbar.php");
      require("common.php"); ?>

<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    echo "Musíte být přihlášeni, abyste viděli svůj profil.";
    exit();
}

$userId = $_SESSION['user_id'];
$query = "SELECT jmeno, email FROM user WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

echo "<h2>Profil: " . htmlspecialchars($user['jmeno']) . "</h2>";
echo "<p>Email: " . htmlspecialchars($user['email']) . "</p>";

// Zobrazení uživatelových komentářů
$commentsQuery = "SELECT komment, datum FROM komentare WHERE user_id = ? ORDER BY datum DESC";
$stmt = $conn->prepare($commentsQuery);
$stmt->bind_param("i", $userId);
$stmt->execute();
$commentsResult = $stmt->get_result();

echo "<h3>Vaše komentáře</h3>";
while ($row = $commentsResult->fetch_assoc()) {
    echo "<p>" . htmlspecialchars($row['datum']) . ": " . htmlspecialchars($row['komment']) . "</p>";
}

// Náhodný verš z Bible
$randomVerseQuery = "SELECT bv.verse_text 
                     FROM bible_verses bv
                     JOIN bible_chapters bc ON bv.chapter_id = bc.id
                     JOIN bible_books bb ON bc.book_id = bb.id
                     ORDER BY RAND() LIMIT 1";

$verseResult = $conn->query($randomVerseQuery);
$verse = $verseResult->fetch_assoc();

echo "<h3>Náhodný verš:</h3>";
echo "<p>" . htmlspecialchars($verse['verse_text']) . "</p>";

echo '<a href="logout.php">Odhlásit se</a>';
?>
