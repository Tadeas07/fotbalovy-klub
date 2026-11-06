<?php
require_once __DIR__ . '/db.php';
$sql = "SELECT h.*, t.nazev AS tym_nazev, t.vekova_kategorie FROM hraci h LEFT JOIN tymy t ON h.tym_id = t.id WHERE h.aktivni = 1 ORDER BY h.prijmeni ASC";
$hraci = $pdo->query($sql)->fetchAll();
?>
<!DOCTYPE html>
<html lang="cs">
<head><meta charset="UTF-8"><title>Přehled</title><link rel="stylesheet" href="css/style.css"></head>
<body>
<table class="tabulka">
<?php foreach ($hraci as $h): ?>
<tr><td><?= htmlspecialchars($h['prijmeni']) ?></td><td><?= date('d. m. Y', strtotime($h['datum_narozeni'])) ?></td></tr>
<?php endforeach; ?>
</table>
</body></html>
