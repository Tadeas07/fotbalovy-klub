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
