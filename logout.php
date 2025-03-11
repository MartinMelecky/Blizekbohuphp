<?php
session_start();  // Spustí session

// Ukončí session
session_unset();
session_destroy();

// Přesměruje na úvodní stránku
header("Location: index.php");
exit();
?>
