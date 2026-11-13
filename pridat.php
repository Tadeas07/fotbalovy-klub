<?php
require_once __DIR__ . '/db.php';
$chyby = [];
if (<?php
require_once __DIR__ . '/db.php';
$tymy = $pdo->query("SELECT id, nazev, vekova_kategorie, rok_narozeni_od, rok_narozeni_do FROM tymy WHERE aktivni = 1 ORDER BY vekova_kategorie")->fetchAll();
?>
<!DOCTYPE html>
<html lang="cs"><head><meta charset="UTF-8"><title>Přidat hráče</title></head>
<body><header><h1>⚽ FK Náchod – Mládež</h1></header>
<main class="container">
<h2>Přidat hráče</h2>
<form method="post">
    <input type="text" name="jmeno" placeholder="Jméno"><br>
    <input type="text" name="prijmeni" placeholder="Příjmení"><br>
    <select name="tym_id"><option value="0">— Vyberte tým —</option>
<?php foreach ($tymy as $t): ?><option value="<?= $t['id'] ?>"><?= htmlspecialchars($t['nazev']) ?></option><?php endforeach; ?>
</select><br>
<button type="submit">Uložit</button>
</form>
</main></body></html>

SERVER['REQUEST_METHOD'] === 'POST') {
    if (empty(trim(<?php
require_once __DIR__ . '/db.php';
$tymy = $pdo->query("SELECT id, nazev, vekova_kategorie, rok_narozeni_od, rok_narozeni_do FROM tymy WHERE aktivni = 1 ORDER BY vekova_kategorie")->fetchAll();
?>
<!DOCTYPE html>
<html lang="cs"><head><meta charset="UTF-8"><title>Přidat hráče</title></head>
<body><header><h1>⚽ FK Náchod – Mládež</h1></header>
<main class="container">
<h2>Přidat hráče</h2>
<form method="post">
    <input type="text" name="jmeno" placeholder="Jméno"><br>
    <input type="text" name="prijmeni" placeholder="Příjmení"><br>
    <select name="tym_id"><option value="0">— Vyberte tým —</option>
<?php foreach ($tymy as $t): ?><option value="<?= $t['id'] ?>"><?= htmlspecialchars($t['nazev']) ?></option><?php endforeach; ?>
</select><br>
<button type="submit">Uložit</button>
</form>
</main></body></html>

POST['jmeno'] ?? ''))) $chyby[] = 'Jméno je povinné.';
    if (empty(trim(<?php
require_once __DIR__ . '/db.php';
$tymy = $pdo->query("SELECT id, nazev, vekova_kategorie, rok_narozeni_od, rok_narozeni_do FROM tymy WHERE aktivni = 1 ORDER BY vekova_kategorie")->fetchAll();
?>
<!DOCTYPE html>
<html lang="cs"><head><meta charset="UTF-8"><title>Přidat hráče</title></head>
<body><header><h1>⚽ FK Náchod – Mládež</h1></header>
<main class="container">
<h2>Přidat hráče</h2>
<form method="post">
    <input type="text" name="jmeno" placeholder="Jméno"><br>
    <input type="text" name="prijmeni" placeholder="Příjmení"><br>
    <select name="tym_id"><option value="0">— Vyberte tým —</option>
<?php foreach ($tymy as $t): ?><option value="<?= $t['id'] ?>"><?= htmlspecialchars($t['nazev']) ?></option><?php endforeach; ?>
</select><br>
<button type="submit">Uložit</button>
</form>
</main></body></html>

POST['prijmeni'] ?? ''))) $chyby[] = 'Příjmení je povinné.';
}
$tymy = $pdo->query("SELECT id, nazev, vekova_kategorie, rok_narozeni_od, rok_narozeni_do FROM tymy WHERE aktivni = 1 ORDER BY vekova_kategorie")->fetchAll();
?>
<!DOCTYPE html>
<html lang="cs"><head><meta charset="UTF-8"><title>Přidat hráče</title></head>
<body><header><h1>⚽ FK Náchod – Mládež</h1></header>
<main class="container">
<h2>Přidat hráče</h2>
<form method="post">
    <input type="text" name="jmeno" placeholder="Jméno"><br>
    <input type="text" name="prijmeni" placeholder="Příjmení"><br>
    <select name="tym_id"><option value="0">— Vyberte tým —</option>
<?php foreach ($tymy as $t): ?><option value="<?= $t['id'] ?>"><?= htmlspecialchars($t['nazev']) ?></option><?php endforeach; ?>
</select><br>
<button type="submit">Uložit</button>
</form>
</main></body></html>





