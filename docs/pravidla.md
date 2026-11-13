# FK Náchod – Pravidla aplikační logiky

Aplikace hlídá následující pravidla nad rámec běžného CRUD (vytvoření, čtení, aktualizace, smazání):

## 1. Kontrola věku hráče vůči kategorii týmu

Při přidávání hráče do týmu aplikace kontroluje, zda rok narození hráče spadá do povoleného rozmezí ročníků pro danou věkovou kategorii. Například hráč narozený v roce 2013 může hrát za tým U13 (ročníky 2013–2014), ale ne za tým U11 (ročníky 2015–2016).

**Kde:** `pridat.php` – serverová validace před uložením do databáze.

## 2. Skóre zápasu lze zadat pouze u odehraných zápasů

Výsledné skóre zápasu lze zadat pouze u zápasů, jejichž datum je rovno nebo starší než dnešní datum. U budoucích zápasů se formulář pro zadání skóre nezobrazuje.

**Kde:** `zapasy.php` – kontrola data zápasu při zpracování POST požadavku i při renderování UI.

## 3. Validace data narození

Datum narození hráče nesmí být v budoucnosti. Aplikace kontroluje, že zadané datum je menší nebo rovno aktuálnímu datu.

**Kde:** `pridat.php` – serverová validace.

## 4. Validace formátu kontaktních údajů

- **E-mail rodiče** – musí odpovídat platnému formátu e-mailové adresy (PHP `filter_var` s `FILTER_VALIDATE_EMAIL`).
- **Telefon rodiče** – musí obsahovat 9–15 číslic (případně s mezerami a předvolbou +).

**Kde:** `pridat.php` – serverová validace.

## 5. Automatické rozlišení stavu zápasu

Aplikace automaticky rozděluje zápasy na „odehrané" a „nadcházející" podle aktuálního data a přítomnosti skóre. Na základě toho:
- Počítá statistiky (výhry, remízy, prohry)
- Správně určuje výsledek podle typu zápasu (domácí/venkovní)

**Kde:** `zapasy.php` – logika při načítání a zobrazování dat.

## 6. Povinnost vyplnit klíčové údaje

Formulář pro přidání hráče vyžaduje vyplnění povinných polí (jméno, příjmení, datum narození, pozice, tým). Bez nich nelze záznam uložit. Chybějící pole jsou zvýrazněna chybovou zprávou.

**Kde:** `pridat.php` – serverová validace s výpisem všech chyb najednou.
