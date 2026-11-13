<?php
require_once __DIR__ . '/db.php';
$hraci = $pdo->query("SELECT * FROM hraci WHERE aktivni = 1 ORDER BY prijmeni")->fetchAll();
?>
<!DOCTYPE html>
<html lang="cs">
<head><meta charset="UTF-8"><title>FK Náchod - Hráči</title></head>
<body>
<header><h1>FK Náchod - Mládež</h1></header>
<main>
    <h2>Seznam hráčů</h2>
    <table>
        <tr><th>Příjmení</th><th>Jméno</th><th>Datum narození</th></tr>
        <?php foreach ($hraci as $h): ?>
            <tr><td><?= htmlspecialchars($h['prijmeni']) ?></td><td><?= htmlspecialchars($h['jmeno']) ?></td></tr>
        <?php endforeach; ?>
    </table>
</main>
</body>
</html>

