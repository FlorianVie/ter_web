<?php
include '../fonctions.php';
$bdd = getBD();
$raw = getBack2_results($bdd);
$jsonData = json_encode($raw);

header('Content-Type: application/json');
echo $jsonData;