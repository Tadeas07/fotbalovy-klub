# Pravidla aplikační logiky

Tento dokument shrnuje specifická pravidla a kontroly, které aplikace provádí nad rámec základních operací pro čtení a zápis dat (CRUD).

---

## 1. Kontrola věku hráče vůči pravidlům kategorie (Klíčová byznys logika)
- **Co hlídá:** Každý tým v databázi má přesně vymezené povolené rozpětí ročníků narození (`rok_narozeni_od` a `rok_narozeni_do`) podle platných pravidel mládežnického fotbalu FAČR:
  - U11: ročníky narození 2015 až 2016
  - U13: ročníky narození 2013 až 2014
  - U15: ročníky narození 2011 až 2012
  - U17: ročníky narození 2009 až 2010
- **Implementace:** Při odeslání formuláře pro registraci hráče skript zkontroluje rok narození zadaného data vůči limitům zvoleného týmu. Pokud například uživatel zkusí zařadit hráče narozeného v roce 2013 do týmu U11, systém uložení odmítne a vypíše srozumitelné chybové hlášení s vysvětlením, do jakých ročníků daný tým patří.
- **Kde se nachází v kódu:** soubor `pridat.php`, řádky 66–84.

---

## 2. Validace kalendářního data narození
- **Co hlídá:** Datum narození nesmí být v budoucnosti a musí odpovídat reálnému kalendářnímu dni.
- **Implementace:** Využívá se objekt `DateTime::createFromFormat('Y-m-d', ...)`. Pokud zadané datum přesahuje aktuální systémový čas, záznam se neuloží.
- **Kde se nachází v kódu:** soubor `pridat.php`, řádky 48–56.

---

## 3. Formátová kontrola kontaktních údajů
- **Co hlídá:** Zajišťuje, aby telefonní číslo a e-mail na rodiče měly smysluplnou podobu, aby bylo možné rodiče v případě potřeby kontaktovat.
- **Implementace:** E-mail se ověřuje vestavěnou funkcí `filter_var($email, FILTER_VALIDATE_EMAIL)` a telefon regulárním výrazem `/^[0-9+\s]{9,16}$/`.
- **Kde se nachází v kódu:** soubor `pridat.php`, řádky 58–64.

---

## 4. Ochrana proti neexistujícímu záznamu a neplatným ID v URL
- **Co hlídá:** Pokud se uživatel pokusí otevřít detail hráče přes podvržené nebo záporné ID (např. `detail.php?id=abc` nebo `detail.php?id=99999`), aplikace nesmí spadnout chybou PHP ani zobrazit prázdný rozbitý layout.
- **Implementace:** Vstup se přetypuje na celé číslo `(int)$_GET['id']` a v případě neexistence řádku v databázi dojde k bezpečnému přesměrování zpět na `index.php`.
- **Kde se nachází v kódu:** soubor `detail.php`, řádky 8–24.

---
