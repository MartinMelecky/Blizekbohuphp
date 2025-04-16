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

// Načtení oblíbených veršů
$sql_verses = "SELECT kapitola_id, cislo_verse, text_verse FROM oblibene_verse WHERE user_id = ?";
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
        <h1 >Váš profil</h1>

        <section class="favorite-verses">
    <h2 class="ratata">Oblíbené verše</h2>
    <ul>
        <?php while ($row = $result_verses->fetch_assoc()): ?>
            <li class="profili">
                <?php 
                echo "Kapitola " . htmlspecialchars($row['kapitola_id']) . ", Verš " . htmlspecialchars($row['cislo_verse']) . ": " . htmlspecialchars($row['text_verse']); 
                ?>
            </li>
        <?php endwhile; ?>
    </ul>
</section>

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
        </section>
    </div>
</div>
</body>
</html>
