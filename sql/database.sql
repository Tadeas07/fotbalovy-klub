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
