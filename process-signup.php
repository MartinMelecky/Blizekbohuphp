<?php
if (empty($_POST["jmeno"])) {
    die("je třeba zadat jméno");
}

if ( ! filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
    die("je třeba zadat email");
}

if (strlen($_POST["heslo"]) < 8) {
    die("Heslo musí mít aspoň 8 znaků");
}

if ( ! preg_match("/[0-9]/", $_POST["heslo"])) {
    die("Heslo musí mít aspoň jedno číslo");
}

if ($_POST["heslo"] !== $_POST["heslo_znovu"]) {
    die("Hesla musí být stejná");
}

$password_hash = password_hash($_POST["heslo"], PASSWORD_DEFAULT);
$mysqli = require("database.php");

$sql = "INSERT INTO user (jmeno, email, password_hash)
        VALUES (?, ?, ?)";

$stmt = $mysqli->stmt_init(); 

if ( ! $stmt->prepare($sql)) {
    die("SQL error: " . $mysqli->error);
}

$stmt->bind_param("sss",
                  $_POST["jmeno"],
                  $_POST["email"],
                  $password_hash);


                  if ($stmt->execute()) {

                    header("Location: prihlaseni.php");
                    exit;
                    
                } else {
                    
                    if ($mysqli->errno === 1062) {
                        die("Email už byl použit.");
                    } else {
                        die($mysqli->error . " " . $mysqli->errno);
                    }
                }

?>