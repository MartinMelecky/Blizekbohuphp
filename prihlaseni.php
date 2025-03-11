<?php require_once("config.php");
      include("./layout/hlava.php");
      include("./layout/navbar.php"); ?>


<?php      $is_invalid = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    $mysqli = require("database.php" ) ;
    
    $sql = sprintf("SELECT * FROM user
                    WHERE email = '%s'",
                   $mysqli->real_escape_string($_POST["email"]));
    
    $result = $mysqli->query($sql);
    
    $user = $result->fetch_assoc();
    
    if ($user) {
        
        if (password_verify($_POST["heslo"], $user["password_hash"])) {
            
            session_start();
            
            session_regenerate_id();
            
            $_SESSION["user_id"] = $user["id"];
            
            header("Location: formular.php");
            exit;
        }
    }
    
    $is_invalid = true;
}
?>

    
    <link rel="stylesheet" href="./cssform/form.css">
    
<div id="cerna">
  <h1>Přihlášení</h1>
  <?php if ($is_invalid): ?>
        <script>alert("špatné údaje")</script>
    <?php endif; ?>
<form  method="post">
<input name="email" type="email" class="feedback-input" placeholder="Email" />
<input name="heslo" type ="password" class="feedback-input" placeholder="heslo"/>
<input type="submit" value="Přihlásit se"/>
</form>
</div>

    <footer id="main-footer" class="bg-dark text-center py-1">
      <div class="container">
          <p>Copyright &copy; 2023, Království Nebeské</p>
      </div>
  </footer>
</body>
</html>