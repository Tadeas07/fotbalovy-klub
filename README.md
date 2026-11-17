# Informační systém pro mládež FK Náchod

Maturitní projekt – 1. etapa (školní rok 2026/2027)  
**Autor:** Tadeáš Šmehlík  
**Škola:** SPŠ ELIT Dobruška  
**Vedoucí práce:** Ing. Mikuláš Slavík (`mslavik-spselit`)  

## O projektu
Webová aplikace pro správu mládežnických kategorií fotbalového klubu FK Náchod (U11 až U17). Systém slouží pro evidenci hráčů, týmů, trenérů a kontaktů na zákonné zástupce.

V rámci 1. etapy (k 13. listopadu 2026) je připraveno:
- Návrh databáze MySQL (6 tabulek) a skript s testovacími daty (`sql/database.sql`)
- Přehled hráčů s dynamickým filtrováním podle kategorií (`index.php`)
- Detail hráče s výpočtem věku a výpisem spoluhráčů (`detail.php`)
- Formulář pro registraci nového hráče (`pridat.php`) s aplikační logikou:
  - kontrola ročníku narození vůči pravidlům věkové kategorie dle FAČR
  - validace formátu e-mailu a telefonu
  - kontrola, aby datum narození nebylo v budoucnosti
- Dokumentace a podklady ve složce `docs/` (popis projektu, pravidla logiky, ER diagram, wireframy)

## Požadavky a spuštění
- PHP 8.x
- MySQL / MariaDB (např. přes XAMPP)
- Webový prohlížeč

Postup:
1. Nakopírovat složku projektu do `htdocs/fotbalovy-klub`
2. V phpMyAdmin vytvořit databázi a naimportovat soubor `sql/database.sql`
3. V prohlížeči otevřít `http://localhost/fotbalovy-klub/`
