-- Databázová struktura pro informační systém FK Náchod
CREATE DATABASE IF NOT EXISTS `fk_nachod` 
    CHARACTER SET utf8mb4 
    COLLATE utf8mb4_czech_ci;

USE `fk_nachod`;

-- 1. Tabulka týmů (věkové kategorie)
CREATE TABLE IF NOT EXISTS `tymy` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `nazev` VARCHAR(100) NOT NULL,
    `vekova_kategorie` VARCHAR(10) NOT NULL,
    `rok_narozeni_od` INT NOT NULL,
    `rok_narozeni_do` INT NOT NULL,
    `aktivni` TINYINT(1) NOT NULL DEFAULT 1,
    `vytvoreno` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci;

-- 2. Tabulka trenérů
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

-- 3. Vazební tabulka: přiřazení trenérů k týmům (vztah M:N)
CREATE TABLE IF NOT EXISTS `tym_trener` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `tym_id` INT NOT NULL,
    `trener_id` INT NOT NULL,
    `role` ENUM('hlavni', 'asistent') NOT NULL DEFAULT 'asistent',
    FOREIGN KEY (`tym_id`) REFERENCES `tymy`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`trener_id`) REFERENCES `treneri`(`id`) ON DELETE CASCADE,
    UNIQUE KEY `uq_tym_trener` (`tym_id`, `trener_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci;

-- 4. Tabulka hráčů
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
