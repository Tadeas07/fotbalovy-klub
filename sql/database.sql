-- ============================================================
-- FK Náchod – Mládežnický fotbalový klub
-- Databáze pro správu hráčů, týmů, trenérů, tréninků a zápasů
-- ============================================================

CREATE DATABASE IF NOT EXISTS `fk_nachod` CHARACTER SET utf8mb4 COLLATE utf8mb4_czech_ci;
USE `fk_nachod`;

-- ------------------------------------------------------------
-- 1) Týmy (věkové kategorie)
-- ------------------------------------------------------------
CREATE TABLE `tymy` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `nazev` VARCHAR(100) NOT NULL,
    `vekova_kategorie` VARCHAR(10) NOT NULL COMMENT 'Např. U7, U9, U11…',
    `rok_narozeni_od` INT NOT NULL COMMENT 'Nejstarší ročník narození',
    `rok_narozeni_do` INT NOT NULL COMMENT 'Nejmladší ročník narození',
    `aktivni` TINYINT(1) NOT NULL DEFAULT 1,
    `vytvoreno` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ------------------------------------------------------------
-- 2) Trenéři
-- ------------------------------------------------------------
CREATE TABLE `treneri` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `jmeno` VARCHAR(50) NOT NULL,
    `prijmeni` VARCHAR(50) NOT NULL,
    `telefon` VARCHAR(20) DEFAULT NULL,
    `email` VARCHAR(100) DEFAULT NULL,
    `licence` ENUM('C','B','UEFA_B','A','UEFA_A','PRO') NOT NULL DEFAULT 'C',
    `aktivni` TINYINT(1) NOT NULL DEFAULT 1,
    `vytvoreno` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ------------------------------------------------------------
-- 3) Přiřazení trenérů k týmům (M:N)
-- ------------------------------------------------------------
CREATE TABLE `tym_trener` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `tym_id` INT NOT NULL,
    `trener_id` INT NOT NULL,
    `role` ENUM('hlavni','asistent') NOT NULL DEFAULT 'asistent',
    FOREIGN KEY (`tym_id`) REFERENCES `tymy`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`trener_id`) REFERENCES `treneri`(`id`) ON DELETE CASCADE,
    UNIQUE KEY `uq_tym_trener` (`tym_id`, `trener_id`)
) ENGINE=InnoDB;

-- ------------------------------------------------------------
-- 4) Hráči
-- ------------------------------------------------------------
CREATE TABLE `hraci` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `jmeno` VARCHAR(50) NOT NULL,
    `prijmeni` VARCHAR(50) NOT NULL,
    `datum_narozeni` DATE NOT NULL,
    `pozice` ENUM('brankář','obránce','záložník','útočník') NOT NULL,
    `tym_id` INT DEFAULT NULL,
    `telefon_rodice` VARCHAR(20) DEFAULT NULL,
    `email_rodice` VARCHAR(100) DEFAULT NULL,
    `aktivni` TINYINT(1) NOT NULL DEFAULT 1,
    `vytvoreno` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`tym_id`) REFERENCES `tymy`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB;

-- ------------------------------------------------------------
-- 5) Zápasy
-- ------------------------------------------------------------
CREATE TABLE `zapasy` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `tym_id` INT NOT NULL,
    `souper` VARCHAR(100) NOT NULL,
    `datum` DATE NOT NULL,
    `cas` TIME DEFAULT NULL,
    `misto` VARCHAR(150) DEFAULT NULL,
    `typ` ENUM('domácí','venkovní') NOT NULL DEFAULT 'domácí',
    `skore_domaci` INT DEFAULT NULL,
    `skore_hoste` INT DEFAULT NULL,
    `poznamka` TEXT DEFAULT NULL,
    `vytvoreno` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`tym_id`) REFERENCES `tymy`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB;

-- ------------------------------------------------------------
-- 6) Tréninky
-- ------------------------------------------------------------
CREATE TABLE `treninky` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `tym_id` INT NOT NULL,
    `datum` DATE NOT NULL,
    `cas_od` TIME NOT NULL,
    `cas_do` TIME NOT NULL,
    `misto` VARCHAR(150) NOT NULL DEFAULT 'Hlavní hřiště FK Náchod',
    `popis` TEXT DEFAULT NULL,
    `vytvoreno` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`tym_id`) REFERENCES `tymy`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB;


-- ============================================================
-- TESTOVACÍ DATA
-- ============================================================

-- Týmy
INSERT INTO `tymy` (`nazev`, `vekova_kategorie`, `rok_narozeni_od`, `rok_narozeni_do`) VALUES
('FK Náchod U11', 'U11', 2015, 2016),
('FK Náchod U13', 'U13', 2013, 2014),
('FK Náchod U15', 'U15', 2011, 2012),
('FK Náchod U17', 'U17', 2009, 2010);

-- Trenéři
INSERT INTO `treneri` (`jmeno`, `prijmeni`, `telefon`, `email`, `licence`) VALUES
('Jan',    'Novák',    '602111222', 'novak@fknachod.cz',    'UEFA_B'),
('Petr',   'Svoboda',  '603222333', 'svoboda@fknachod.cz',  'B'),
('Martin', 'Dvořák',   '604333444', 'dvorak@fknachod.cz',   'C'),
('Tomáš',  'Černý',    '605444555', 'cerny@fknachod.cz',    'B');

