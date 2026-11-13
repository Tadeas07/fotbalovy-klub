<?php
require_once __DIR__ . '/db.php';
$tymy = $pdo->query("SELECT id, nazev, vekova_kategorie, rok_narozeni_od, rok_narozeni_do FROM tymy WHERE aktivni = 1 ORDER BY vekova_kategorie")->fetchAll();
?>
<!DOCTYPE html>
<html lang="cs"><head><meta charset="UTF-8"><title>Přidat hráče</title><link rel="stylesheet" href="css/style.css"></head>
<body><header class="hlavicka"><div class="obal"><h1>FK Náchod - Mládež</h1></div></header>
<main class="obal">
    <h2>Registrace nového hráče</h2>
    <form method="post">
        <label>Jméno: <input type="text" name="jmeno"></label><br>
        <label>Příjmení: <input type="text" name="prijmeni"></label><br>
        <label>Tým: <select name="tym_id"><option value="0">-- Vyberte tým --</option>
<?php foreach ($tymy as $t): ?><option value="<?= $t['id'] ?>"><?= htmlspecialchars($t['nazev']) ?> (ročníky <?= $t['rok_narozeni_od'] ?> - <?= $t['rok_narozeni_do'] ?>)</option><?php endforeach; ?>
</select></label><br>
<button type="submit">Uložit hráče</button>
    </form>
</main></body></html>

