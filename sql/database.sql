-- ============================================================
-- FK Náchod – Mládežnický fotbalový klub
-- ============================================================
CREATE DATABASE IF NOT EXISTS `fk_nachod` CHARACTER SET utf8mb4 COLLATE utf8mb4_czech_ci;
USE `fk_nachod`;

-- 1) Týmy (věkové kategorie)
CREATE TABLE `tymy` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `nazev` VARCHAR(100) NOT NULL,
    `vekova_kategorie` VARCHAR(10) NOT NULL,
    `rok_narozeni_od` INT NOT NULL,
    `rok_narozeni_do` INT NOT NULL,
    `aktivni` TINYINT(1) NOT NULL DEFAULT 1,
    `vytvoreno` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- 2) Trenéři
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

-- 3) Přiřazení trenérů k týmům (M:N)
CREATE TABLE `tym_trener` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `tym_id` INT NOT NULL,
    `trener_id` INT NOT NULL,
    `role` ENUM('hlavni','asistent') NOT NULL DEFAULT 'asistent',
    FOREIGN KEY (`tym_id`) REFERENCES `tymy`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`trener_id`) REFERENCES `treneri`(`id`) ON DELETE CASCADE,
    UNIQUE KEY `uq_tym_trener` (`tym_id`, `trener_id`)
) ENGINE=InnoDB;

-- 4) Hráči
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

-- 5) Zápasy
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

-- 6) Tréninky
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

-- TESTOVACÍ DATA
INSERT INTO `tymy` (`nazev`, `vekova_kategorie`, `rok_narozeni_od`, `rok_narozeni_do`) VALUES
('FK Náchod U11', 'U11', 2015, 2016),
('FK Náchod U13', 'U13', 2013, 2014),
('FK Náchod U15', 'U15', 2011, 2012),
('FK Náchod U17', 'U17', 2009, 2010);

INSERT INTO `treneri` (`jmeno`, `prijmeni`, `telefon`, `email`, `licence`) VALUES
('Jan', 'Novák', '602111222', 'novak@fknachod.cz', 'UEFA_B'),
('Petr', 'Svoboda', '603222333', 'svoboda@fknachod.cz', 'B'),
('Martin', 'Dvořák', '604333444', 'dvorak@fknachod.cz', 'C'),
('Tomáš', 'Černý', '605444555', 'cerny@fknachod.cz', 'B');
