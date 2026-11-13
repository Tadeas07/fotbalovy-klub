<?php
/**
 * FK Náchod – Přidání hráče
 * Formulář s aplikační logikou: kontrola věku vs. kategorie týmu.
 */
require_once __DIR__ . '/db.php';

$chyby = [];
$data = [
    'jmeno' => '',
    'prijmeni' => '',
    'datum_narozeni' => '',
    'pozice' => '',
    'tym_id' => '',
    'telefon_rodice' => '',
    'email_rodice' => '',
];

// Načtení týmů
$tymy = $pdo->query("SELECT id, nazev, vekova_kategorie, rok_narozeni_od, rok_narozeni_do FROM tymy WHERE aktivni = 1 ORDER BY vekova_kategorie")->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize vstupů
    $data['jmeno']          = trim($_POST['jmeno'] ?? '');
    $data['prijmeni']       = trim($_POST['prijmeni'] ?? '');
    $data['datum_narozeni'] = trim($_POST['datum_narozeni'] ?? '');
    $data['pozice']         = $_POST['pozice'] ?? '';
    $data['tym_id']         = (int)($_POST['tym_id'] ?? 0);
    $data['telefon_rodice'] = trim($_POST['telefon_rodice'] ?? '');
    $data['email_rodice']   = trim($_POST['email_rodice'] ?? '');

    // ===== VALIDACE =====

    // Povinná pole
    if ($data['jmeno'] === '')          $chyby[] = 'Jméno je povinné.';
    if ($data['prijmeni'] === '')       $chyby[] = 'Příjmení je povinné.';
    if ($data['datum_narozeni'] === '') $chyby[] = 'Datum narození je povinné.';
    if ($data['pozice'] === '')         $chyby[] = 'Pozice je povinná.';
    if ($data['tym_id'] <= 0)           $chyby[] = 'Musíte vybrat tým.';

    // Validace pozice
    $povolene_pozice = ['brankář', 'obránce', 'záložník', 'útočník'];
    if ($data['pozice'] !== '' && !in_array($data['pozice'], $povolene_pozice)) {
        $chyby[] = 'Neplatná pozice.';
    }

    // Validace data narození
    if ($data['datum_narozeni'] !== '') {
        $dn = DateTime::createFromFormat('Y-m-d', $data['datum_narozeni']);
        if (!$dn) {
            $chyby[] = 'Neplatný formát data narození.';
        } elseif ($dn > new DateTime()) {
            $chyby[] = 'Datum narození nemůže být v budoucnosti.';
        }
    }

    // Validace e-mailu
    if ($data['email_rodice'] !== '' && !filter_var($data['email_rodice'], FILTER_VALIDATE_EMAIL)) {
        $chyby[] = 'Neplatný formát e-mailu.';
    }

    // Validace telefonu (český formát)
    if ($data['telefon_rodice'] !== '' && !preg_match('/^[0-9+\s]{9,15}$/', $data['telefon_rodice'])) {
        $chyby[] = 'Neplatný formát telefonního čísla.';
    }

    // ===== APLIKAČNÍ LOGIKA: KONTROLA VĚKU VS. KATEGORIE =====
    if (empty($chyby) && $data['tym_id'] > 0 && $data['datum_narozeni'] !== '') {
        $rok_narozeni = (int)date('Y', strtotime($data['datum_narozeni']));

        // Najdeme vybraný tým
        $vybrany_tym = null;
        foreach ($tymy as $t) {
            if ($t['id'] == $data['tym_id']) {
                $vybrany_tym = $t;
                break;
            }
        }

        if ($vybrany_tym) {
            if ($rok_narozeni < $vybrany_tym['rok_narozeni_od'] || $rok_narozeni > $vybrany_tym['rok_narozeni_do']) {
                $chyby[] = "Hráč narozený v roce $rok_narozeni nemůže hrát za tým {$vybrany_tym['nazev']} "
                         . "(povolené ročníky: {$vybrany_tym['rok_narozeni_od']}–{$vybrany_tym['rok_narozeni_do']}).";
            }
        }
    }

    // ===== ULOŽENÍ =====
    if (empty($chyby)) {
        $stmt = $pdo->prepare("
            INSERT INTO hraci (jmeno, prijmeni, datum_narozeni, pozice, tym_id, telefon_rodice, email_rodice)
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt->execute([
            $data['jmeno'],
            $data['prijmeni'],
            $data['datum_narozeni'],
            $data['pozice'],
            $data['tym_id'],
            $data['telefon_rodice'] ?: null,
            $data['email_rodice'] ?: null,
        ]);

        header('Location: index.php?zprava=pridano');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FK Náchod – Přidat hráče</title>
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
            <a href="pridat.php" class="active">+ Přidat hráče</a>
        </nav>
    </div>
</header>

<main class="container">
    <a href="index.php" class="btn btn-back">&larr; Zpět na přehled</a>

    <h2>Přidat nového hráče</h2>

    <?php if (!empty($chyby)): ?>
        <div class="alert alert-error">
            <strong>Opravte prosím následující chyby:</strong>
            <ul>
                <?php foreach ($chyby as $ch): ?>
                    <li><?= htmlspecialchars($ch) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="post" class="form-pridat" novalidate>
        <div class="form-group">
            <label for="jmeno">Jméno *</label>
            <input type="text" id="jmeno" name="jmeno" value="<?= htmlspecialchars($data['jmeno']) ?>" required>
        </div>

        <div class="form-group">
            <label for="prijmeni">Příjmení *</label>
            <input type="text" id="prijmeni" name="prijmeni" value="<?= htmlspecialchars($data['prijmeni']) ?>" required>
        </div>

        <div class="form-group">
            <label for="datum_narozeni">Datum narození *</label>
            <input type="date" id="datum_narozeni" name="datum_narozeni" value="<?= htmlspecialchars($data['datum_narozeni']) ?>" required max="<?= date('Y-m-d') ?>">
        </div>

        <div class="form-group">
            <label for="pozice">Pozice *</label>
            <select id="pozice" name="pozice" required>
                <option value="">— Vyberte pozici —</option>
                <option value="brankář" <?= $data['pozice'] === 'brankář' ? 'selected' : '' ?>>Brankář</option>
                <option value="obránce" <?= $data['pozice'] === 'obránce' ? 'selected' : '' ?>>Obránce</option>
                <option value="záložník" <?= $data['pozice'] === 'záložník' ? 'selected' : '' ?>>Záložník</option>
                <option value="útočník" <?= $data['pozice'] === 'útočník' ? 'selected' : '' ?>>Útočník</option>
            </select>
        </div>

        <div class="form-group">
            <label for="tym_id">Tým *</label>
            <select id="tym_id" name="tym_id" required>
                <option value="0">— Vyberte tým —</option>
                <?php foreach ($tymy as $t): ?>
                    <option value="<?= $t['id'] ?>" <?= $data['tym_id'] == $t['id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($t['nazev']) ?> (ročníky <?= $t['rok_narozeni_od'] ?>–<?= $t['rok_narozeni_do'] ?>)
                    </option>
                <?php endforeach; ?>
            </select>
            <small class="form-help">⚠️ Věk hráče musí odpovídat věkové kategorii týmu.</small>
        </div>

        <div class="form-group">
            <label for="telefon_rodice">Telefon rodiče</label>
            <input type="tel" id="telefon_rodice" name="telefon_rodice" value="<?= htmlspecialchars($data['telefon_rodice']) ?>" placeholder="602123456">
        </div>

        <div class="form-group">
            <label for="email_rodice">E-mail rodiče</label>
            <input type="email" id="email_rodice" name="email_rodice" value="<?= htmlspecialchars($data['email_rodice']) ?>" placeholder="rodic@email.cz">
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">💾 Uložit hráče</button>
            <a href="index.php" class="btn btn-secondary">Zrušit</a>
        </div>
    </form>
</main>

<footer>
    <div class="container">
        <p>&copy; <?= date('Y') ?> FK Náchod – Mládežnický fotbalový klub | Školní projekt SPŠE Litomyšl</p>
    </div>
</footer>

</body>
</html>
