<?php
require_once __DIR__ . '/db.php';
if (<?php
require_once __DIR__ . '/db.php';
$zapasy = $pdo->query("SELECT z.*, t.nazev AS tym_nazev FROM zapasy z JOIN tymy t ON z.tym_id = t.id ORDER BY z.datum DESC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="cs"><head><meta charset="UTF-8"><title>Zápasy</title></head>
<body><header><h1>⚽ FK Náchod – Mládež</h1></header>
<main class="container">
<h2>Zápasy</h2>
<table>
<?php foreach ($zapasy as $z): ?>
    <tr><td><?= date('d. m. Y', strtotime($z['datum'])) ?></td><td><?= htmlspecialchars($z['souper']) ?></td></tr>
<?php endforeach; ?>
</table>
</main></body></html>

SERVER['REQUEST_METHOD'] === 'POST' && isset(<?php
require_once __DIR__ . '/db.php';
$zapasy = $pdo->query("SELECT z.*, t.nazev AS tym_nazev FROM zapasy z JOIN tymy t ON z.tym_id = t.id ORDER BY z.datum DESC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="cs"><head><meta charset="UTF-8"><title>Zápasy</title></head>
<body><header><h1>⚽ FK Náchod – Mládež</h1></header>
<main class="container">
<h2>Zápasy</h2>
<table>
<?php foreach ($zapasy as $z): ?>
    <tr><td><?= date('d. m. Y', strtotime($z['datum'])) ?></td><td><?= htmlspecialchars($z['souper']) ?></td></tr>
<?php endforeach; ?>
</table>
</main></body></html>

POST['zapas_id'])) {
    $zid = (int)<?php
require_once __DIR__ . '/db.php';
$zapasy = $pdo->query("SELECT z.*, t.nazev AS tym_nazev FROM zapasy z JOIN tymy t ON z.tym_id = t.id ORDER BY z.datum DESC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="cs"><head><meta charset="UTF-8"><title>Zápasy</title></head>
<body><header><h1>⚽ FK Náchod – Mládež</h1></header>
<main class="container">
<h2>Zápasy</h2>
<table>
<?php foreach ($zapasy as $z): ?>
    <tr><td><?= date('d. m. Y', strtotime($z['datum'])) ?></td><td><?= htmlspecialchars($z['souper']) ?></td></tr>
<?php endforeach; ?>
</table>
</main></body></html>

POST['zapas_id'];
    $sd = <?php
require_once __DIR__ . '/db.php';
$zapasy = $pdo->query("SELECT z.*, t.nazev AS tym_nazev FROM zapasy z JOIN tymy t ON z.tym_id = t.id ORDER BY z.datum DESC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="cs"><head><meta charset="UTF-8"><title>Zápasy</title></head>
<body><header><h1>⚽ FK Náchod – Mládež</h1></header>
<main class="container">
<h2>Zápasy</h2>
<table>
<?php foreach ($zapasy as $z): ?>
    <tr><td><?= date('d. m. Y', strtotime($z['datum'])) ?></td><td><?= htmlspecialchars($z['souper']) ?></td></tr>
<?php endforeach; ?>
</table>
</main></body></html>

POST['skore_domaci'] !== '' ? (int)<?php
require_once __DIR__ . '/db.php';
$zapasy = $pdo->query("SELECT z.*, t.nazev AS tym_nazev FROM zapasy z JOIN tymy t ON z.tym_id = t.id ORDER BY z.datum DESC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="cs"><head><meta charset="UTF-8"><title>Zápasy</title></head>
<body><header><h1>⚽ FK Náchod – Mládež</h1></header>
<main class="container">
<h2>Zápasy</h2>
<table>
<?php foreach ($zapasy as $z): ?>
    <tr><td><?= date('d. m. Y', strtotime($z['datum'])) ?></td><td><?= htmlspecialchars($z['souper']) ?></td></tr>
<?php endforeach; ?>
</table>
</main></body></html>

POST['skore_domaci'] : null;
    $sh = <?php
require_once __DIR__ . '/db.php';
$zapasy = $pdo->query("SELECT z.*, t.nazev AS tym_nazev FROM zapasy z JOIN tymy t ON z.tym_id = t.id ORDER BY z.datum DESC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="cs"><head><meta charset="UTF-8"><title>Zápasy</title></head>
<body><header><h1>⚽ FK Náchod – Mládež</h1></header>
<main class="container">
<h2>Zápasy</h2>
<table>
<?php foreach ($zapasy as $z): ?>
    <tr><td><?= date('d. m. Y', strtotime($z['datum'])) ?></td><td><?= htmlspecialchars($z['souper']) ?></td></tr>
<?php endforeach; ?>
</table>
</main></body></html>

POST['skore_hoste'] !== '' ? (int)<?php
require_once __DIR__ . '/db.php';
$zapasy = $pdo->query("SELECT z.*, t.nazev AS tym_nazev FROM zapasy z JOIN tymy t ON z.tym_id = t.id ORDER BY z.datum DESC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="cs"><head><meta charset="UTF-8"><title>Zápasy</title></head>
<body><header><h1>⚽ FK Náchod – Mládež</h1></header>
<main class="container">
<h2>Zápasy</h2>
<table>
<?php foreach ($zapasy as $z): ?>
    <tr><td><?= date('d. m. Y', strtotime($z['datum'])) ?></td><td><?= htmlspecialchars($z['souper']) ?></td></tr>
<?php endforeach; ?>
</table>
</main></body></html>

POST['skore_hoste'] : null;
    if ($sd !== null && $sh !== null) {
        $pdo->prepare("UPDATE zapasy SET skore_domaci=?, skore_hoste=? WHERE id=?")->execute([$sd,$sh,$zid]);
    }
}
$zapasy = $pdo->query("SELECT z.*, t.nazev AS tym_nazev FROM zapasy z JOIN tymy t ON z.tym_id = t.id ORDER BY z.datum DESC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="cs"><head><meta charset="UTF-8"><title>Zápasy</title></head>
<body><header><h1>⚽ FK Náchod – Mládež</h1></header>
<main class="container">
<h2>Zápasy</h2>
<table>
<?php foreach ($zapasy as $z): ?>
    <tr><td><?= date('d. m. Y', strtotime($z['datum'])) ?></td><td><?= htmlspecialchars($z['souper']) ?></td></tr>
<?php endforeach; ?>
</table>
</main></body></html>


