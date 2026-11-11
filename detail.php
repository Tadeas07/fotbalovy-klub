<?php
// Dotaz na spoluhráče
$stmt = $pdo->prepare("SELECT * FROM hraci WHERE tym_id = ? AND id != ? AND aktivni = 1 ORDER BY prijmeni");
