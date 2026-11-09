<?php
require_once __DIR__ . '/db.php';
$id = (int)($_GET['id'] ?? 0);
if ($id <= 0) { header('Location: index.php'); exit; }
$stmt = $pdo->prepare("SELECT * FROM hraci WHERE id = ?");
$stmt->execute([$id]);
$hrac = $stmt->fetch();
if (!$hrac) { header('Location: index.php'); exit; }
