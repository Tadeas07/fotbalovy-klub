# Informační systém pro mládež FK Náchod

Školní maturitní projekt – SPŠE Litomyšl  
Autor: Tadeáš  
Vedoucí práce: Ing. Mikuláš Slavík  
Školní rok: 2026/2027  

---

## O projektu

Tato webová aplikace slouží k evidenci a správě mládežnických fotbalových týmů klubu **FK Náchod** (kategorie U11, U13, U15 a U17). Projekt řeší přechod od nepřehledných papírových soupisek a excelovských tabulek k modernímu centralizovanému systému.

### Aktuální stav k 13. listopadu:
Aplikace je ve stavu **rozpracované verze** podle požadavků zadání:
- Funkční načítání a filtrování seznamu hráčů z databáze (`index.php`)
- Detail vybraného hráče s výpočtem věku a výpisem spoluhráčů (`detail.php`)
- Funkční formulář pro přidání nového hráče se serverovou validací a aplikační logikou hlídající ročník narození (`pridat.php`)
- Relační databáze o 6 tabulkách (`sql/database.sql`)
- Wireframy a osnova dokumentace v adresáři `docs/`

---

## Požadavky na prostředí

- Webový server Apache (např. v balíku XAMPP)
- PHP verze 8.0 nebo novější (využívá PDO)
- Databázový server MySQL / MariaDB
- Webový prohlížeč (Chrome, Firefox, Edge)

---

## Postup instalace a zprovoznění

1. **Umístění projektu:**
   Zkopírujte složku `fotbalovy-klub` do kořenového adresáře webového serveru (např. `C:\xampp\htdocs\fotbalovy-klub` nebo `D:\XAAMP\htdocs\fotbalovy-klub`).

2. **Spuštění XAMPP:**
   V ovládacím panelu XAMPP spusťte moduly **Apache** a **MySQL**.

3. **Import databáze:**
   - Otevřete v prohlížeči rozhraní phpMyAdmin (`http://localhost/phpmyadmin/`).
   - Přejděte na záložku **Importovat** a zvolte soubor `sql/database.sql` z projektu.
   - Skript automaticky vytvoří databázi `fk_nachod`, všech 6 tabulek a naplní je testovacími daty.

4. **Spuštění aplikace:**
   V prohlížeči zadejte adresu:
   `http://localhost/fotbalovy-klub/`

---

## Struktura souborů v projektu

```
fotbalovy-klub/
├── css/
│   └── style.css            # Vlastní kaskádové styly (responzivní layout)
├── docs/
│   ├── popis.md             # Jednostránkový popis projektu a funkcí
│   ├── pravidla.md          # Seznam pravidel aplikační logiky
│   ├── er_diagram.md        # Návrh databáze a ER diagram
│   ├── wireframy.md         # Textové návrhy obrazovek a sitemap
│   ├── wireframy.html       # Interaktivní grafický náhled wireframů
│   └── dokumentace_maturitni_prace.md # Kompletní osnova a rozepsaná teorie
├── sql/
│   └── database.sql         # SQL skript (CREATE TABLE + testovací data)
├── .gitignore               # Ignorované soubory pro Git
├── db.php                   # PDO připojení k MySQL databázi
├── detail.php               # Detailní karta hráče
├── index.php                # Přehled všech hráčů s filtrováním
├── pridat.php               # Formulář pro přidání hráče s kontrolou věku
└── README.md                # Tento soubor s návodem
```
