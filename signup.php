<?php require_once("config.php");
      include("./layout/hlava.php");
      include("./layout/navbar.php"); ?>
    
    <link rel="stylesheet" href="./cssform/form.css">
    
<div id="cerna">
  <h1>Registrace</h1>

<form action="process-signup.php" method="post" novalidate>
<h3>Máte účet? Můžete se přihlásit zde =><a href="prihlaseni.php" class="btn">Přihlásit se</a></h3>   
<input name="jmeno" type="text" class="feedback-input" placeholder="Jméno" />
<input name="email" type="email" class="feedback-input" placeholder="Email" />
<input name="heslo" type ="password" class="feedback-input" placeholder="heslo"/>
<input name="heslo_znovu" type ="password" class="feedback-input" placeholder="heslo znovu"/>
<input type="submit" value="Registrovat"/>

</form>

</div>

    <footer id="main-footer" class="bg-dark text-center py-1">
      <div class="container">
          <p>Copyright &copy; 2023, Království Nebeské</p>
      </div>
  </footer>
</body>
</html>