-- Databáze pro informační systém FK Náchod
-- Autor: Tadeáš Šmehlík, SPŠ ELIT Dobruška
-- Maturitní projekt 2026/2027

CREATE DATABASE IF NOT EXISTS `fk_nachod` 
    CHARACTER SET utf8mb4 
    COLLATE utf8mb4_czech_ci;

USE `fk_nachod`;

-- 1. Tabulka věkových kategorií (týmů)
CREATE TABLE IF NOT EXISTS `tymy` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `nazev` VARCHAR(100) NOT NULL,
    `vekova_kategorie` VARCHAR(10) NOT NULL,
    `rok_narozeni_od` INT NOT NULL,
    `rok_narozeni_do` INT NOT NULL,
    `aktivni` TINYINT(1) NOT NULL DEFAULT 1,
    `vytvoreno` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci;

-- 2. Tabulka trenérů klubu
CREATE TABLE IF NOT EXISTS `treneri` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `jmeno` VARCHAR(50) NOT NULL,
    `prijmeni` VARCHAR(50) NOT NULL,
    `telefon` VARCHAR(20) DEFAULT NULL,
    `email` VARCHAR(100) DEFAULT NULL,
    `licence` ENUM('C', 'B', 'UEFA_B', 'A', 'UEFA_A', 'PRO') NOT NULL DEFAULT 'C',
    `aktivni` TINYINT(1) NOT NULL DEFAULT 1,
    `vytvoreno` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci;

