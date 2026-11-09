<?php
require_once __DIR__ . '/db.php';
$id = (int)($_GET['id'] ?? 0);
if ($id <= 0) { header('Location: index.php'); exit; }
$stmt = $pdo->prepare("SELECT h.*, t.nazev AS tym_nazev, t.vekova_kategorie FROM hraci h LEFT JOIN tymy t ON h.tym_id = t.id WHERE h.id = ?");
$stmt->execute([$id]);
$hrac = $stmt->fetch();
if (!$hrac) { header('Location: index.php'); exit; }
