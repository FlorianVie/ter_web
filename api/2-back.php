<?php
include '../fonctions.php';
$bdd = getBD();
$raw = getBack_2_raw($bdd);
$jsonData = json_encode($raw);

header('Content-Type: application/json');
echo $jsonData;