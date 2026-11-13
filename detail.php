<?php
/**
 * FK Náchod – Detail hráče
 * Zobrazuje kompletní informace o hráči včetně jeho zápasů.
 */
require_once __DIR__ . '/db.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id <= 0) {
    header('Location: index.php');
    exit;
}

// Načtení hráče
$stmt = $pdo->prepare("
    SELECT h.*, t.nazev AS tym_nazev, t.vekova_kategorie
    FROM hraci h
    LEFT JOIN tymy t ON h.tym_id = t.id
    WHERE h.id = ?
");
$stmt->execute([$id]);
$hrac = $stmt->fetch();

if (!$hrac) {
    header('Location: index.php');
    exit;
}

// Spoluhráči ze stejného týmu
$spolaci = [];
if ($hrac['tym_id']) {
    $stmt2 = $pdo->prepare("
        SELECT id, jmeno, prijmeni, pozice
        FROM hraci
        WHERE tym_id = ? AND id != ? AND aktivni = 1
        ORDER BY prijmeni
    ");
    $stmt2->execute([$hrac['tym_id'], $id]);
    $spolaci = $stmt2->fetchAll();
}

// Nadcházející zápasy týmu
$zapasy = [];
if ($hrac['tym_id']) {
    $stmt3 = $pdo->prepare("
        SELECT * FROM zapasy
        WHERE tym_id = ?
        ORDER BY datum DESC
        LIMIT 5
    ");
    $stmt3->execute([$hrac['tym_id']]);
    $zapasy = $stmt3->fetchAll();
}

// Výpočet věku
$vek = (new DateTime($hrac['datum_narozeni']))->diff(new DateTime())->y;
?>
<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail hráče – <?= htmlspecialchars($hrac['prijmeni'] . ' ' . $hrac['jmeno']) ?></title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<header>
    <div class="container">
        <h1>⚽ FK Náchod – Mládež</h1>
        <nav>
            <a href="index.php">Hráči</a>
            <a href="zapasy.php">Zápasy</a>
            <a href="treninky.php">Tréninky</a>
            <a href="pridat.php">+ Přidat hráče</a>
        </nav>
    </div>
</header>

<main class="container">
    <a href="index.php" class="btn btn-back">&larr; Zpět na přehled</a>

    <div class="detail-card">
        <h2><?= htmlspecialchars($hrac['prijmeni'] . ' ' . $hrac['jmeno']) ?></h2>

        <div class="detail-grid">
            <div class="detail-item">
                <span class="label">Datum narození:</span>
                <span class="value"><?= date('d. m. Y', strtotime($hrac['datum_narozeni'])) ?> (<?= $vek ?> let)</span>
            </div>
            <div class="detail-item">
                <span class="label">Pozice:</span>
                <span class="value"><span class="badge badge-<?= $hrac['pozice'] ?>"><?= htmlspecialchars($hrac['pozice']) ?></span></span>
            </div>
            <div class="detail-item">
                <span class="label">Tým:</span>
                <span class="value"><?= htmlspecialchars($hrac['tym_nazev'] ?? 'Nepřiřazen') ?> <?= $hrac['vekova_kategorie'] ? '(' . $hrac['vekova_kategorie'] . ')' : '' ?></span>
            </div>
            <div class="detail-item">
                <span class="label">Telefon (rodič):</span>
                <span class="value"><?= htmlspecialchars($hrac['telefon_rodice'] ?? '—') ?></span>
            </div>
            <div class="detail-item">
                <span class="label">E-mail (rodič):</span>
                <span class="value"><?= htmlspecialchars($hrac['email_rodice'] ?? '—') ?></span>
            </div>
            <div class="detail-item">
                <span class="label">Stav:</span>
                <span class="value"><?= $hrac['aktivni'] ? '✅ Aktivní' : '❌ Neaktivní' ?></span>
            </div>
        </div>
    </div>

    <?php if (!empty($spolaci)): ?>
    <h3>Spoluhráči v týmu</h3>
    <table class="table-sm">
        <thead>
            <tr><th>Jméno</th><th>Pozice</th><th></th></tr>
        </thead>
        <tbody>
            <?php foreach ($spolaci as $s): ?>
                <tr>
                    <td><?= htmlspecialchars($s['prijmeni'] . ' ' . $s['jmeno']) ?></td>
                    <td><span class="badge badge-<?= $s['pozice'] ?>"><?= htmlspecialchars($s['pozice']) ?></span></td>
                    <td><a href="detail.php?id=<?= $s['id'] ?>" class="btn btn-sm">Detail</a></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php endif; ?>

    <?php if (!empty($zapasy)): ?>
    <h3>Poslední zápasy týmu</h3>
    <table class="table-sm">
        <thead>
            <tr><th>Datum</th><th>Soupeř</th><th>Typ</th><th>Výsledek</th></tr>
        </thead>
        <tbody>
            <?php foreach ($zapasy as $z): ?>
                <tr>
                    <td><?= date('d. m. Y', strtotime($z['datum'])) ?></td>
                    <td><?= htmlspecialchars($z['souper']) ?></td>
                    <td><?= $z['typ'] === 'domácí' ? '🏠' : '✈️' ?> <?= htmlspecialchars($z['typ']) ?></td>
                    <td>
                        <?php if ($z['skore_domaci'] !== null): ?>
                            <strong><?= $z['skore_domaci'] ?>:<?= $z['skore_hoste'] ?></strong>
                        <?php else: ?>
                            <em>—</em>
                        <?php endif; ?>
                    </td>
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
