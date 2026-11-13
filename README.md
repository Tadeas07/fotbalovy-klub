# FK Náchod – Webová aplikace pro mládežnický fotbalový klub

Školní projekt: **Návrh a implementace webové aplikace**

## Popis

Webová aplikace pro správu mládežnického fotbalového klubu FK Náchod. Umožňuje evidenci hráčů, týmů, trenérů, zápasů a tréninků.

## Požadavky

- PHP 8.0+
- MySQL / MariaDB
- XAMPP (nebo jiné vývojové prostředí)

## Instalace

1. Naklonujte repozitář do `htdocs/fotbalovy-klub`
2. Spusťte XAMPP (Apache + MySQL)
3. Importujte databázi: otevřete phpMyAdmin a importujte soubor `sql/database.sql`
4. Otevřete v prohlížeči: `http://localhost/fotbalovy-klub/`

## Struktura projektu

```
fotbalovy-klub/
├── index.php          Přehled hráčů (filtrování podle týmu)
├── detail.php         Detail hráče (spoluhráči, zápasy)
├── pridat.php         Formulář pro přidání hráče (s validací)
├── zapasy.php         Přehled zápasů + zadání skóre
├── treninky.php       Rozvrh tréninků
├── db.php             Připojení k databázi (PDO)
├── css/style.css      Styly
├── sql/database.sql   SQL skript (CREATE TABLE + testovací data)
└── docs/              Dokumentace
    ├── popis.md       Jednostránkový popis aplikace
    └── pravidla.md    Pravidla aplikační logiky
```

## Autor

Tadeáš – SPŠE Litomyšl
