# Popis projektu – Informační systém pro mládež FK Náchod

## 1. Jaký problém aplikace řeší
V mládežnických kategoriích fotbalového klubu FK Náchod (od mladších přípravek U11 až po starší dorost U17) působí desítky hráčů a několik trenérů. V současné době se většina agendy kolem hráčů řeší nejednotně – trenéři mají kontakty na rodiče ve svých telefonech, soupisky se vedou v různých excelovských tabulkách nebo na papíře a při přechodu hráčů mezi jednotlivými ročníky dochází k chybám a nejasnostem.

Cílem této webové aplikace je vytvořit jednotný systém, který soustředí veškerou evidenci mládeže na jedno místo. Aplikace zamezí chybám při zařazování dětí do špatných věkových kategorií, zjednoduší dohledání kontaktů na zákonné zástupce v případě zranění či omluvenky a do budoucna umožní přehledné plánování tréninků a sledování výsledků zápasů.

## 2. Pro koho je aplikace určená
Systém je navržen primárně pro:
- **Trenéry mládeže:** potřebují mít okamžitý přístup k aktuálnímu seznamu svých svěřenců, jejich věku a kontaktům na rodiče.
- **Vedení fotbalového klubu a šéftrenéra mládeže:** získávají celkový přehled o počtech aktivních hráčů v jednotlivých kategoriích (U11, U13, U15, U17).
- **Zákonné zástupce (rodiče):** v další fázi projektu budou mít možnost nahlížet na rozpis tréninkových jednotek a mistrovských zápasů.

## 3. Funkce aplikace

### Současný stav (k 13. listopadu):
- **Přehled hráčů:** tabulkový výpis všech aktivních fotbalistů načítaný z relační databáze MySQL, s možností okamžitého filtrování podle věkové kategorie týmu a počítadlem zobrazených záznamů.
- **Detail hráče:** samostatná profilová stránka hráče, kde se dynamicky dopočítává přesný věk z data narození, zobrazují se kontakty na rodiče a automaticky se vypisují jeho spoluhráči ze stejného týmu.
- **Registrace nového hráče:** formulář pro přidání nového člena s přísnou kontrolou na straně serveru a zapracovanou aplikační logikou hlídající ročníky narození.

### Plánované funkce pro další etapu:
- Evidence mistrovských a přátelských zápasů (rozdělení na odehrané a plánované, zadávání výsledků, statistiky).
- Plánování tréninků s časem a popisem náplně.
- Docházkový systém hráčů na tréninkových jednotkách.

## 4. Použité technologie
- **Backend:** PHP 8 s využitím PDO (připojení s prepared statements pro ochranu proti SQL Injection).
