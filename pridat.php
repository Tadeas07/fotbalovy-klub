<?php
$stmt = $pdo->prepare("INSERT INTO hraci (jmeno, prijmeni, datum_narozeni, pozice, tym_id, telefon_rodice, email_rodice, aktivni) VALUES (?, ?, ?, ?, ?, ?, ?, 1)");
