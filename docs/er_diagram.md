# FK Náchod – ER diagram a návrh relační databáze

## 1. Konceptuální model a vztahy mezi entitami

Databáze informačního systému mládežnického fotbalového klubu **FK Náchod** se skládá ze **6 provázaných tabulek**, které plně pokrývají potřeby klubu: správu kategorií (týmů), trenérů, hráčů, tréninkových jednotek a mistrovských zápasů.

```mermaid
erDiagram
    tymy ||--o{ hraci : "má přiřazené (1:N)"
    tymy ||--o{ zapasy : "odehrává (1:N)"
    tymy ||--o{ treninky : "absolvuje (1:N)"
    tymy ||--o{ tym_trener : "má přiřazené (1:N)"
    treneri ||--o{ tym_trener : "trénuje v (1:N)"

    tymy {
        int id PK
        varchar nazev
        varchar vekova_kategorie
        int rok_narozeni_od
        int rok_narozeni_do
        tinyint aktivni
        datetime vytvoreno
    }

    treneri {
        int id PK
        varchar jmeno
        varchar prijmeni
        varchar telefon
        varchar email
        enum licence
        tinyint aktivni
        datetime vytvoreno
    }

    tym_trener {
        int id PK
        int tym_id FK
        int trener_id FK
        enum role
    }

    hraci {
        int id PK
        varchar jmeno
        varchar prijmeni
        date datum_narozeni
        enum pozice
        int tym_id FK
        varchar telefon_rodice
        varchar email_rodice
        tinyint aktivni
        datetime vytvoreno
    }

    zapasy {
