<?php 
require_once("common.php");
include("./layout/hlava.php");
include("./layout/navbar.php");
require_once("config.php");


// Zpracování uložení verše do oblíbených
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ulozit_vers']) && isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $kniha_id = $_POST['kniha_id']; // Přidání knihy
    $kapitola_id = $_POST['kapitola_id'];
    $cislo_verse = $_POST['cislo_verse'];
    $text_verse = $_POST['text_verse'];

    $stmt = $conn->prepare("INSERT INTO oblibene_verse (user_id, kniha_id, kapitola_id, cislo_verse, text_verse) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("iiiis", $user_id, $kniha_id, $kapitola_id, $cislo_verse, $text_verse);
    $stmt->execute();
    $stmt->close();

    // Přesměrování, aby se po obnovení stránky neodeslal znovu POST
    header("Location: " . $_SERVER['REQUEST_URI']);
    exit;
}

// Načtení knih
$sql_books = "SELECT id, nazev FROM knihy";
$result_books = $conn->query($sql_books);

// Načtení kapitol dle vybrané knihy
$chapters = [];
if (isset($_GET['kniha_id']) && !empty($_GET['kniha_id'])) {
    $book_id = $_GET['kniha_id'];
    $sql_chapters = "SELECT id, cislo_kapitoly FROM kapitoly WHERE id_knihy = $book_id";
    $result_chapters = $conn->query($sql_chapters);
    while ($row = $result_chapters->fetch_assoc()) {
        $chapters[] = $row;
    }
} else {
    // Pokud není kniha vybrána, kapitoly se nenačtou
    $chapters = [];
}

// Načtení veršů dle vybrané kapitoly
$verses = [];
if (isset($_GET['kapitola_id']) && !empty($_GET['kapitola_id'])) {
    $chapter_id = $_GET['kapitola_id'];
    $sql_verses = "SELECT cislo_verse, text_verse FROM verse WHERE id_kapitoly = $chapter_id ORDER BY cislo_verse";
    $result_verses = $conn->query($sql_verses);
    while ($row = $result_verses->fetch_assoc()) {
        $verses[] = $row;
    }
}

$conn->close();
?>

<div id="cerna">
    <h1>Procházejte Bibli</h1>

    <form action="" method="GET">
        <h2>Vyberte knihu:</h2>
        <select name="kniha_id" onchange="this.form.submit()">
            <option value="">-- Vyberte knihu --</option>
            <?php
            if ($result_books->num_rows > 0) {
                while ($row = $result_books->fetch_assoc()) {
                    $selected = (isset($_GET['kniha_id']) && $_GET['kniha_id'] == $row['id']) ? 'selected' : '';
                    echo "<option value='" . $row['id'] . "' $selected>" . $row['nazev'] . "</option>";
                }
            }
            ?>
        </select>

        <?php if (isset($_GET['kniha_id'])): ?>
            <h2>Vyberte kapitolu:</h2>
            <select name="kapitola_id" onchange="this.form.submit()">
                <option value="">-- Vyberte kapitolu --</option>
                <?php
                foreach ($chapters as $chapter) {
                    $selected = (isset($_GET['kapitola_id']) && $_GET['kapitola_id'] == $chapter['id']) ? 'selected' : '';
                    echo "<option value='" . $chapter['id'] . "' $selected>" . $chapter['cislo_kapitoly'] . "</option>";
                }
                ?>
            </select>
        <?php endif; ?>

        <?php if (isset($_GET['kapitola_id'])): ?>
            <h2>Verše:</h2>
            <ul>
            <?php
            foreach ($verses as $verse) {
             echo '<li class="verse-item">'; // Třída "verse-item" pro každý <li>

            echo '<span class="verse-text"><strong>' . $verse['cislo_verse'] . ':</strong> ' . $verse['text_verse'] . '</span>';

            if (isset($_SESSION['user_id'])) {
                echo '<form method="POST" class="save-form">
                        <input type="hidden" name="kniha_id" value="' . htmlspecialchars($book_id) . '"> <!-- Přidání knihy -->
                        <input type="hidden" name="kapitola_id" value="' . htmlspecialchars($chapter_id) . '">
                        <input type="hidden" name="cislo_verse" value="' . htmlspecialchars($verse['cislo_verse']) . '">
                        <input type="hidden" name="text_verse" value="' . htmlspecialchars($verse['text_verse']) . '">
                        <button type="submit" name="ulozit_vers" class="save-button">Uložit</button>
                      </form>';
            }

    echo '</li>';
}
?>
            </ul>
        <?php endif; ?>
    </form>
</div>
<?php require("./layout/noha.php")?>
</body>
</html>
