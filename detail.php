<?php
require_once __DIR__ . '/db.php';
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) { header('Location: index.php'); exit; }
?>
<!DOCTYPE html>
<html lang="cs">
<head><meta charset="UTF-8"><title>Detail hráče</title></head>
<body><header><h1>⚽ FK Náchod – Mládež</h1></header><main class="container"><h2><?= htmlspecialchars($hrac['prijmeni'] . ' ' . $hrac['jmeno']) ?></h2></main></body>
</html>



