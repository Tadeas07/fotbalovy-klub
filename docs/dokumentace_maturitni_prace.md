# ODBORNÁ DOKUMENTACE MATURITNÍHO PROJEKTU

**Název práce:** Webová aplikace pro správu mládežnického fotbalového klubu FK Náchod  
**Obor vzdělání:** Informační technologie  
**Škola:** Střední průmyslová škola elektrotechniky a informačních technologií Dobruška (SPŠ ELIT Dobruška)  
**Autor:** Tadeáš  
**Vedoucí práce:** Ing. Mikuláš Slavík (účet: `mslavik-spselit`)  
**Školní rok:** 2026/2027  

---

## Anotace
Cílem tohoto maturitního projektu je návrh, realizace a dokumentace komplexní webové aplikace určené pro evidenci a operativní správu mládežnického fotbalového klubu FK Náchod. Aplikace centralizuje správu věkových kategorií (týmů), trenérského personálu, mládežnických hráčů, tréninkových jednotek a mistrovských zápasů. Systém je postaven na relační databázi MySQL/MariaDB s důrazem na referenční integritu a normalizaci. Aplikační backend v PHP 8 využívá objektové rozhraní PDO s parametrizovanými dotazy, čímž eliminuje bezpečnostní riziko SQL Injection. Frontend je navržen s důrazem na přehlednost, responzivitu a sémantiku za využití moderního CSS3 a HTML5. Klíčovou předností aplikace je implementace specifické aplikační logiky chránící systém před nekonzistentními daty, zejména automatická validace věku hráčů vůči předpisům mládežnických kategorií FAČR a dynamické vyhodnocování odehraných utkání.

**Klíčová slova:** Webová aplikace, PHP 8, MySQL, MariaDB, PDO, SQL Injection, aplikační logika, mládežnický fotbal, FK Náchod, relační databáze, CRUD, responzivní design, Git.

---

# KOMPLETNÍ OSNOVA MATURITNÍ PRÁCE
*(Předepsaný rozsah: min. 20 normostran odborného textu, 1/3 teorie, 2/3 praxe)*

- **Úvod**
  - Motivace a kontext vzniku práce
  - Cíle a očekávané přínosy projektu
- **I. TEORETICKÁ ČÁST (cca 7–8 normostran)**
  - 1. Architektura webových aplikací
    - 1.1 Model klient-server
    - 1.2 Protokol HTTP/HTTPS a bezstavovost webu
    - 1.3 Třívrstvá architektura informačních systémů
  - 2. Databázové technologie a relační model
    - 2.1 Relační databázové systémy (RDBMS) – MySQL a MariaDB
    - 2.2 Relační datový model, primární a cizí klíče, kardinalita
    - 2.3 Databázová normalizace (1NF, 2NF, 3NF) a integritní omezení
    - 2.4 Transakční zpracování a vlastnosti ACID
    - 2.5 Jazyk SQL a pokročilé konstrukce (JOIN, GROUP BY, agregační funkce)
  - 3. Backendové technologie a jazyk PHP
    - 3.1 Vývoj a postavení jazyka PHP v moderním webu
    - 3.2 Novinky a typový systém v PHP 8
    - 3.3 Rozhraní PDO (PHP Data Objects) a výhody oproti MySQLi
    - 3.4 Zpracování HTTP požadavků (GET, POST) a řízení relací
  - 4. Bezpečnost webových aplikací
    - 4.1 Desatero OWASP Top 10
    - 4.2 SQL Injection a obrana pomocí prepared statements
    - 4.3 Cross-Site Scripting (XSS) a kontextové escapování výstupu
    - 4.4 Validace a sanitizace vstupních dat na straně serveru
  - 5. Frontendové technologie a uživatelské rozhraní
    - 5.1 Sémantický HTML5 a přístupnost
    - 5.2 Kaskádové styly CSS3, Flexbox, CSS Grid a Media Queries
    - 5.3 Ergonomie uživatelského rozhraní (UI/UX) a wireframing
  - 6. Vývojové nástroje a verzovací systémy
    - 6.1 Verzovací systém Git a platforma GitHub
    - 6.2 Lokální vývojové prostředí XAMPP
- **II. PRAKTICKÁ ČÁST (cca 13–15 normostran)**
  - 7. Analýza požadavků a specifikace systému FK Náchod
    - 7.1 Analýza stávajícího stavu v klubu FK Náchod
    - 7.2 Funkční a nefunkční požadavky
    - 7.3 Uživatelské role a diagram případů užití (Use Case)
  - 8. Návrh informačního systému
    - 8.1 Informační architektura a mapa stránek (Sitemap)
    - 8.2 Konceptuální a logický návrh databáze (ER diagram)
    - 8.3 Specifikace databázových tabulek, atributů a relací
    - 8.4 Návrh uživatelského rozhraní (Wireframy klíčových obrazovek)
  - 9. Implementace databázové vrstvy
    - 9.1 Inicializační SQL skript a tvorba struktury (CREATE TABLE)
    - 9.2 Vytvoření testovací datové sady odpovídající reálným kategoriím
    - 9.3 Relační integrita a kaskádové operace (CASCADE, SET NULL)
  - 10. Implementace backendu a aplikační logiky
    - 10.1 Bezpečné připojení k databázi přes PDO (`db.php`)
    - 10.2 Realizace CRUD operací
    - 10.3 Implementace pokročilé aplikační logiky:
      - 10.3.1 Kontrola věkových kategorií hráčů dle ročníku narození
      - 10.3.2 Validace formátů telefonních čísel a e-mailů zákonných zástupců
      - 10.3.3 Dvoustavový cyklus zápasu a ochrana před zadáním skóre v budoucnosti
      - 10.3.4 Algoritmus výpočtu klubových statistik (výhry/remízy/prohry)
  - 11. Implementace uživatelského rozhraní (Frontend)
    - 11.1 Responzivní layout a modulární CSS architektura
    - 11.2 Přehledové obrazovky s dynamickým filtrováním
    - 11.3 Detailní vizitka hráče s relací na spoluhráče a zápasy
    - 11.4 Zpětná vazba pro uživatele (flash zprávy, validační hlášení)
  - 12. Testování, verifikace a bezpečnostní audit
    - 12.1 Metodika testování a testovací scénáře
    - 12.2 Testování hraničních hodnot (boundary testing)
    - 12.3 Ověření odolnosti vůči SQL Injection a XSS útokům
  - 13. Uživatelská příručka a nasazení
    - 13.1 Požadavky na běhové prostředí
    - 13.2 Postup instalace a inicializace databáze
- **Závěr**
  - Zhodnocení splnění cílů práce
  - Možnosti budoucího rozvoje aplikace (docházka, platební modul členských příspěvků)
- **Seznam použité literatury a informačních zdrojů**
- **Seznam zkratek, tabulek a obrázků**
- **Přílohy**
  - Příloha A: Kompletní DDL skript databáze (`sql/database.sql`)
  - Příloha B: Wireframy obrazovek a mapa stránek

---
