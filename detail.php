<?php
require_once __DIR__ . '/db.php';
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) { header('Location: index.php'); exit; }
?>
<!DOCTYPE html>
<html lang="cs">
<head><meta charset="UTF-8"><title>Detail hráče</title></head>
<body><header><h1>⚽ FK Náchod – Mládež</h1></header><main class="container"><h2><?= htmlspecialchars($hrac['prijmeni'] . ' ' . $hrac['jmeno']) ?></h2><h3>Spoluhráči v týmu</h3>
<?php
$spolaci = [];
if ($hrac['tym_id']) {
    $st = $pdo->prepare("SELECT id, jmeno, prijmeni, pozice FROM hraci WHERE tym_id = ? AND id != ? AND aktivni = 1 ORDER BY prijmeni");
    $st->execute([$hrac['tym_id'], $id]);
    $spolaci = $st->fetchAll();
}
?>
<table>
<?php foreach ($spolaci as $s): ?>
    <tr><td><?= htmlspecialchars($s['prijmeni'] . ' ' . $s['jmeno']) ?></td><td><?= htmlspecialchars($s['pozice']) ?></td></tr>
<?php endforeach; ?>
</table>
<h3>Poslední zápasy týmu</h3>
<?php
$zapasy = [];
if ($hrac['tym_id']) {
    $st2 = $pdo->prepare("SELECT * FROM zapasy WHERE tym_id = ? ORDER BY datum DESC LIMIT 5");
    $st2->execute([$hrac['tym_id']]);
    $zapasy = $st2->fetchAll();
}
?>
<table>
<?php foreach ($zapasy as $z): ?>
    <tr><td><?= date('d. m. Y', strtotime($z['datum'])) ?></td><td><?= htmlspecialchars($z['souper']) ?></td></tr>
<?php endforeach; ?>
</table>
</main></body>
</html>





