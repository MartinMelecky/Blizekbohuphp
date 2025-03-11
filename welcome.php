<?php
session_start(); // Spustí session

// Pokud není uživatel přihlášený, přesměruje ho na přihlašovací stránku
if (!isset($_SESSION['user_id'])) {
    header("Location: prihlaseni.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <title>Vítejte</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Vítejte, <?php echo $_SESSION['user_name']; ?>!</h1>
    <p>Máte přístup k těmto funkcím:</p>
    <ul>
        <li><a href="formular.php">Komentáře</a></li>
        <li><a href="logout.php">Odhlásit se</a></li>
    </ul>
</body>
</html>
