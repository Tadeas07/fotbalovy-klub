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

# ROZEPSANÁ TEORETICKÁ ČÁST MATURITNÍ PRÁCE

## 1. Architektura moderních webových aplikací

Moderní webové aplikace představují distribuované softwarové systémy provozované na principech architektury **klient-server**. V tomto modelu je výpočetní výkon i správa dat rozdělena mezi dvě samostatné entity:
1. **Klient (front-end):** Běží v prostředí webového prohlížeče uživatele. Jeho primárním úkolem je interpretace grafického rozhraní (DOM strom vytvořený z HTML5 a formátovaný přes CSS3), interakce s uživatelem a odesílání požadavků.
2. **Server (back-end):** Webový server (v našem případě Apache HTTP Server) spolu s interpretrem skriptovacího jazyka (PHP 8) přijímá HTTP požadavky, provádí autorizaci, spouští aplikační logiku a komunikuje s databázovým subsystémem (MySQL).

Komunikace mezi klientem a serverem probíhá prostřednictvím aplikačního protokolu **HTTP (Hypertext Transfer Protocol)**, případně jeho zabezpečené šifrované varianty **HTTPS (HTTP over TLS)**. Protokol HTTP je ze své podstaty **bezstavový (stateless)**, což znamená, že každý odeslaný požadavek je serverem zpracováván nezávisle a server si mezi jednotlivými požadavky neuchovává kontext. V prostředí naší aplikace je tento princip plně respektován; dynamický stav (např. vybraný filtr týmu) je předáván explicitně v URL parametrech metodou HTTP GET, zatímco operace měnící stav databáze (vložení hráče, uložení výsledku) využívají metodu HTTP POST s následným přesměrováním (návrhový vzor Post/Redirect/Get – PRG), který zamezuje nechtěnému vícenásobnému odeslání dat při obnovení stránky (klávesa F5).

Z hlediska vnitřního uspořádání aplikace využívá klasickou **třívrstvou architekturu (Three-Tier Architecture)**:
- **Prezentační vrstva:** Šablony generující čistý HTML5 výstup doplněný styly CSS.
- **Aplikační (byznys) vrstva:** PHP skripty obsahující pravidla klubové logiky (kontrola ročníků, výpočet statistik).
- **Datová vrstva:** Relační databáze MySQL garantující trvalé uložení a konzistenci dat.

---

## 2. Relační databázové systémy a jazyk SQL

Základem spolehlivého informačního systému je databázový subsystém. Pro potřeby projektu FK Náchod byl zvolen celosvětově nejrozšířenější open-source relační databázový systém **MySQL** (ve variantě MariaDB distribuované v balíku XAMPP).

### 2.1 Relační datový model a normalizace
Relační model vychází z teorie množin a predikátové logiky prvního řádu (autorem konceptu je Edgar F. Codd, 1970). Data jsou organizována do dvourozměrných **tabulek (relací)**, kde řádky představují jednotlivé **záznamy (n-tice)** a sloupce představují **atributy** se striktně definovaným datovým typem.

Aby databáze netrpěla redundancí dat a anomáliemi při vkládání (insertion anomaly), aktualizaci (update anomaly) nebo mazání (deletion anomaly), byl návrh struktury podroben procesu **databázové normalizace**:
- **První normální forma (1NF):** Všechny atributy jsou atomické (nedělitelné). Například telefonní číslo nebo e-mail nejsou ukládány jako složený textový řetězec pro více osob, ale každý atribut nese právě jednu hodnotu. Jméno a příjmení jsou striktně odděleny do samostatných sloupců `jmeno` a `prijmeni`.
- **Druhá normální forma (2NF):** Tabulka splňuje 1NF a každý neklíčový atribut je plně funkčně závislý na celém primárním klíči. U vazební tabulky `tym_trener`, která spojuje týmy a trenéry, je role trenéra závislá na celé dvojici (tým, trenér).
- **Třetí normální forma (3NF):** Tabulka splňuje 2NF a žádný neklíčový atribut není tranzitivně závislý na primárním klíči. Například v tabulce hráčů neukládáme název týmu ani věkovou kategorii, ale pouze cizí klíč `tym_id`, který odkazuje na primární klíč tabulky `tymy`.

