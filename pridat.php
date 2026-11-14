<?php
// Kontrola ročníku dle FAČR
if ($rok < $rok_od || $rok > $rok_do) { $chyby[] = 'Špatná věková kategorie'; }
