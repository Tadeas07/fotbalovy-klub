<?php
require_once __DIR__ . '/db.php';
?>
<!DOCTYPE html>
<html lang="cs"><head><meta charset="UTF-8"><title>Přidat hráče</title></head>
<body><header><h1>⚽ FK Náchod – Mládež</h1></header>
<main class="container">
<h2>Přidat hráče</h2>
<form method="post">
    <input type="text" name="jmeno" placeholder="Jméno"><br>
    <input type="text" name="prijmeni" placeholder="Příjmení"><br>
    <button type="submit">Uložit</button>
</form>
</main></body></html>