### 2.2 Relační vazby a referenční integrita
V databázi FK Náchod jsou implementovány všechny základní typy relačních kardinalit:
1. **Relace 1:N (jeden k mnoha):**
   - Jeden tým má přiřazeno mnoho hráčů (`tymy.id` $\rightarrow$ `hraci.tym_id`).
   - Jeden tým odehrává mnoho zápasů (`tymy.id` $\rightarrow$ `zapasy.tym_id`).
   - Jeden tým absolvuje mnoho tréninků (`tymy.id` $\rightarrow$ `treninky.tym_id`).
2. **Relace M:N (mnoho k mnoha):**
   - Vztah mezi trenéry a týmy. V praxi může jeden trenér vést více kategorií (např. hlavní trenér U13 a zároveň asistent u U11) a každý tým má obvykle realizační tým složený z více trenérů. Tato relace je dekomponována pomocí asociační tabulky `tym_trener`.

Referenční integrita je vynucena na úrovni úložného jádra **InnoDB** pomocí cizích klíčů (`FOREIGN KEY`). Integritní pravidla zajišťují, že v databázi nemohou vzniknout neplatné reference (tzv. osiřelé záznamy). Při odstranění týmu je u hráčů nastaveno `ON DELETE SET NULL`, aby nedošlo ke ztrátě informací o sportovcích, zatímco u rozpisů zápasů a tréninků je použito `ON DELETE CASCADE`.

### 2.3 Transakční zpracování a principy ACID
RDBMS garantuje spolehlivost datového úložiště prostřednictvím transakcí splňujících kritéria **ACID**:
- **A (Atomicity – Nedělitelnost):** Transakce proběhne buď jako celek, nebo se neprovede vůbec (rollback).
- **C (Consistency – Konzistence):** Transakce převádí databázi z jednoho konzistentního stavu do druhého při zachování všech integritních omezení.
- **I (Isolation – Izolovanost):** Souběžně běžící transakce se navzájem neovlivňují před svým potvrzením.
- **D (Durability – Trvalost):** Změny potvrzené transakcí (commit) jsou trvale uloženy na diskovém médiu i v případě výpadku napájení.

---

## 3. Backendový vývoj v jazyce PHP 8 a rozhraní PDO

Jazyk **PHP (PHP: Hypertext Preprocessor)** představuje vyspělý, silně typovaný skriptovací jazyk optimalizovaný pro tvorbu webových aplikací na straně serveru. Projekt využívá nejnovější generaci **PHP 8**, která přináší zásadní výkonnostní i syntaktická vylepšení (JIT kompilátor, striktní typování parametrů a návratových hodnot, pojmenované argumenty, match výrazy a vylepšené ošetřování chyb).

### 3.1 Výhody PDO oproti zastaralým rozhraním
V minulosti bylo v PHP běžné využívat procedurální funkce `mysql_*` (odstraněné v PHP 7) nebo specializované rozšíření `mysqli`. V našem projektu je striktně využíváno standardizované objektové rozhraní **PDO (PHP Data Objects)**. Důvody pro volbu PDO:
1. **Databázová abstrakce:** PDO nabízí jednotné aplikační rozhraní (API) pro práci s různými databázovými stroji (MySQL, PostgreSQL, SQLite). Změna cílové databáze vyžaduje pouze úpravu inicializačního DSN řetězce bez nutnosti přepisovat exekuční dotazy.
2. **Přirozená podpora Prepared Statements:** Zajišťuje stoprocentní oddělení SQL logiky od uživatelských dat.
3. **Objektové zpracování chyb přes výjimky:** Konfigurace atributu `PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION` převádí jakékoliv databázové selhání na instanci `PDOException`, kterou lze zachytit blokem `try - catch`, což zabraňuje nechtěnému úniku systémových informací na obrazovku uživatele.
4. **Vypnutí emulace přípravy dotazů:** Nastavením `PDO::ATTR_EMULATE_PREPARES => false` je zajištěno, že příprava dotazu probíhá skutečně nativně na straně databázového serveru MySQL.

