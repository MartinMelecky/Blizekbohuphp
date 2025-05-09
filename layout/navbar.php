
<?php
session_start(); // Spustí session
?>
    <!-- Navbar -->
    <nav id="navbar">
    <div id="logo"><a href="index.php"><img src="img/logo ctverec.svg" alt="" class="obrazek"> Blíže k Bohu</a></div>
    <?php   
if (isset($_SESSION["user_id"])) {
    $mysqli = require("database.php");
    $sql = "SELECT * FROM user
            WHERE id = {$_SESSION["user_id"]}";  
    $result = $mysqli->query($sql);
    $user = $result->fetch_assoc();
}
?>
<?php if (isset($user)): ?>
        <h2 class="vitaj">Vítejte <?= htmlspecialchars($user["jmeno"]) ?></h2>
    <?php endif; ?>
        <label for="toggler"><i class="fa-solid fa-bars"></i></label>
        <input type="checkbox" id="toggler" name="">
        <div class="topnav">
        <ul class="lisst">
            <li><a href="./Bible.php">Bible</a></li>
            <li><a href="./modlitby.php">Modlitby</a></li>
            <li><a href="./postavy.php">Postavy</a></li>
            <li><a href="./hrichy.php"> Hříchy</a></li>
            <?php
            // Pokud je uživatel přihlášen, zobrazí se tlačítko na komentáře
            if (isset($_SESSION['user_id'])) {
                echo '<li><a href="profil.php">Profil</a></li>';
            }
            ?>
            <?php
            // Pokud je uživatel přihlášen, zobrazí se tlačítko pro odhlášení
            if (isset($_SESSION['user_id'])) {
                echo '<li><a href="logout.php">Odhlásit</a></li>';
            } else {
                // Pokud není uživatel přihlášen, zobrazí se tlačítko pro přihlášení
                echo '<li><a href="prihlaseni.php">Přihlásit se</a></li>';
                echo '<li><a href="signup.php">Registrovat se</a></li>';
            }
            ?>
        </ul></div>
    </nav>
</body>
</html>
