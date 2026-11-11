<?php
// Připojení k databázi
require_once __DIR__ . '/db.php';

// Získání ID hráče z URL adresy (?id=...)
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Pokud ID v URL chybí nebo je neplatné, přesměrujeme na hlavní stránku
if ($id <= 0) {
    header('Location: index.php');
    exit;
}

// Načtení kompletních údajů o hráči včetně jeho týmu
$stmt = $pdo->prepare("
    SELECT h.*, t.nazev AS tym_nazev, t.vekova_kategorie, t.rok_narozeni_od, t.rok_narozeni_do
    FROM hraci h
    LEFT JOIN tymy t ON h.tym_id = t.id
    WHERE h.id = ?
");
$stmt->execute([$id]);
$hrac = $stmt->fetch();

// Pokud hráč s daným ID neexistuje, vrátíme se na seznam
if (!$hrac) {
    header('Location: index.php');
    exit;
}

// Dynamický výpočet aktuálního věku hráče z data narození přes DateTime
$narozeni = new DateTime($hrac['datum_narozeni']);
$dnes = new DateTime();
$vek = $dnes->diff($narozeni)->y;

// Načtení spoluhráčů ze stejného týmu (kromě aktuálně zobrazeného hráče)
$spoluhraci = [];
if ($hrac['tym_id']) {
    $stmt_tym = $pdo->prepare("
        SELECT id, jmeno, prijmeni, pozice, datum_narozeni
        FROM hraci
        WHERE tym_id = ? AND id != ? AND aktivni = 1
        ORDER BY prijmeni ASC
    ");
    $stmt_tym->execute([$hrac['tym_id'], $id]);
    $spoluhraci = $stmt_tym->fetchAll();
}
?>
<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail hráče - <?= htmlspecialchars($hrac['prijmeni'] . ' ' . $hrac['jmeno']) ?></title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<!-- Hlavička webu -->
<header class="hlavicka">
    <div class="obal">
        <div class="logo-nazev">
            <h1>FK Náchod - Mládež</h1>
            <span class="podtitul">Informační systém pro správu mládežnických kategorií</span>
        </div>
        <nav class="navigace">
            <a href="index.php">Seznam hráčů</a>
            <a href="pridat.php">+ Přidat nového hráče</a>
        </nav>
    </div>
</header>

<main class="obal hlavni-obsah">

    <!-- Tlačítko pro návrat na přehled -->
    <div class="zpet-odkaz">
        <a href="index.php" class="tlacitko tlacitko-zpet">&larr; Zpět na seznam hráčů</a>
    </div>

    <!-- Karta s podrobnými informacemi o vybraném hráči -->
    <div class="karta-detail">
        <div class="karta-hlavicka">
            <h2><?= htmlspecialchars($hrac['prijmeni'] . ' ' . $hrac['jmeno']) ?></h2>
            <span class="stitek post-<?= htmlspecialchars($hrac['pozice']) ?>">
                <?= htmlspecialchars($hrac['pozice']) ?>
            </span>
        </div>

        <div class="polozky-mrizka">
            <div class="polozka">
                <span class="popisek">Datum narození:</span>
                <span class="hodnota"><?= date('d. m. Y', strtotime($hrac['datum_narozeni'])) ?> (věk: <?= $vek ?> let)</span>
            </div>

            <div class="polozka">
                <span class="popisek">Přiřazený tým:</span>
                <span class="hodnota">
                    <?= htmlspecialchars($hrac['tym_nazev'] ?? 'Zatím nepřiřazen') ?>
                    <?php if ($hrac['vekova_kategorie']): ?>
                        <strong>(<?= htmlspecialchars($hrac['vekova_kategorie']) ?>)</strong>
                    <?php endif; ?>
                </span>
            </div>

            <div class="polozka">
                <span class="popisek">Telefon na zákonného zástupce:</span>
                <span class="hodnota"><?= htmlspecialchars($hrac['telefon_rodice'] ?: 'Neuvedeno') ?></span>
            </div>

            <div class="polozka">
                <span class="popisek">E-mail na zákonného zástupce:</span>
                <span class="hodnota">
                    <?php if ($hrac['email_rodice']): ?>
                        <a href="mailto:<?= htmlspecialchars($hrac['email_rodice']) ?>"><?= htmlspecialchars($hrac['email_rodice']) ?></a>
                    <?php else: ?>
                        Neuvedeno
                    <?php endif; ?>
                </span>
            </div>

            <div class="polozka">
                <span class="popisek">Stav registrace:</span>
                <span class="hodnota"><?= $hrac['aktivni'] ? 'Aktivní člen klubu' : 'Přerušená činnost' ?></span>
            </div>

            <div class="polozka">
                <span class="popisek">Datum registrace:</span>
                <span class="hodnota"><?= date('d. m. Y H:i', strtotime($hrac['vytvoreno'])) ?></span>
            </div>
        </div>
    </div>

    <!-- Seznam dalších hráčů z téže kategorie -->
    <div class="sekce-spoluhraci">
        <h3>Spoluhráči v kategorii <?= htmlspecialchars($hrac['vekova_kategorie'] ?? '') ?></h3>
        
        <?php if (empty($spoluhraci)): ?>
            <p class="prazdno">V tomto týmu zatím nejsou evidováni žádní další hráči.</p>
        <?php else: ?>
            <div class="tabulka-obal">
                <table class="tabulka tabulka-mala">
                    <thead>
                        <tr>
                            <th>Příjmení a jméno</th>
                            <th>Herní pozice</th>
                            <th>Datum narození</th>
                            <th style="width: 80px;">Profil</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($spoluhraci as $s): ?>
                            <tr>
                                <td><?= htmlspecialchars($s['prijmeni'] . ' ' . $s['jmeno']) ?></td>
                                <td>
                                    <span class="stitek post-<?= htmlspecialchars($s['pozice']) ?>">
                                        <?= htmlspecialchars($s['pozice']) ?>
                                    </span>
                                </td>
                                <td><?= date('d. m. Y', strtotime($s['datum_narozeni'])) ?></td>
                                <td>
                                    <a href="detail.php?id=<?= $s['id'] ?>" class="tlacitko tlacitko-male">Zobrazit</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>

</main>

<footer class="paticka">
    <div class="obal">
        <p>Maturitní projekt: Informační systém pro mládežnický fotbalový klub | Autor: Tadeáš | Školní rok 2026/2027</p>
    </div>
</footer>

</body>
</html>
