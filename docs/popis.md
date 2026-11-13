# FK Náchod – Popis aplikace

## Jaký problém aplikace řeší

Webová aplikace pro mládežnický fotbalový klub FK Náchod řeší problém **nepřehledné evidence hráčů, týmů, zápasů a tréninků**. V současnosti se tyto informace vedou v tabulkách, e-mailech nebo papírově, což vede k chybám, neaktuálním údajům a obtížné komunikaci mezi trenéry a rodiči.

Aplikace centralizuje všechny klíčové informace na jednom místě a zajišťuje, že jsou vždy aktuální a snadno dostupné.

## Pro koho je určena

- **Trenéři** – spravují hráče, plánují tréninky, zadávají výsledky zápasů
- **Vedení klubu** – přehled o všech týmech a jejich činnosti
- **Rodiče hráčů** – mohou sledovat rozvrh tréninků a výsledky zápasů

## Hlavní funkce

1. **Evidence hráčů** – přehled, detail, přidávání nových hráčů s kontrolou věku vůči kategorii týmu
2. **Správa týmů** – věkové kategorie (U11, U13, U15, U17) s definovanými ročníky narození
3. **Evidence zápasů** – plánování zápasů, zadávání výsledků (pouze u proběhlých), statistiky výher/proher/remíz
4. **Rozvrh tréninků** – plánování tréninků s časem, místem a popisem náplně
5. **Přiřazení trenérů** – trenéři s licencemi přiřazení k týmům (hlavní trenér / asistent)

## Technologie

- **Backend:** PHP 8 (PDO, prepared statements)
- **Databáze:** MySQL / MariaDB (utf8mb4)
- **Frontend:** HTML5, CSS3 (responsive design)
- **Vývojové prostředí:** XAMPP
- **Verzování:** Git + GitHub
