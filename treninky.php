<?php
/**
 * FK Náchod – Přehled tréninků
 */
require_once __DIR__ . '/db.php';

$dnes = date('Y-m-d');
$filtr_tym = isset($_GET['tym']) ? (int)$_GET['tym'] : 0;

$tymy = $pdo->query("SELECT id, nazev, vekova_kategorie FROM tymy WHERE aktivni = 1 ORDER BY vekova_kategorie")->fetchAll();

$sql = "SELECT tr.*, t.nazev AS tym_nazev
        FROM treninky tr
        JOIN tymy t ON tr.tym_id = t.id";
$params = [];
if ($filtr_tym > 0) {
    $sql .= " WHERE tr.tym_id = ?";
    $params[] = $filtr_tym;
}
$sql .= " ORDER BY tr.datum DESC, tr.cas_od";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$treninky = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FK Náchod – Tréninky</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<header>
    <div class="container">
        <h1>⚽ FK Náchod – Mládež</h1>
        <nav>
            <a href="index.php">Hráči</a>
            <a href="zapasy.php">Zápasy</a>
            <a href="treninky.php" class="active">Tréninky</a>
            <a href="pridat.php">+ Přidat hráče</a>
        </nav>
    </div>
</header>

<main class="container">
    <h2>Rozvrh tréninků</h2>

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

    <table>
        <thead>
            <tr><th>Datum</th><th>Čas</th><th>Tým</th><th>Místo</th><th>Popis</th></tr>
        </thead>
        <tbody>
            <?php if (empty($treninky)): ?>
                <tr><td colspan="5" class="text-center">Žádné tréninky.</td></tr>
            <?php else: ?>
                <?php foreach ($treninky as $tr): ?>
                    <tr class="<?= $tr['datum'] >= $dnes ? '' : 'row-past' ?>">
                        <td><?= date('d. m. Y', strtotime($tr['datum'])) ?></td>
                        <td><?= date('H:i', strtotime($tr['cas_od'])) ?> – <?= date('H:i', strtotime($tr['cas_do'])) ?></td>
                        <td><?= htmlspecialchars($tr['tym_nazev']) ?></td>
                        <td><?= htmlspecialchars($tr['misto']) ?></td>
                        <td><?= htmlspecialchars($tr['popis'] ?? '—') ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</main>

<footer>
    <div class="container">
        <p>&copy; <?= date('Y') ?> FK Náchod – Mládežnický fotbalový klub | Školní projekt SPŠE Litomyšl</p>
    </div>
</footer>

</body>
</html>
