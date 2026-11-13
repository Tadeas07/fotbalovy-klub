<?php
/**
 * Přehled hráčů - FK Náchod (Mládež)
 * Rozpracovaná verze maturitního projektu
 */
require_once __DIR__ . '/db.php';

// Získání ID týmu z filtru v URL
$filtr_tym = isset($_GET['tym']) ? (int)$_GET['tym'] : 0;

// Načtení všech aktivních týmů pro výběrové pole
$tymy_stmt = $pdo->query("SELECT id, nazev, vekova_kategorie FROM tymy WHERE aktivni = 1 ORDER BY vekova_kategorie");
$tymy = $tymy_stmt->fetchAll();

// Příprava SQL dotazu pro načtení hráčů
$sql = "SELECT h.id, h.jmeno, h.prijmeni, h.datum_narozeni, h.pozice, h.aktivni,
               t.nazev AS tym_nazev, t.vekova_kategorie
        FROM hraci h
        LEFT JOIN tymy t ON h.tym_id = t.id
        WHERE h.aktivni = 1";

$parametry = [];

// Pokud byl vybrán konkrétní tým, přidáme podmínku do WHERE
if ($filtr_tym > 0) {
    $sql .= " AND h.tym_id = ?";
    $parametry[] = $filtr_tym;
}

$sql .= " ORDER BY h.prijmeni ASC, h.jmeno ASC";

$stmt = $pdo->prepare($sql);
$stmt->execute($parametry);
$hraci = $stmt->fetchAll();

// Zpráva po přesměrování z formuláře
$zprava = $_GET['zprava'] ?? '';
?>
<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FK Náchod - Přehled hráčů</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<header class="hlavicka">
    <div class="obal">
        <div class="logo-nazev">
            <h1>FK Náchod - Mládež</h1>
            <span class="podtitul">Informační systém pro správu mládežnických kategorií</span>
        </div>
        <nav class="navigace">
            <a href="index.php" class="aktivni">Seznam hráčů</a>
            <a href="pridat.php">+ Přidat nového hráče</a>
        </nav>
    </div>
</header>

<main class="obal hlavni-obsah">
    
    <div class="status-box">
        <strong>Stav projektu (k 13. 11.):</strong> Rozpracovaná verze aplikace. Je funkční načítání seznamu z databáze s filtrací, detail hráče a přidání nového záznamu s kontrolou věku. Další sekce (Zápasy, Tréninky) jsou navrženy v databázi a wireframech pro další etapu.
    </div>

    <div class="nadpis-akce">
        <h2>Seznam registrovaných hráčů</h2>
        <a href="pridat.php" class="tlacitko tlacitko-hlavni">+ Přidat hráče</a>
    </div>

    <?php if ($zprava === 'pridano'): ?>
        <div class="upozorneni upozorneni-uspech">
            Hráč byl úspěšně zaregistrován a uložen do databáze.
        </div>
    <?php endif; ?>

    <!-- Filtrovací lišta -->
    <div class="filtr-panel">
        <form method="get" action="index.php">
            <label for="filtr-tym">Filtrovat podle kategorie týmu:</label>
            <select name="tym" id="filtr-tym" onchange="this.form.submit()">
                <option value="0">-- Všechny kategorie --</option>
                <?php foreach ($tymy as $t): ?>
                    <option value="<?= $t['id'] ?>" <?= $filtr_tym == $t['id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($t['nazev']) ?> (<?= htmlspecialchars($t['vekova_kategorie']) ?>)
                    </option>
                <?php endforeach; ?>
            </select>
            <?php if ($filtr_tym > 0): ?>
                <a href="index.php" class="odkaz-reset">Zrušit filtr</a>
            <?php endif; ?>
        </form>
    </div>

    <!-- Tabulka hráčů -->
    <div class="tabulka-obal">
        <table class="tabulka">
            <thead>
                <tr>
                    <th style="width: 50px;">#</th>
                    <th>Příjmení</th>
                    <th>Jméno</th>
                    <th>Datum narození</th>
                    <th>Pozice</th>
                    <th>Tým (kategorie)</th>
                    <th style="width: 100px;">Akce</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($hraci)): ?>
                    <tr>
                        <td colspan="7" class="prazdno">V této kategorii zatím nejsou evidováni žádní hráči.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($hraci as $index => $h): ?>
                        <tr>
                            <td><?= $index + 1 ?></td>
                            <td><strong><?= htmlspecialchars($h['prijmeni']) ?></strong></td>
                            <td><?= htmlspecialchars($h['jmeno']) ?></td>
                            <td><?= date('d. m. Y', strtotime($h['datum_narozeni'])) ?></td>
                            <td>
                                <span class="stitek post-<?= htmlspecialchars($h['pozice']) ?>">
                                    <?= htmlspecialchars($h['pozice']) ?>
                                </span>
                            </td>
                            <td>
                                <?= htmlspecialchars($h['tym_nazev'] ?? 'Bez přiřazení') ?>
                                <?php if ($h['vekova_kategorie']): ?>
                                    <small>(<?= htmlspecialchars($h['vekova_kategorie']) ?>)</small>
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="detail.php?id=<?= $h['id'] ?>" class="tlacitko tlacitko-male">Detail</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="pocitadlo">
        Celkem zobrazeno hráčů: <strong><?= count($hraci) ?></strong>
    </div>

</main>

<footer class="paticka">
    <div class="obal">
        <p>Maturitní projekt: Informační systém pro mládežnický fotbalový klub | Autor: Tadeáš | Školní rok 2026/2027</p>
    </div>
</footer>

</body>
</html>
