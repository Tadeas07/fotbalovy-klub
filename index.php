<?php
require_once __DIR__ . '/db.php';
$sql = "SELECT h.*, t.nazev AS tym_nazev, t.vekova_kategorie FROM hraci h LEFT JOIN tymy t ON h.tym_id = t.id WHERE h.aktivni = 1 ORDER BY h.prijmeni ASC";
$hraci = $pdo->query($sql)->fetchAll();
?>
