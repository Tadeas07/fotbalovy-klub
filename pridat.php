<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $jmeno = trim($_POST['jmeno'] ?? '');
}
