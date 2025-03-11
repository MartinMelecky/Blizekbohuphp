<?php require_once("common.php");
      include("./layout/hlava.php");
      include("./layout/navbar.php"); ?>


<?php
// Zpracování registrace
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['jmeno'];
    $email = $_POST['email'];
    $password = $_POST['heslo'];

    // Validace dat
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Neplatný email!";
    } elseif (strlen($password) < 8) {
        echo "Heslo musí mít alespoň 6 znaků!";
    } else {
        // Zahashujeme heslo
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Příprava SQL dotazu
        $sql = "INSERT INTO user (jmeno, email, password_hash) VALUES ('$name', '$email', '$hashed_password')";

        if ($conn->query($sql) === TRUE) {
            echo "Registrace byla úspěšná!";
        } else {
            echo "Chyba při registraci: " . $conn->error;
        }
    }
}

$conn->close();
?>

<!-- HTML formulář pro registraci -->
<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <title>Registrace</title>
    <link rel="stylesheet" href="./cssform/form.css">
</head>
<body>
    <form method="POST" action="prihlaseni.php">
        <label for="name">Jméno:</label>
        <input type="text" id="name" name="jmeno" required><br><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>

        <label for="password">Heslo:</label>
        <input type="password" id="password" name="heslo" required><br><br>

        <input type="submit" value="Registrovat">
    </form>
</body>
</html>
