<?php
require_once __DIR__ . '/db.php';
?>
<!DOCTYPE html>
<html lang="cs"><head><meta charset="UTF-8"><title>Přidat hráče</title><link rel="stylesheet" href="css/style.css"></head>
<body><header class="hlavicka"><div class="obal"><h1>FK Náchod - Mládež</h1></div></header>
<main class="obal">
    <h2>Registrace nového hráče</h2>
    <form method="post">
        <label>Jméno: <input type="text" name="jmeno"></label><br>
        <label>Příjmení: <input type="text" name="prijmeni"></label><br>
        <button type="submit">Uložit hráče</button>
    </form>
</main></body></html>
