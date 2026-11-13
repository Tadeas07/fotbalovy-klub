<?php
/**
 * FK Náchod – Přehled hráčů (index)
 * Zobrazuje seznam všech hráčů s filtrováním podle týmu.
 */
require_once __DIR__ . '/db.php';

// Filtr podle týmu
$filtr_tym = isset($_GET['tym']) ? (int)$_GET['tym'] : 0;

// Načtení týmů pro select
$tymy = $pdo->query("SELECT id, nazev, vekova_kategorie FROM tymy WHERE aktivni = 1 ORDER BY vekova_kategorie")->fetchAll();

// Načtení hráčů
$sql = "SELECT h.*, t.nazev AS tym_nazev, t.vekova_kategorie
        FROM hraci h
        LEFT JOIN tymy t ON h.tym_id = t.id
        WHERE h.aktivni = 1";
$params = [];

if ($filtr_tym > 0) {
    $sql .= " AND h.tym_id = ?";
    $params[] = $filtr_tym;
}
$sql .= " ORDER BY h.prijmeni, h.jmeno";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$hraci = $stmt->fetchAll();

// Flash zprávy
$zprava = $_GET['zprava'] ?? '';
?>
<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FK Náchod – Hráči</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<header>
    <div class="container">
        <h1>⚽ FK Náchod – Mládež</h1>
        <nav>
            <a href="index.php" class="active">Hráči</a>
            <a href="zapasy.php">Zápasy</a>
            <a href="treninky.php">Tréninky</a>
            <a href="pridat.php">+ Přidat hráče</a>
        </nav>
    </div>
</header>

<main class="container">
    <h2>Přehled hráčů</h2>

    <?php if ($zprava === 'pridano'): ?>
        <div class="alert alert-success">✅ Hráč byl úspěšně přidán.</div>
    <?php elseif ($zprava === 'chyba_vek'): ?>
        <div class="alert alert-error">❌ Hráč nebyl přidán – věk neodpovídá kategorii týmu.</div>
    <?php endif; ?>

    <!-- Filtr -->
    <form method="get" class="filtr">
        <label for="tym">Filtrovat podle týmu:</label>
        <select name="tym" id="tym" onchange="this.form.submit()">
            <option value="0">Všechny týmy</option>
            <?php foreach ($tymy as $t): ?>
                <option value="<?= $t['id'] ?>" <?= $filtr_tym == $t['id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($t['nazev']) ?> (<?= $t['vekova_kategorie'] ?>)
                </option>
            <?php endforeach; ?>
        </select>
    </form>

    <!-- Tabulka hráčů -->
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Příjmení</th>
                <th>Jméno</th>
                <th>Datum narození</th>
                <th>Pozice</th>
                <th>Tým</th>
                <th>Akce</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($hraci)): ?>
                <tr><td colspan="7" class="text-center">Žádní hráči nenalezeni.</td></tr>
            <?php else: ?>
                <?php foreach ($hraci as $i => $h): ?>
                    <tr>
                        <td><?= $i + 1 ?></td>
                        <td><?= htmlspecialchars($h['prijmeni']) ?></td>
                        <td><?= htmlspecialchars($h['jmeno']) ?></td>
                        <td><?= date('d. m. Y', strtotime($h['datum_narozeni'])) ?></td>
                        <td><span class="badge badge-<?= $h['pozice'] ?>"><?= htmlspecialchars($h['pozice']) ?></span></td>
                        <td><?= htmlspecialchars($h['tym_nazev'] ?? '—') ?></td>
                        <td><a href="detail.php?id=<?= $h['id'] ?>" class="btn btn-sm">Detail</a></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>

    <p class="pocet">Celkem hráčů: <strong><?= count($hraci) ?></strong></p>
</main>

<footer>
    <div class="container">
        <p>&copy; <?= date('Y') ?> FK Náchod – Mládežnický fotbalový klub | Školní projekt SPŠE Litomyšl</p>
    </div>
</footer>

</body>
</html>
