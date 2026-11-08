<?php
require_once __DIR__ . '/db.php';
$filtr = (int)($_GET['tym'] ?? 0);
$sql = "SELECT h.* FROM hraci h WHERE aktivni = 1";
if ($filtr > 0) { $sql .= " AND tym_id = ?"; }
