<?php
/**
 * FK Náchod – Přehled zápasů
 * Stránka s aplikační logikou:
 *  - Skóre lze zadat pouze u zápasů, které již proběhly
 *  - Automatické rozlišení odehraných / nadcházejících
 *  - Statistiky (bilance výher/proher)
 */
require_once __DIR__ . '/db.php';

$dnes = date('Y-m-d');

// Zpracování formuláře pro zadání skóre
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['zapas_id'])) {
    $zapas_id = (int)$_POST['zapas_id'];
    $skore_d  = $_POST['skore_domaci'] !== '' ? (int)$_POST['skore_domaci'] : null;
    $skore_h  = $_POST['skore_hoste'] !== '' ? (int)$_POST['skore_hoste'] : null;

    // APLIKAČNÍ LOGIKA: skóre lze zadat pouze u zápasů s datem <= dnes
    $stmt = $pdo->prepare("SELECT datum FROM zapasy WHERE id = ?");
    $stmt->execute([$zapas_id]);
    $zapas = $stmt->fetch();

    if ($zapas && $zapas['datum'] <= $dnes) {
        if ($skore_d !== null && $skore_h !== null && $skore_d >= 0 && $skore_h >= 0) {
            $stmt = $pdo->prepare("UPDATE zapasy SET skore_domaci = ?, skore_hoste = ? WHERE id = ?");
            $stmt->execute([$skore_d, $skore_h, $zapas_id]);
        }
    }

    header('Location: zapasy.php?zprava=skore_ulozeno');
    exit;
}

// Filtr
$filtr_tym = isset($_GET['tym']) ? (int)$_GET['tym'] : 0;
$tymy = $pdo->query("SELECT id, nazev, vekova_kategorie FROM tymy WHERE aktivni = 1 ORDER BY vekova_kategorie")->fetchAll();

// Načtení zápasů
$sql = "SELECT z.*, t.nazev AS tym_nazev, t.vekova_kategorie
        FROM zapasy z
        JOIN tymy t ON z.tym_id = t.id";
$params = [];
if ($filtr_tym > 0) {
    $sql .= " WHERE z.tym_id = ?";
    $params[] = $filtr_tym;
}
$sql .= " ORDER BY z.datum DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$zapasy = $stmt->fetchAll();

// Rozdělení na odehrané a nadcházející
$odehrane = [];
$nadchazejici = [];
foreach ($zapasy as $z) {
    if ($z['datum'] <= $dnes && $z['skore_domaci'] !== null) {
        $odehrane[] = $z;
    } else {
        $nadchazejici[] = $z;
    }
}

// Statistiky
$vyhry = $remiza = $prohry = 0;
foreach ($odehrane as $z) {
    if ($z['typ'] === 'domácí') {
        if ($z['skore_domaci'] > $z['skore_hoste']) $vyhry++;
        elseif ($z['skore_domaci'] == $z['skore_hoste']) $remiza++;
        else $prohry++;
    } else {
        if ($z['skore_hoste'] > $z['skore_domaci']) $vyhry++;
        elseif ($z['skore_hoste'] == $z['skore_domaci']) $remiza++;
        else $prohry++;
    }
}

$zprava = $_GET['zprava'] ?? '';
?>
<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FK Náchod – Zápasy</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<header>
    <div class="container">
        <h1>⚽ FK Náchod – Mládež</h1>
        <nav>
            <a href="index.php">Hráči</a>
            <a href="zapasy.php" class="active">Zápasy</a>
            <a href="treninky.php">Tréninky</a>
            <a href="pridat.php">+ Přidat hráče</a>
        </nav>
    </div>
</header>

