<?php
require_once __DIR__ . '/db.php';
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) { header('Location: index.php'); exit; }
?>
<!DOCTYPE html>
<html lang="cs"><head><meta charset="UTF-8"><title>Detail hráče</title><link rel="stylesheet" href="css/style.css"></head>
<body><header class="hlavicka"><div class="obal"><h1>FK Náchod - Mládež</h1></div></header>
<main class="obal"><h2>Detail hráče</h2></main></body></html>
