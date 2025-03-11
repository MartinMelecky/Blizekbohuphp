<?php
declare(strict_types=1);

require('config.php');
require('functions.php');

$conn = mysqli_connect($config['servername'], $config['username'], $config['password'], $config['dbname']);

if (!$conn) {
    die("Připojení selhalo: " . mysqli_connect_error());
}
?>