-- Přiřazení trenérů
INSERT INTO `tym_trener` (`tym_id`, `trener_id`, `role`) VALUES
(1, 3, 'hlavni'),
(2, 2, 'hlavni'),
(2, 3, 'asistent'),
(3, 1, 'hlavni'),
(4, 4, 'hlavni');

-- Hráči U11
INSERT INTO `hraci` (`jmeno`, `prijmeni`, `datum_narozeni`, `pozice`, `tym_id`, `telefon_rodice`, `email_rodice`) VALUES
('Lukáš',  'Malý',      '2015-03-14', 'brankář',  1, '721000001', 'maly@email.cz'),
('Adam',   'Veselý',    '2015-07-22', 'obránce',  1, '721000002', 'vesely@email.cz'),
('Jakub',  'Procházka', '2016-01-10', 'záložník', 1, '721000003', 'prochazka@email.cz'),
('Filip',  'Kučera',    '2015-11-05', 'útočník',  1, '721000004', 'kucera@email.cz');

-- Hráči U13
INSERT INTO `hraci` (`jmeno`, `prijmeni`, `datum_narozeni`, `pozice`, `tym_id`, `telefon_rodice`, `email_rodice`) VALUES
('Daniel', 'Horák',     '2013-05-18', 'brankář',  2, '722000001', 'horak@email.cz'),
('Matyáš', 'Němec',     '2014-02-28', 'obránce',  2, '722000002', 'nemec@email.cz'),
('Ondřej', 'Marek',     '2013-09-03', 'záložník', 2, '722000003', 'marek@email.cz'),
('Vojtěch','Pospíšil',  '2014-06-17', 'útočník',  2, '722000004', 'pospisil@email.cz');

-- Hráči U15
INSERT INTO `hraci` (`jmeno`, `prijmeni`, `datum_narozeni`, `pozice`, `tym_id`, `telefon_rodice`, `email_rodice`) VALUES
('Tomáš',  'Beneš',     '2011-04-25', 'brankář',  3, '723000001', 'benes@email.cz'),
('David',  'Šťastný',   '2012-08-12', 'obránce',  3, '723000002', 'stastny@email.cz'),
('Jan',    'Fiala',      '2011-12-01', 'záložník', 3, '723000003', 'fiala@email.cz'),
('Martin', 'Kratochvíl','2012-03-30', 'útočník',  3, '723000004', 'kratochvil@email.cz');

-- Hráči U17
INSERT INTO `hraci` (`jmeno`, `prijmeni`, `datum_narozeni`, `pozice`, `tym_id`, `telefon_rodice`, `email_rodice`) VALUES
('Petr',   'Sedláček',  '2009-06-08', 'brankář',  4, '724000001', 'sedlacek@email.cz'),
('Karel',  'Vlček',     '2010-01-19', 'obránce',  4, '724000002', 'vlcek@email.cz'),
('Štěpán', 'Kolář',     '2009-10-27', 'záložník', 4, '724000003', 'kolar@email.cz'),
('Matěj',  'Dostál',    '2010-05-14', 'útočník',  4, '724000004', 'dostal@email.cz');

-- Zápasy
INSERT INTO `zapasy` (`tym_id`, `souper`, `datum`, `cas`, `misto`, `typ`, `skore_domaci`, `skore_hoste`) VALUES
(1, 'SK Jaroměř U11',     '2026-10-05', '10:00', 'Hlavní hřiště FK Náchod', 'domácí',   3, 1),
(1, 'TJ Česká Skalice U11','2026-10-19', '10:00', 'Hřiště Česká Skalice',   'venkovní',  2, 2),
(2, 'FK Trutnov U13',     '2026-10-12', '14:00', 'Hlavní hřiště FK Náchod', 'domácí',   4, 0),
(3, 'SK Nové Město U15',  '2026-11-02', '15:00', 'Hřiště Nové Město',      'venkovní',  1, 3),
(4, 'FK Dvůr Králové U17','2026-11-09', '16:00', 'Hlavní hřiště FK Náchod', 'domácí',   2, 1),
(2, 'SK Hronov U13',      '2026-11-23', '14:00', 'Hlavní hřiště FK Náchod', 'domácí',   NULL, NULL),
(3, 'FK Police U15',      '2026-12-01', '15:00', 'Hřiště Police nad Metují','venkovní', NULL, NULL);

-- Tréninky
INSERT INTO `treninky` (`tym_id`, `datum`, `cas_od`, `cas_do`, `misto`, `popis`) VALUES
(1, '2026-11-11', '16:00', '17:30', 'Hlavní hřiště FK Náchod', 'Nácvik přihrávek a střelby'),
(1, '2026-11-13', '16:00', '17:30', 'Hlavní hřiště FK Náchod', 'Herní cvičení 4v4'),
(2, '2026-11-11', '17:30', '19:00', 'Hlavní hřiště FK Náchod', 'Taktická příprava na zápas'),
(2, '2026-11-14', '17:30', '19:00', 'Hlavní hřiště FK Náchod', 'Kondiční trénink'),
(3, '2026-11-12', '16:00', '18:00', 'Umělá tráva FK Náchod',   'Standardní situace'),
(4, '2026-11-12', '18:00', '19:30', 'Umělá tráva FK Náchod',   'Příprava na derby');
