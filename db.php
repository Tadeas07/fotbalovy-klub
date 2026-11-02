<?php
// Konfigurace připojení k lokální MySQL databázi v XAMPPu
$db_host = 'localhost';
$db_name = 'fk_nachod';
$db_user = 'root';
$db_pass = ''; // ve výchozím XAMPPu je heslo prázdné

try {
    // Vytvoření PDO instance s nastavením UTF-8
    $pdo = new PDO(
        "mysql:host=$db_host;dbname=$db_name;charset=utf8mb4",
        $db_user,
        $db_pass,
        [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // při chybě vyhodí výjimku
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,     // vrací výsledky jako asociativní pole
            PDO::ATTR_EMULATE_PREPARES   => false,                 // reálné prepared statements pro bezpečnost
        ]
    );
} catch (PDOException $e) {
    // Pokud se nepodaří připojit, vypíše chybu a zastaví skript
    die("Chyba při připojování k databázi: " . $e->getMessage());
}
