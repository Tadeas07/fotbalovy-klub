<?php
require_once __DIR__ . '/db.php';
$treninky = $pdo->query("SELECT tr.*, t.nazev AS tym_nazev FROM treninky tr JOIN tymy t ON tr.tym_id = t.id ORDER BY tr.datum DESC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="cs"><head><meta charset="UTF-8"><title>Tréninky</title></head>
<body><header><h1>⚽ FK Náchod – Mládež</h1></header>
<main class="container">
<h2>Tréninky</h2>
<table>
<?php foreach ($treninky as $tr): ?>
    <tr><td><?= date('d. m. Y', strtotime($tr['datum'])) ?></td><td><?= htmlspecialchars($tr['tym_nazev']) ?></td></tr>
<?php endforeach; ?>
</table>
</main></body></html>
