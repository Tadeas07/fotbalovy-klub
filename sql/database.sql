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
