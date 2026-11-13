<?php
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