-- 3. Spojovací tabulka pro přiřazení trenérů k týmům (vazba M:N)
CREATE TABLE IF NOT EXISTS `tym_trener` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `tym_id` INT NOT NULL,
    `trener_id` INT NOT NULL,
    `role` ENUM('hlavni', 'asistent') NOT NULL DEFAULT 'asistent',
    FOREIGN KEY (`tym_id`) REFERENCES `tymy`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`trener_id`) REFERENCES `treneri`(`id`) ON DELETE CASCADE,
    UNIQUE KEY `uq_tym_trener` (`tym_id`, `trener_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci;

-- 4. Tabulka hráčů s vazbou na tým (vazba 1:N)
CREATE TABLE IF NOT EXISTS `hraci` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `jmeno` VARCHAR(50) NOT NULL,
    `prijmeni` VARCHAR(50) NOT NULL,
    `datum_narozeni` DATE NOT NULL,
    `pozice` ENUM('brankář', 'obránce', 'záložník', 'útočník') NOT NULL,
    `tym_id` INT DEFAULT NULL,
    `telefon_rodice` VARCHAR(20) DEFAULT NULL,
    `email_rodice` VARCHAR(100) DEFAULT NULL,
    `aktivni` TINYINT(1) NOT NULL DEFAULT 1,
    `vytvoreno` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`tym_id`) REFERENCES `tymy`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci;

-- 5. Tabulka zápasů
CREATE TABLE IF NOT EXISTS `zapasy` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `tym_id` INT NOT NULL,
    `souper` VARCHAR(100) NOT NULL,
    `datum` DATE NOT NULL,
    `cas` TIME DEFAULT NULL,
    `misto` VARCHAR(150) DEFAULT NULL,
    `typ` ENUM('domácí', 'venkovní') NOT NULL DEFAULT 'domácí',
    `skore_domaci` INT DEFAULT NULL,
    `skore_hoste` INT DEFAULT NULL,
    `poznamka` TEXT DEFAULT NULL,
    `vytvoreno` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`tym_id`) REFERENCES `tymy`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci;

-- 6. Tabulka tréninků
CREATE TABLE IF NOT EXISTS `treninky` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `tym_id` INT NOT NULL,
    `datum` DATE NOT NULL,
    `cas_od` TIME NOT NULL,
    `cas_do` TIME NOT NULL,
    `misto` VARCHAR(150) NOT NULL DEFAULT 'Hlavní hřiště FK Náchod',
    `popis` TEXT DEFAULT NULL,
    `vytvoreno` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`tym_id`) REFERENCES `tymy`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci;

-- Testovací data pro kategorie
INSERT INTO `tymy` (`id`, `nazev`, `vekova_kategorie`, `rok_narozeni_od`, `rok_narozeni_do`) VALUES
(1, 'FK Náchod U11', 'U11', 2015, 2016),
(2, 'FK Náchod U13', 'U13', 2013, 2014),
(3, 'FK Náchod U15', 'U15', 2011, 2012),
(4, 'FK Náchod U17', 'U17', 2009, 2010);

-- Testovací trenéři
INSERT INTO `treneri` (`id`, `jmeno`, `prijmeni`, `telefon`, `email`, `licence`) VALUES
(1, 'Jan',    'Novák',    '602 111 222', 'novak@fknachod.cz',    'UEFA_B'),
(2, 'Petr',   'Svoboda',  '603 222 333', 'svoboda@fknachod.cz',  'B'),
(3, 'Martin', 'Dvořák',   '604 333 444', 'dvorak@fknachod.cz',   'C'),
(4, 'Tomáš',  'Černý',    '605 444 555', 'cerny@fknachod.cz',    'B');

-- Přiřazení trenérů k týmům
INSERT INTO `tym_trener` (`tym_id`, `trener_id`, `role`) VALUES
(1, 3, 'hlavni'),
(2, 2, 'hlavni'),
(2, 3, 'asistent'),
(3, 1, 'hlavni'),
(4, 4, 'hlavni');

-- Testovací hráči pro jednotlivé kategorie
INSERT INTO `hraci` (`jmeno`, `prijmeni`, `datum_narozeni`, `pozice`, `tym_id`, `telefon_rodice`, `email_rodice`) VALUES
('Lukáš',  'Malý',      '2015-03-14', 'brankář',  1, '721 000 001', 'maly.rodic@seznam.cz'),
('Adam',   'Veselý',    '2015-07-22', 'obránce',  1, '721 000 002', 'vesely.rodic@email.cz'),
('Jakub',  'Procházka', '2016-01-10', 'záložník', 1, '721 000 003', 'prochazka.rodic@gmail.com'),
('Filip',  'Kučera',    '2015-11-05', 'útočník',  1, '721 000 004', 'kucera.rodic@seznam.cz'),
('Daniel', 'Horák',     '2013-05-18', 'brankář',  2, '722 000 001', 'horak.rodic@seznam.cz'),
('Matyáš', 'Němec',     '2014-02-28', 'obránce',  2, '722 000 002', 'nemec.rodic@email.cz'),
('Ondřej', 'Marek',     '2013-09-03', 'záložník', 2, '722 000 003', 'marek.rodic@gmail.com'),
('Vojtěch','Pospíšil',  '2014-06-17', 'útočník',  2, '722 000 004', 'pospisil.rodic@seznam.cz'),
('Tomáš',  'Beneš',     '2011-04-25', 'brankář',  3, '723 000 001', 'benes.rodic@seznam.cz'),
('David',  'Šťastný',   '2012-08-12', 'obránce',  3, '723 000 002', 'stastny.rodic@email.cz'),
('Jan',    'Fiala',      '2011-12-01', 'záložník', 3, '723 000 003', 'fiala.rodic@gmail.com'),
('Martin', 'Kratochvíl','2012-03-30', 'útočník',  3, '723 000 004', 'kratochvil.rodic@seznam.cz'),
('Petr',   'Sedláček',  '2009-06-08', 'brankář',  4, '724 000 001', 'sedlacek.rodic@seznam.cz'),
('Karel',  'Vlček',     '2010-01-19', 'obránce',  4, '724 000 002', 'vlcek.rodic@email.cz'),
('Štěpán', 'Kolář',     '2009-10-27', 'záložník', 4, '724 000 003', 'kolar.rodic@gmail.com'),
('Matěj',  'Dostál',    '2010-05-14', 'útočník',  4, '724 000 004', 'dostal.rodic@seznam.cz');

-- Testovací zápasy
INSERT INTO `zapasy` (`tym_id`, `souper`, `datum`, `cas`, `misto`, `typ`, `skore_domaci`, `skore_hoste`) VALUES
(1, 'SK Jaroměř U11',      '2026-10-05', '10:00', 'Hlavní hřiště FK Náchod',  'domácí',   3, 1),
(1, 'TJ Česká Skalice U11', '2026-10-19', '10:00', 'Hřiště Česká Skalice',    'venkovní',  2, 2),
(2, 'FK Trutnov U13',      '2026-10-12', '14:00', 'Hlavní hřiště FK Náchod',  'domácí',   4, 0),
(3, 'SK Nové Město U15',   '2026-11-02', '15:00', 'Hřiště Nové Město',       'venkovní',  1, 3),
(4, 'FK Dvůr Králové U17', '2026-11-09', '16:00', 'Hlavní hřiště FK Náchod',  'domácí',   2, 1),
(2, 'SK Hronov U13',       '2026-11-23', '14:00', 'Hlavní hřiště FK Náchod',  'domácí',   NULL, NULL),
(3, 'FK Police U15',       '2026-12-01', '15:00', 'Hřiště Police nad Metují', 'venkovní',  NULL, NULL);

-- Testovací tréninky
INSERT INTO `treninky` (`tym_id`, `datum`, `cas_od`, `cas_do`, `misto`, `popis`) VALUES
(1, '2026-11-11', '16:00', '17:30', 'Hlavní hřiště FK Náchod', 'Nácvik přihrávek a střelby'),
(1, '2026-11-13', '16:00', '17:30', 'Hlavní hřiště FK Náchod', 'Herní cvičení na malém prostoru'),
(2, '2026-11-11', '17:30', '19:00', 'Hlavní hřiště FK Náchod', 'Taktická příprava a obranná fáze'),
(2, '2026-11-14', '17:30', '19:00', 'Hlavní hřiště FK Náchod', 'Kondiční a rychlostní trénink'),
(3, '2026-11-12', '16:00', '18:00', 'Umělá tráva FK Náchod',    'Standardní situace a rohy'),
(4, '2026-11-12', '18:00', '19:30', 'Umělá tráva FK Náchod',    'Příprava na mistrovské utkání');
