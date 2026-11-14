<?php
// Připojení k databázi
require_once __DIR__ . '/db.php';

// Pole pro ukládání chybových hlášek z validace
$chyby = [];

// Výchozí hodnoty formuláře (aby formulář po chybě zůstal vyplněný)
$data = [
    'jmeno'          => '',
    'prijmeni'       => '',
    'datum_narozeni' => '',
    'pozice'         => '',
    'tym_id'         => 0,
    'telefon_rodice' => '',
    'email_rodice'   => '',
];

// Načtení všech aktivních týmů pro select v html formuláři
$tymy_stmt = $pdo->query("
    SELECT id, nazev, vekova_kategorie, rok_narozeni_od, rok_narozeni_do 
    FROM tymy 
    WHERE aktivni = 1 
    ORDER BY vekova_kategorie ASC
");
$tymy = $tymy_stmt->fetchAll();

// Zpracování formuláře po odeslání metodou POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Načtení a oříznutí prázdných znaků zadaných uživatelem
    $data['jmeno']          = trim($_POST['jmeno'] ?? '');
    $data['prijmeni']       = trim($_POST['prijmeni'] ?? '');
    $data['datum_narozeni'] = trim($_POST['datum_narozeni'] ?? '');
    $data['pozice']         = trim($_POST['pozice'] ?? '');
    $data['tym_id']         = (int)($_POST['tym_id'] ?? 0);
    $data['telefon_rodice'] = trim($_POST['telefon_rodice'] ?? '');
    $data['email_rodice']   = trim($_POST['email_rodice'] ?? '');

    // 1. Kontrola povinných polí
    if ($data['jmeno'] === '') {
        $chyby[] = 'Vyplňte prosím jméno hráče.';
    }
    if ($data['prijmeni'] === '') {
        $chyby[] = 'Vyplňte prosím příjmení hráče.';
    }
    if ($data['datum_narozeni'] === '') {
        $chyby[] = 'Zadejte datum narození hráče.';
    }
    if ($data['pozice'] === '') {
        $chyby[] = 'Vyberte herní pozici hráče.';
    }
    if ($data['tym_id'] <= 0) {
        $chyby[] = 'Vyberte tým (věkovou kategorii), do které má být hráč zařazen.';
    }

    // 2. Kontrola povolených herních pozic
    $povolene_pozice = ['brankář', 'obránce', 'záložník', 'útočník'];
    if ($data['pozice'] !== '' && !in_array($data['pozice'], $povolene_pozice, true)) {
        $chyby[] = 'Zvolená herní pozice není platná.';
    }

    // 3. Kontrola správnosti data narození (nesmí být v budoucnosti a musí být platné datum)
    if ($data['datum_narozeni'] !== '') {
        $datum_obj = DateTime::createFromFormat('Y-m-d', $data['datum_narozeni']);
        $dnes_obj = new DateTime();
        if (!$datum_obj || $datum_obj->format('Y-m-d') !== $data['datum_narozeni']) {
            $chyby[] = 'Datum narození má neplatný formát.';
        } elseif ($datum_obj > $dnes_obj) {
            $chyby[] = 'Datum narození nemůže být v budoucnosti.';
        }
    }

    // 4. Formátová kontrola kontaktů (pokud jsou zadané)
    if ($data['email_rodice'] !== '' && !filter_var($data['email_rodice'], FILTER_VALIDATE_EMAIL)) {
        $chyby[] = 'Zadaná e-mailová adresa zákonného zástupce nemá správný formát.';
    }
    if ($data['telefon_rodice'] !== '' && !preg_match('/^[0-9+\s]{9,16}$/', $data['telefon_rodice'])) {
        $chyby[] = 'Telefonní číslo musí obsahovat pouze číslice (případně mezinárodní předvolbu +).';
    }

    // 5. Hlavní aplikační logika: kontrola ročníku narození vůči pravidlům kategorie dle FAČR
    if (empty($chyby) && $data['tym_id'] > 0 && $data['datum_narozeni'] !== '') {
        $rok_narozeni = (int)date('Y', strtotime($data['datum_narozeni']));
        
        // Vyhledání limitů pro zvolený tým
        $zvoleny_tym = null;
        foreach ($tymy as $t) {
            if ($t['id'] === $data['tym_id']) {
                $zvoleny_tym = $t;
                break;
            }
        }

        // Ověření ročníku narození proti povolenému intervalu v tabulce tymy
        if ($zvoleny_tym) {
            if ($rok_narozeni < $zvoleny_tym['rok_narozeni_od'] || $rok_narozeni > $zvoleny_tym['rok_narozeni_do']) {
                $chyby[] = "Pravidlo věkové kategorie: Hráč narozený v roce $rok_narozeni nemůže být zařazen do týmu {$zvoleny_tym['nazev']}. "
                         . "Tato kategorie ({$zvoleny_tym['vekova_kategorie']}) je určena pouze pro ročníky narození {$zvoleny_tym['rok_narozeni_od']} až {$zvoleny_tym['rok_narozeni_do']}.";
            }
        }
    }

    // 6. Pokud nenastala žádná chyba, provedeme bezpečné uložení do databáze
    if (empty($chyby)) {
        $stmt_insert = $pdo->prepare("
            INSERT INTO hraci (jmeno, prijmeni, datum_narozeni, pozice, tym_id, telefon_rodice, email_rodice, aktivni)
            VALUES (?, ?, ?, ?, ?, ?, ?, 1)
        ");

        $stmt_insert->execute([
            $data['jmeno'],
            $data['prijmeni'],
            $data['datum_narozeni'],
            $data['pozice'],
            $data['tym_id'],
            $data['telefon_rodice'] ?: null,
            $data['email_rodice'] ?: null,
        ]);

        // Přesměrování zpět na seznam s potvrzující zprávou
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
    <title>FK Náchod - Přidat nového hráče</title>
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
            <a href="index.php">Seznam hráčů</a>
            <a href="pridat.php" class="aktivni">+ Přidat nového hráče</a>
        </nav>
    </div>
</header>

<main class="obal hlavni-obsah">

    <div class="zpet-odkaz">
        <a href="index.php" class="tlacitko tlacitko-zpet">&larr; Zpět na seznam hráčů</a>
    </div>

    <h2>Registrace nového hráče</h2>
    <p class="podnadpis-text">Vyplňte osobní údaje hráče a vyberte odpovídající věkovou kategorii.</p>

    <!-- Zobrazení seznamu chyb při neúspěšné validaci -->
    <?php if (!empty($chyby)): ?>
        <div class="upozorneni upozorneni-chyba">
            <strong>Při ukládání došlo k chybám:</strong>
            <ul>
                <?php foreach ($chyby as $ch): ?>
                    <li><?= htmlspecialchars($ch) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <!-- Formulář pro vložení hráče -->
    <div class="formular-karta">
        <form method="post" action="pridat.php" novalidate>
            
            <div class="form-radek">
                <div class="form-skupina">
                    <label for="jmeno">Jméno hráče: <span class="hvezdicka">*</span></label>
                    <input type="text" id="jmeno" name="jmeno" value="<?= htmlspecialchars($data['jmeno']) ?>" required placeholder="např. Jan">
                </div>

                <div class="form-skupina">
                    <label for="prijmeni">Příjmení hráče: <span class="hvezdicka">*</span></label>
                    <input type="text" id="prijmeni" name="prijmeni" value="<?= htmlspecialchars($data['prijmeni']) ?>" required placeholder="např. Novák">
                </div>
            </div>

            <div class="form-radek">
                <div class="form-skupina">
                    <label for="datum_narozeni">Datum narození: <span class="hvezdicka">*</span></label>
                    <input type="date" id="datum_narozeni" name="datum_narozeni" value="<?= htmlspecialchars($data['datum_narozeni']) ?>" required max="<?= date('Y-m-d') ?>">
                    <small class="napoveda">Podle ročníku systém zkontroluje zařazení do týmu.</small>
                </div>

                <div class="form-skupina">
                    <label for="pozice">Herní pozice: <span class="hvezdicka">*</span></label>
                    <select id="pozice" name="pozice" required>
                        <option value="">-- Vyberte herní post --</option>
                        <option value="brankář" <?= $data['pozice'] === 'brankář' ? 'selected' : '' ?>>Brankář</option>
                        <option value="obránce" <?= $data['pozice'] === 'obránce' ? 'selected' : '' ?>>Obránce</option>
                        <option value="záložník" <?= $data['pozice'] === 'záložník' ? 'selected' : '' ?>>Záložník</option>
                        <option value="útočník" <?= $data['pozice'] === 'útočník' ? 'selected' : '' ?>>Útočník</option>
                    </select>
                </div>
            </div>

            <div class="form-skupina">
                <label for="tym_id">Tým (kategorie): <span class="hvezdicka">*</span></label>
                <select id="tym_id" name="tym_id" required>
                    <option value="0">-- Vyberte tým --</option>
                    <?php foreach ($tymy as $t): ?>
                        <option value="<?= $t['id'] ?>" <?= $data['tym_id'] == $t['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($t['nazev']) ?> (<?= htmlspecialchars($t['vekova_kategorie']) ?>, ročníky <?= $t['rok_narozeni_od'] ?> - <?= $t['rok_narozeni_do'] ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-radek">
                <div class="form-skupina">
                    <label for="telefon_rodice">Telefon na zákonného zástupce:</label>
                    <input type="tel" id="telefon_rodice" name="telefon_rodice" value="<?= htmlspecialchars($data['telefon_rodice']) ?>" placeholder="např. 777 123 456">
                </div>

                <div class="form-skupina">
                    <label for="email_rodice">E-mail na zákonného zástupce:</label>
                    <input type="email" id="email_rodice" name="email_rodice" value="<?= htmlspecialchars($data['email_rodice']) ?>" placeholder="např. rodic@seznam.cz">
                </div>
            </div>

            <div class="form-tlacitka">
                <button type="submit" class="tlacitko tlacitko-hlavni">Uložit hráče do databáze</button>
                <a href="index.php" class="tlacitko tlacitko-storno">Zrušit</a>
            </div>

        </form>
    </div>

</main>

<footer class="paticka">
    <div class="obal">
        <p>Maturitní projekt: Informační systém pro mládežnický fotbalový klub | Autor: Tadeáš | Školní rok 2026/2027</p>
    </div>
</footer>

</body>
</html>