---

## 4. Bezpečnost webových aplikací dle standardů OWASP

Bezpečnost byla jednou z hlavních priorit při návrhu systému. Aplikace reflektuje doporučení mezinárodního bezpečnostního konsorcia **OWASP (Open Web Application Security Project)** a implementuje ochranu proti nejčastějším vektorům útoků.

### 4.1 Prevence SQL Injection
SQL Injection (SQLi) patří historicky k nejnebezpečnějším zranitelnostem. Nastává v situaci, kdy jsou uživatelské vstupy přímo vkládány nebo konkatenovány (spojovány tečkou) do textu SQL dotazu. Útočník může zadáním speciálních znaků (např. `' OR '1'='1`) změnit sémantiku dotazu a získat neoprávněný přístup k datům či celou databázi zničit.

**Obrana v aplikaci FK Náchod:** V celém projektu se striktně využívají **parametrizované dotazy (prepared statements)**. Příklad bezpečné implementace filtrace:
```php
// Bezpečný dotaz s pozičním zástupným symbolem (?)
$sql = "SELECT * FROM hraci WHERE tym_id = ? AND aktivni = 1";
$stmt = $pdo->prepare($sql);
$stmt->execute([$filtr_tym]);
$hraci = $stmt->fetchAll();
```
V tomto případě je struktura SQL příkazu nejprve zkompilována databázovým enginem a hodnota parametru je předána odděleně v binární podobě. I kdyby parametr obsahoval škodlivý SQL kód, databáze s ním zachází výhradně jako s literálem (prostým textem) a k injektáži kódu nemůže dojít.

### 4.2 Prevence Cross-Site Scripting (XSS)
Útok typu XSS spočívá ve vložení škodlivého klientského skriptu (JavaScriptu) do webové stránky, který je následně spuštěn v prohlížeči jiného nicnetušícího uživatele. To může vést ke krádeži session cookies, přesměrování na podvodné stránky nebo manipulaci s obsahem webu.

**Obrana v aplikaci:** Veškerý dynamický obsah načtený z databáze nebo od uživatele je při renderování do HTML šablony důsledně ošetřován funkcí `htmlspecialchars()` s nastaveným kódováním UTF-8:
```php
<td><?= htmlspecialchars($hrac['prijmeni'], ENT_QUOTES, 'UTF-8') ?></td>
```
Tato funkce převede nebezpečné HTML znaky (`<`, `>`, `&`, `"`, `'`) na jejich neškodné HTML entity (`&lt;`, `&gt;`, `&amp;`, `&quot;`, `&#039;`), čímž zamezí prohlížeči interpretovat text jako spustitelný kód.

### 4.3 Důkladná serverová validace a sanitizace
Aplikace se nikdy nespoléhá pouze na klientskou validaci v prohlížeči (např. HTML5 atribut `required`), kterou lze snadno obejít vypnutím JavaScriptu nebo přímým odesláním HTTP požadavku přes nástroje jako cURL či Postman. Každý odeslaný formulář prochází robustním validačním cyklem na straně PHP backendu:
- Ořezání bílých znaků funkcí `trim()`.
- Validace formátu e-mailové adresy pomocí interního filtru `filter_var($email, FILTER_VALIDATE_EMAIL)`.
- Kontrola formátu telefonního čísla regulárním výrazem `preg_match('/^[0-9+\s]{9,15}$/', $telefon)`.
- Validace logického rozsahu kalendářních dat (hráč se nesmí narodit v budoucnosti).

---

## 5. Frontendové technologie a responzivní webdesign

Uživatelské rozhraní aplikace je postaveno na čistých webových standardech bez nutnosti závislosti na těžkopádných externích frameworcích (jako je Bootstrap či Tailwind), což zajišťuje bleskové načítání a stoprocentní kontrolu nad zdrojovým kódem.

