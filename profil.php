<?php
require_once("common.php");
include("./layout/hlava.php");
include("./layout/navbar.php");
require_once("config.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Načtení údajů uživatele
$sql_user = "SELECT jmeno, email FROM user WHERE id = ?";
$stmt_user = $conn->prepare($sql_user);
$stmt_user->bind_param("i", $user_id);
$stmt_user->execute();
$result_user = $stmt_user->get_result();
$user = $result_user->fetch_assoc();

// Načtení oblíbených veršů
$sql_verses = "SELECT knihy.nazev AS nazev_knihy, oblibene_verse.kapitola_id, oblibene_verse.cislo_verse, oblibene_verse.text_verse
    FROM oblibene_verse
    JOIN knihy ON oblibene_verse.kniha_id = knihy.id
    WHERE oblibene_verse.user_id = ?
";
$stmt = $conn->prepare($sql_verses);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result_verses = $stmt->get_result();

// Načtení komentářů
$sql_comments = "SELECT koment, datum FROM komenatre WHERE user_id = ? ORDER BY datum DESC";
$stmt = $conn->prepare($sql_comments);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result_comments = $stmt->get_result();

$conn->close();
?>

<link rel="stylesheet" href="./css/profil.css">
<div id="cerna">
    <div class="profile">
        <h1>Váš profil</h1>

        <!-- Údaje uživatele -->
        <div class="user-info">
            <h2 class="ratata">Údaje uživatele</h2>
            <p><strong>Jméno:</strong> <?php echo htmlspecialchars($user['jmeno']); ?></p>
            <p><strong>E-mail:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
        </div>

        <!-- Oblíbené verše -->
        <section class="favorite-verses">
            <h2 class="ratata">Oblíbené verše</h2>
            <ul>
                <?php while ($row = $result_verses->fetch_assoc()): ?>
                    <li class="profili">
                        <?php 
                        echo htmlspecialchars($row['nazev_knihy']) . ", Kapitola " . htmlspecialchars($row['kapitola_id']) . ", Verš " . htmlspecialchars($row['cislo_verse']) . ": " . htmlspecialchars($row['text_verse']); 
                        ?>
                    </li>
                <?php endwhile; ?>
            </ul>
        </section>

        <!-- Komentáře -->
        <section class="comments">
            <h2 class="ratata">Vaše komentáře</h2>
            <ul>
                <?php while ($row = $result_comments->fetch_assoc()): ?>
                    <li class="profili">
                        <p><?php echo htmlspecialchars($row['koment']); ?></p>
                        <small>Vytvořeno: <?php echo $row['datum']; ?></small>
                    </li>
                <?php endwhile; ?>
            </ul>
            <!-- Tlačítko pro přesměrování na stránku komentářů -->
            <a href="komentare.php" class="button">Zobrazit všechny komentáře</a>
        </section>
    </div>
</div>
<?php require("./layout/noha.php")?>
</body>
</html>