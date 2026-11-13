<?php
if ($email && !filter_var($email, FILTER_VALIDATE_EMAIL)) { $chyby[] = 'Špatný email'; }