### 5.1 Sémantika HTML5
Struktura stránek využívá moderní sémantické značky:
- `<header>` pro hlavičku s logem klubu a hlavní navigací.
- `<main>` pro stěžejní obsahovou část stránky.
- `<nav>` pro navigační bloky.
- `<footer>` pro patičku s identifikačními údaji.
- Správné tabulkové elementy (`<table>`, `<thead>`, `<tbody>`, `<th>`, `<td>`) garantují přístupnost pro čtečky obrazovky a optimální strojové zpracování.

### 5.2 CSS3 architektura a responzivita
Stylopis [style.css](file:///d:/XAAMP/htdocs/fotbalovy-klub/css/style.css) implementuje moderní typografii, vizuální hierarchii a komponentový přístup:
- **CSS Grid:** Použit pro detailní kartu hráče a statistické dashboardy, kde umožňuje přesné dvousměrné rozvržení prvků.
- **CSS Flexbox:** Využit pro navigační menu, filtrovací lišty a inline formuláře pro zadávání skóre.
- **Responzivní design (Media Queries):** Pomocí pravidla `@media (max-width: 768px)` se layout na displejích mobilních telefonů automaticky přeuspořádává do jednoho přehledného sloupce, tabulky zmenšují své vnitřní odsazení a ovládací prvky se přizpůsobují dotykovému ovládání.

---

## 6. Verzovací systém Git a vývojové prostředí

Správa zdrojových kódů projektu probíhá v distribuovaném verzovacím systému **Git**.
- **Historie commitů:** Projekt obsahuje průběžnou historii commitů rozložených v čase, které dokumentují jednotlivé kroky vývoje aplikace od návrhu přes tvorbu databáze, implementaci stránek a formuláře až po dokumentaci.
- **Vzdálený repozitář (GitHub):** Projekt je publikován pod účtem `Tadeas07` na GitHubu v repozitáři `fotbalovy-klub`, s uděleným přístupem pro vedoucího práce (`mslavik-spselit`).
- **Vývojový stack:** Aplikace byla vyvinuta a otestována v prostředí **XAMPP** s Apache 2.4, PHP 8.5 a MySQL 8/MariaDB pod operačním systémem Windows, přičemž kód splňuje standardy přenositelnosti na jakýkoliv standardní LAMP/LEMP server.

---

## 7. Seznam použité odborné literatury a zdrojů

1. **Knihy a publikace:**
   - ČERNÝ, Jiří. *PHP 8: Kompletní průvodce moderním vývojem webových aplikací*. Praha: Grada Publishing, 2022. ISBN 978-80-271-3312-5.
   - LACKO, Ľuboslav. *MySQL: Tvorba a správa relačních databází*. Brno: Computer Press, 2020. ISBN 978-80-251-4987-1.
   - DUCKETT, Jon. *HTML a CSS: Návrh a tvorba webových stránek*. Brno: Computer Press, 2017. ISBN 978-80-251-4820-1.
2. **Normy a technické specifikace:**
   - W3C. *HTML5: A vocabulary and associated APIs for HTML and XHTML*. W3C Recommendation, 2021. Dostupné z: https://www.w3.org/TR/html5/
   - OWASP Foundation. *OWASP Top 10: The Ten Most Critical Web Application Security Risks*. 2021. Dostupné z: https://owasp.org/Top10/
   - Fotbalová asociace České republiky (FAČR). *Soutěžní řád a pravidla mládežnického fotbalu v ČR*. Praha: FAČR, 2025.
3. **Oficiální dokumentace:**
   - PHP Group. *PHP Manual: PHP Data Objects (PDO)*. Dostupné z: https://www.php.net/manual/en/book.pdo.php
   - Oracle Corporation. *MySQL 8.0 Reference Manual: InnoDB Storage Engine*. Dostupné z: https://dev.mysql.com/doc/refman/8.0/en/innodb-storage-engine.html
   - Git Project. *Pro Git Book by Scott Chacon and Ben Straub*. Dostupné z: https://git-scm.com/book/en/v2
