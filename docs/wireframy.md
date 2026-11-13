# Wireframy a informační architektura aplikace

Tento dokument obsahuje návrhy uživatelského rozhraní (wireframy) klíčových stránek pro informační systém mládeže **FK Náchod**, včetně mapy stránek a popisu navigace.

---

## 1. Mapa stránek a struktura navigace (Sitemap)

Aplikace využívá přehlednou hierarchickou strukturu:

```
[Hlavní navigace v záhlaví]
        |
        +---> 1. Seznam hráčů (index.php) [Rozpracováno]
        |        |
        |        +---> Detail hráče (detail.php?id=X) [Rozpracováno]
        |
        +---> 2. Registrace hráče (pridat.php) [Rozpracováno - formulář s kontrolou věku]
        |
        +---> 3. Zápasy a výsledky (zapasy.php) [Plánováno do další etapy]
        |
        +---> 4. Rozvrh tréninků (treninky.php) [Plánováno do další etapy]
```

---

## 2. Wireframe 1: Přehled hráčů (index.php)

Hlavní stránka slouží k rychlému přehledu všech registrovaných hráčů s možností okamžitého filtrování podle věkové kategorie týmu.

```
+--------------------------------------------------------------------------------+
| FK Náchod - Mládež                        [Seznam hráčů]   [+ Přidat hráče]    |
| Informační systém pro správu kategorií                                         |
+--------------------------------------------------------------------------------+
|                                                                                |
| [ Informační lišta: Rozpracovaná verze projektu k 13. 11. ]                    |
|                                                                                |
| Seznam registrovaných hráčů                               [+ Přidat hráče]     |
|                                                                                |
| +----------------------------------------------------------------------------+ |
| | Filtrovat podle kategorie týmu: [ Všechny kategorie / U11 / U13 / U15 / U17] | |
| +----------------------------------------------------------------------------+ |
|                                                                                |
| +----+--------------+------------+-----------------+----------+----------+---+ |
| | #  | Příjmení     | Jméno      | Datum narození  | Pozice   | Tým      |   | |
| +----+--------------+------------+-----------------+----------+----------+---+ |
| | 1  | Beneš        | Tomáš      | 25. 04. 2011    | BRANKÁŘ  | U15      |[D]| |
| | 2  | Dostál       | Matěj      | 14. 05. 2010    | ÚTOČNÍK  | U17      |[D]| |
| | 3  | Horák        | Daniel     | 18. 05. 2013    | BRANKÁŘ  | U13      |[D]| |
| | 4  | Malý         | Lukáš      | 14. 03. 2015    | BRANKÁŘ  | U11      |[D]| |
| +----+--------------+------------+-----------------+----------+----------+---+ |
| Celkem zobrazeno hráčů: 16                                                     |
|                                                                                |
+--------------------------------------------------------------------------------+
| Maturitní projekt: Informační systém FK Náchod | Autor: Tadeáš | SPŠE Litomyšl |
+--------------------------------------------------------------------------------+
```

---

## 3. Wireframe 2: Detail vybraného hráče (detail.php)

Zobrazuje souhrnné informace o hráči, dopočítaný věk, kontakty na zákonné zástupce a seznam spoluhráčů ze stejného týmu.

```
+--------------------------------------------------------------------------------+
| FK Náchod - Mládež                        [Seznam hráčů]   [+ Přidat hráče]    |
+--------------------------------------------------------------------------------+
|                                                                                |
| [<- Zpět na seznam hráčů]                                                      |
|                                                                                |
| +-- KARTA HRÁČE -------------------------------------------------------------+ |
| | Kratochvíl Martin                                               [ÚTOČNÍK]  | |
| | -------------------------------------------------------------------------- | |
| | Datum narození: 30. 03. 2012 (věk: 14 let)   Tým: FK Náchod U15 (U15)      | |
| | Telefon na rodiče: 723 000 004               Stav: Aktivní člen klubu      | |
| | E-mail na rodiče: kratochvil.rodic@seznam.cz Registrace: 13. 11. 2026      | |
| +----------------------------------------------------------------------------+ |
|                                                                                |
| Spoluhráči v kategorii U15                                                     |
| +-------------------------+--------------------+----------------+------------+ |
| | Příjmení a jméno        | Herní pozice       | Datum narození | Profil     | |
| +-------------------------+--------------------+----------------+------------+ |
| | Beneš Tomáš             | BRANKÁŘ            | 25. 04. 2011   | [Zobrazit] | |
| | Fiala Jan               | ZÁLOŽNÍK           | 01. 12. 2011   | [Zobrazit] | |
| | Šťastný David           | OBRÁNCE            | 12. 08. 2012   | [Zobrazit] | |
| +-------------------------+--------------------+----------------+------------+ |
|                                                                                |
+--------------------------------------------------------------------------------+
| Maturitní projekt: Informační systém FK Náchod | Autor: Tadeáš | SPŠE Litomyšl |
+--------------------------------------------------------------------------------+
```

