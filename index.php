<?php
require_once __DIR__ . '/db.php';
$hraci = $pdo->query("SELECT h.*, t.nazev AS tym_nazev, t.vekova_kategorie FROM hraci h LEFT JOIN tymy t ON h.tym_id = t.id WHERE aktivni = 1 ORDER BY prijmeni")->fetchAll();
?>
<!DOCTYPE html>
<html lang="cs">
<head><meta charset="UTF-8"><title>FK Náchod - Hráči</title></head>
<body>
<header><h1>FK Náchod - Mládež</h1></header>
<main>
    <?php
$filtr_tym = isset(<?php
require_once __DIR__ . '/db.php';
$hraci = $pdo->query("SELECT h.*, t.nazev AS tym_nazev, t.vekova_kategorie FROM hraci h LEFT JOIN tymy t ON h.tym_id = t.id WHERE aktivni = 1 ORDER BY prijmeni")->fetchAll();
?>
<!DOCTYPE html>
<html lang="cs">
<head><meta charset="UTF-8"><title>FK Náchod - Hráči</title></head>
<body>
<header><h1>FK Náchod - Mládež</h1></header>
<main>
    <h2>Seznam hráčů</h2>
    <table>
        <tr><th>Příjmení</th><th>Jméno</th><th>Datum narození</th><th>Pozice</th><th>Tým</th><th>Akce</th></tr>
        <?php foreach ($hraci as $h): ?>
            <tr><td><?= htmlspecialchars($h['prijmeni']) ?></td><td><?= htmlspecialchars($h['jmeno']) ?></td></tr>
        <?php endforeach; ?>
<?php endif; ?>
    </table>
<p>Celkem zobrazeno hráčů: <strong><?= count($hraci) ?></strong></p>
</main>
</body>
</html>




GET['tym']) ? (int)<?php
require_once __DIR__ . '/db.php';
$hraci = $pdo->query("SELECT h.*, t.nazev AS tym_nazev, t.vekova_kategorie FROM hraci h LEFT JOIN tymy t ON h.tym_id = t.id WHERE aktivni = 1 ORDER BY prijmeni")->fetchAll();
?>
<!DOCTYPE html>
<html lang="cs">
<head><meta charset="UTF-8"><title>FK Náchod - Hráči</title></head>
<body>
<header><h1>FK Náchod - Mládež</h1></header>
<main>
    <h2>Seznam hráčů</h2>
    <table>
        <tr><th>Příjmení</th><th>Jméno</th><th>Datum narození</th><th>Pozice</th><th>Tým</th><th>Akce</th></tr>
        <?php foreach ($hraci as $h): ?>
            <tr><td><?= htmlspecialchars($h['prijmeni']) ?></td><td><?= htmlspecialchars($h['jmeno']) ?></td></tr>
        <?php endforeach; ?>
<?php endif; ?>
    </table>
<p>Celkem zobrazeno hráčů: <strong><?= count($hraci) ?></strong></p>
</main>
</body>
</html>




GET['tym'] : 0;
$tymy = $pdo->query("SELECT id, nazev, vekova_kategorie FROM tymy WHERE aktivni = 1 ORDER BY vekova_kategorie")->fetchAll();
?>
<h2>Seznam hráčů</h2>
<form method="get">
    <label>Filtrovat podle týmu:</label>
    <select name="tym" onchange="this.form.submit()">
        <option value="0">Všechny kategorie</option>
        <?php foreach ($tymy as $t): ?>
            <option value="<?= $t['id'] ?>" <?= $filtr_tym == $t['id'] ? 'selected' : '' ?>><?= htmlspecialchars($t['nazev']) ?></option>
        <?php endforeach; ?>
    </select>
</form>
    <table>
        <tr><th>Příjmení</th><th>Jméno</th><th>Datum narození</th><th>Pozice</th><th>Tým</th><th>Akce</th></tr>
        <?php foreach ($hraci as $h): ?>
            <tr><td><?= htmlspecialchars($h['prijmeni']) ?></td><td><?= htmlspecialchars($h['jmeno']) ?></td></tr>
        <?php endforeach; ?>
<?php endif; ?>
    </table>
<p>Celkem zobrazeno hráčů: <strong><?= count($hraci) ?></strong></p>
</main>
</body>
</html>








