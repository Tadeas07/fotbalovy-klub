<?php
/**
 * Databázové připojení pro informační systém FK Náchod
 * Využívá PDO rozhraní pro bezpečnou práci s databází
 */

$db_host = 'localhost';
$db_name = 'fk_nachod';
$db_user = 'root';
$db_pass = '';

try {
    // Vytvoření PDO instance s nastavením kódování utf8mb4
    $pdo = new PDO(
        "mysql:host=$db_host;dbname=$db_name;charset=utf8mb4",
        $db_user,
        $db_pass,
        [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Vyhazovat výjimky při chybách
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // Výsledky jako asociativní pole
            PDO::ATTR_EMULATE_PREPARES   => false,                  // Vypnout emulaci prepared statements
        ]
    );
} catch (PDOException $e) {
    // V případě chyby zobrazit srozumitelnou zprávu a ukončit skript
    die("Chyba při připojování k databázi: " . $e->getMessage());
}
