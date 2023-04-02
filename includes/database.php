<?php
/**
 * Auth: Luis Tahuilán
 * Proyecto origen: Bienes Raices
 */

// debuguear($_ENV);

$localhost = $_ENV['DB_HOST'];
$user = $_ENV['DB_USER'];
$pass = $_ENV['DB_PASS'];
$dbname = $_ENV['DB_NAME'];


$db = mysqli_connect($localhost, $user, $pass, $dbname);
mysqli_set_charset($db, 'utf8');


if (!$db) {
    echo "Error: No se pudo conectar a MySQL.";
    echo "errno de depuración: " . mysqli_connect_errno();
    echo "error de depuración: " . mysqli_connect_error();
    exit;
}
