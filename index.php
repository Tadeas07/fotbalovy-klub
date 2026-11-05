<?php
require_once __DIR__ . '/db.php';
$stmt = $pdo->query("SELECT * FROM hraci WHERE aktivni = 1");
$hraci = $stmt->fetchAll();
?>
