<?php
$db_host = 'localhost';
$db_name = 'fk_nachod';
$db_user = 'root';
$db_pass = '';

try {
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
} catch (PDOException $e) {
    die("Chyba při připojování k databázi: " . $e->getMessage());
}
