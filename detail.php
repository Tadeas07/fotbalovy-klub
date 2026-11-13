<?php
require_once __DIR__ . '/db.php';
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) { header('Location: index.php'); exit; }
?>
<!DOCTYPE html>
<html lang="cs"><head><meta charset="UTF-8"><title>Detail hráče</title><link rel="stylesheet" href="css/style.css"></head>
<body><header class="hlavicka"><div class="obal"><h1>FK Náchod - Mládež</h1></div></header>
<main class="obal"><?php
$stmt = $pdo->prepare("SELECT h.*, t.nazev AS tym_nazev, t.vekova_kategorie FROM hraci h LEFT JOIN tymy t ON h.tym_id = t.id WHERE h.id = ?");
$stmt->execute([$id]);
$hrac = $stmt->fetch();
?>
<h2><?= htmlspecialchars($hrac['prijmeni'] . ' ' . $hrac['jmeno']) ?></h2>
<p>Datum narození: <?= date('d. m. Y', strtotime($hrac['datum_narozeni'])) ?> (věk: <?= $vek ?> let)</p>
<p>Pozice: <?= htmlspecialchars($hrac['pozice']) ?></p>
<p>Tým: <?= htmlspecialchars($hrac['tym_nazev'] ?? 'Bez týmu') ?></p>
<p>Telefon rodiče: <?= htmlspecialchars($hrac['telefon_rodice'] ?: 'Neuvedeno') ?></p>
<p>E-mail rodiče: <?= htmlspecialchars($hrac['email_rodice'] ?: 'Neuvedeno') ?></p></main></body></html>