<main class="container">
    <h2>Přehled zápasů</h2>

    <?php if ($zprava === 'skore_ulozeno'): ?>
        <div class="alert alert-success">✅ Skóre bylo uloženo.</div>
    <?php endif; ?>

    <!-- Statistiky -->
    <?php if (!empty($odehrane)): ?>
    <div class="statistiky">
        <div class="stat stat-win"><span class="stat-num"><?= $vyhry ?></span> Výher</div>
        <div class="stat stat-draw"><span class="stat-num"><?= $remiza ?></span> Remíz</div>
        <div class="stat stat-loss"><span class="stat-num"><?= $prohry ?></span> Proher</div>
        <div class="stat"><span class="stat-num"><?= count($odehrane) ?></span> Celkem</div>
    </div>
    <?php endif; ?>

    <!-- Filtr -->
    <form method="get" class="filtr">
        <label for="tym">Tým:</label>
        <select name="tym" id="tym" onchange="this.form.submit()">
            <option value="0">Všechny týmy</option>
            <?php foreach ($tymy as $t): ?>
                <option value="<?= $t['id'] ?>" <?= $filtr_tym == $t['id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($t['nazev']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </form>

    <!-- Nadcházející zápasy -->
    <h3>📅 Nadcházející zápasy</h3>
    <?php if (empty($nadchazejici)): ?>
        <p class="text-muted">Žádné naplánované zápasy.</p>
    <?php else: ?>
    <table>
        <thead>
            <tr><th>Datum</th><th>Tým</th><th>Soupeř</th><th>Typ</th><th>Místo</th><th>Skóre</th></tr>
        </thead>
        <tbody>
            <?php foreach ($nadchazejici as $z): ?>
                <tr>
                    <td><?= date('d. m. Y', strtotime($z['datum'])) ?> <?= $z['cas'] ? date('H:i', strtotime($z['cas'])) : '' ?></td>
                    <td><?= htmlspecialchars($z['tym_nazev']) ?></td>
                    <td><?= htmlspecialchars($z['souper']) ?></td>
                    <td><?= $z['typ'] === 'domácí' ? '🏠' : '✈️' ?></td>
                    <td><?= htmlspecialchars($z['misto'] ?? '—') ?></td>
                    <td>
                        <?php if ($z['datum'] <= $dnes && $z['skore_domaci'] === null): ?>
                            <!-- Zápas proběhl ale nemá skóre – lze zadat -->
                            <form method="post" class="form-inline">
                                <input type="hidden" name="zapas_id" value="<?= $z['id'] ?>">
                                <input type="number" name="skore_domaci" min="0" max="99" class="input-score" placeholder="D">
                                <span>:</span>
                                <input type="number" name="skore_hoste" min="0" max="99" class="input-score" placeholder="H">
                                <button type="submit" class="btn btn-sm">✓</button>
                            </form>
                        <?php else: ?>
                            <em>čeká se</em>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php endif; ?>

    <!-- Odehrané zápasy -->
    <h3>✅ Odehrané zápasy</h3>
    <?php if (empty($odehrane)): ?>
        <p class="text-muted">Zatím žádné odehrané zápasy.</p>
    <?php else: ?>
    <table>
        <thead>
            <tr><th>Datum</th><th>Tým</th><th>Soupeř</th><th>Typ</th><th>Výsledek</th></tr>
        </thead>
        <tbody>
            <?php foreach ($odehrane as $z): ?>
                <?php
                    $vysledek = '';
                    if ($z['typ'] === 'domácí') {
                        if ($z['skore_domaci'] > $z['skore_hoste']) $vysledek = 'win';
                        elseif ($z['skore_domaci'] == $z['skore_hoste']) $vysledek = 'draw';
                        else $vysledek = 'loss';
                    } else {
                        if ($z['skore_hoste'] > $z['skore_domaci']) $vysledek = 'win';
                        elseif ($z['skore_hoste'] == $z['skore_domaci']) $vysledek = 'draw';
                        else $vysledek = 'loss';
                    }
                ?>
                <tr class="row-<?= $vysledek ?>">
                    <td><?= date('d. m. Y', strtotime($z['datum'])) ?></td>
                    <td><?= htmlspecialchars($z['tym_nazev']) ?></td>
                    <td><?= htmlspecialchars($z['souper']) ?></td>
                    <td><?= $z['typ'] === 'domácí' ? '🏠' : '✈️' ?></td>
                    <td><strong><?= $z['skore_domaci'] ?>:<?= $z['skore_hoste'] ?></strong></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php endif; ?>
</main>

<footer>
    <div class="container">
        <p>&copy; <?= date('Y') ?> FK Náchod – Mládežnický fotbalový klub | Školní projekt SPŠE Litomyšl</p>
    </div>
</footer>

</body>
</html>
