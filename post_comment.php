<?php require_once("config.php");
      include("./layout/hlava.php");
      require("./layout/navbar.php");
      require("common.php"); ?>

<?php
session_start();

if (isset($_SESSION['user_id']) && isset($_POST['komment'])) {
    $userId = $_SESSION['user_id'];
    $comment = $_POST['komment'];

    $stmt = $conn->prepare("INSERT INTO komentare (user_id, komment, datum) VALUES (?, ?, NOW())");
    $stmt->bind_param("is", $userId, $comment);

    if ($stmt->execute()) {
        header("Location: komentare.php");
    } else {
        echo "Chyba při přidávání komentáře.";
    }
} else {
    echo "Nejste přihlášeni nebo komentář je prázdný.";
}
?>
