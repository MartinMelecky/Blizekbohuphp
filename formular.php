<?php require_once("config.php");
      include("./layout/hlava.php");
      include("./layout/navbar.php"); ?>
    <?php



if (isset($_SESSION["user_id"])) {
    
    $mysqli = require("database.php");
    
    $sql = "SELECT * FROM user
            WHERE id = {$_SESSION["user_id"]}";
            
    $result = $mysqli->query($sql);
    
    $user = $result->fetch_assoc();
}

?>
    <link rel="stylesheet" href="./cssform/form.css">
    
<div id="cerna">
  <h1>Zpětná vazba</h1>
<form>
  <input name="name" type="text" class="feedback-input" placeholder="Jméno" />
  <input name="email" type="text" class="feedback-input" placeholder="Email" />
  <textarea name="text" class="feedback-input" placeholder="text"></textarea>
  <input type="submit" value="ODESLAT"/>
</form>
</div>
<?php if (isset($user)): ?>
        
        <p>Hello <?= htmlspecialchars($user["jmeno"]) ?></p>
        
        <p><a href="logout.php">Log out</a></p>
        
    <?php else: ?>
        
        <p><a href="login.php">Log in</a> or <a href="signup.html">sign up</a></p>
        
    <?php endif; ?>

    <footer id="main-footer" class="bg-dark text-center py-1">
      <div class="container">
          <p>Copyright &copy; 2023, Království Nebeské</p>
      </div>
  </footer>
    <script></script>
</body>
</html>