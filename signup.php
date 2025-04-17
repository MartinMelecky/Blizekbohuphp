<?php require_once("config.php");
      include("./layout/hlava.php");
      include("./layout/navbar.php"); ?>

<link rel="stylesheet" href="./cssform/form.css">

<?php
$error_message = ""; // Proměnná pro ukládání chybové zprávy

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (empty($_POST["jmeno"])) {
        $error_message = "Je třeba zadat jméno";
    } elseif (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
        $error_message = "Je třeba zadat email";
    } elseif (strlen($_POST["heslo"]) < 8) {
        $error_message = "Heslo musí mít aspoň 8 znaků";
    } elseif (!preg_match("/[0-9]/", $_POST["heslo"])) {
        $error_message = "Heslo musí mít aspoň jedno číslo";
    } elseif ($_POST["heslo"] !== $_POST["heslo_znovu"]) {
        $error_message = "Hesla musí být stejná";
    } else {
        $password_hash = password_hash($_POST["heslo"], PASSWORD_DEFAULT);
        $mysqli = require("database.php");

        $sql = "INSERT INTO user (jmeno, email, password_hash) VALUES (?, ?, ?)";
        $stmt = $mysqli->stmt_init();

        if (!$stmt->prepare($sql)) {
            $error_message = "SQL error: " . $mysqli->error;
        } else {
            $stmt->bind_param("sss", $_POST["jmeno"], $_POST["email"], $password_hash);

            try {
                $stmt->execute();
                header("Location: prihlaseni.php");
                exit;
            } catch (mysqli_sql_exception $e) {
                if ($mysqli->errno === 1062) {
                    $error_message = "Email už byl použit.";
                } else {
                    $error_message = "Chyba: " . $mysqli->error;
                }
            }
        }
    }
}
?>

<script>
    <?php if (!empty($error_message)): ?>
        alert("<?php echo htmlspecialchars($error_message); ?>");
    <?php endif; ?>
</script>

<div id="cerna">
  <h1>Registrace</h1>

  <form action="" method="post" novalidate>
    <h3>Máte účet? Můžete se přihlásit zde =><a href="prihlaseni.php" class="btn">Přihlásit se</a></h3>   
    <input name="jmeno" type="text" class="feedback-input" placeholder="Jméno" />
    <input name="email" type="email" class="feedback-input" placeholder="Email" />
    <input name="heslo" type="password" class="feedback-input" placeholder="Heslo" />
    <input name="heslo_znovu" type="password" class="feedback-input" placeholder="Heslo znovu" />
    <input type="submit" value="Registrovat" />
  </form>
</div>

<footer id="main-footer" class="bg-dark text-center py-1">
  <div class="container">
      <p>Copyright &copy; 2023, Království Nebeské</p>
  </div>
</footer>
</body>
</html>