---

## 4. Wireframe 3: Formulář pro přidání hráče (pridat.php)

Formulář s kontrolou povinných polí, formátů kontaktů a aplikační logikou hlídající ročník narození vůči kategorii.

```
+--------------------------------------------------------------------------------+
| FK Náchod - Mládež                        [Seznam hráčů]   [+ Přidat hráče]    |
+--------------------------------------------------------------------------------+
|                                                                                |
| [<- Zpět na seznam hráčů]                                                      |
| Registrace nového hráče                                                        |
|                                                                                |
| [ Červený box chybových hlášení při nevalidním odeslání (např. věk nesedí) ]   |
|                                                                                |
| +-- FORMULÁŘOVÁ KARTA -------------------------------------------------------+ |
| | Jméno hráče: *                  Příjmení hráče: *                          | |
| | [ Textové pole ........... ]    [ Textové pole ........... ]               | |
| |                                                                            | |
| | Datum narození: *               Herní pozice: *                            | |
| | [ Kalendář RRRR-MM-DD .... ]    [ Výběr: Brankář / Obránce / Záložník / ...| |
| |                                                                            | |
| | Tým (kategorie): *                                                         | |
| | [ Výběr: FK Náchod U13 (kategorie U13, ročníky 2013 - 2014)             v] | |
| | Pozor: Systém hlídá věkový limit podle oficiálních ročníků FAČR.           | |
| | -------------------------------------------------------------------------- | |
| | Kontaktní údaje zákonného zástupce                                         | |
| | Telefon na rodiče:              E-mail na rodiče:                          | |
| | [ 603 123 456 ............ ]    [ rodic@seznam.cz ........ ]               | |
| |                                                                            | |
| | [Uložit hráče do databáze]      [Zrušit]                                   | |
| +----------------------------------------------------------------------------+ |
|                                                                                |
+--------------------------------------------------------------------------------+
| Maturitní projekt: Informační systém FK Náchod | Autor: Tadeáš | SPŠE Litomyšl |
+--------------------------------------------------------------------------------+
```

---

## 5. Wireframe 4: Stránka s aplikační logikou – Zápasy (návrh pro etapu 2)

Návrh stránky zápasů, kde bude realizována pokročilá aplikační logika:
- Zákaz zadat skóre u zápasů, které se ještě neodehrály
- Automatické vyhodnocení výsledku a výpočet bilance

```
+--------------------------------------------------------------------------------+
| FK Náchod - Mládež            [Hráči]   [Zápasy]   [Tréninky]   [+ Přidat]     |
+--------------------------------------------------------------------------------+
|                                                                                |
| Zápasy a výsledky mládeže                                                      |
|                                                                                |
| +-- STATISTICKÝ PŘEHLED -----------------------------------------------------+ |
| |   [ 3 Výhry ]        [ 1 Remíza ]        [ 1 Prohra ]        [ 5 Celkem ]  | |
| +----------------------------------------------------------------------------+ |
|                                                                                |
| Plánovaná utkání (budoucí datum - skóre nelze zadat)                           |
| +--------------+-------+--------------------+-----------+--------------------+ |
| | Datum        | Tým   | Soupeř             | Místo     | Skóre              | |
| +--------------+-------+--------------------+-----------+--------------------+ |
| | 23. 11. 2026 | U13   | SK Hronov U13      | Náchod    | Čeká se na výkop   | |
| +--------------+-------+--------------------+-----------+--------------------+ |
|                                                                                |
| Odehraná utkání (datum v minulosti - výsledek zadán nebo k zadání)             |
| +--------------+-------+--------------------+-----------+--------------------+ |
| | Datum        | Tým   | Soupeř             | Prostředí | Výsledek           | |
| +--------------+-------+--------------------+-----------+--------------------+ |
| | 09. 11. 2026 | U17   | FK Dvůr Králové    | Domácí    | 2:1 (Výhra)        | |
| | 02. 11. 2026 | U15   | SK Nové Město      | Venkovní  | 1:3 (Prohra)       | |
| +--------------+-------+--------------------+-----------+--------------------+ |
|                                                                                |
+--------------------------------------------------------------------------------+
| Maturitní projekt: Informační systém FK Náchod | Autor: Tadeáš | SPŠE Litomyšl |
+--------------------------------------------------------------------------------+
```
