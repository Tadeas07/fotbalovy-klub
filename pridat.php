<?php
require_once __DIR__ . '/db.php';
$tymy = $pdo->query("SELECT * FROM tymy WHERE aktivni = 1")->fetchAll();
?>
