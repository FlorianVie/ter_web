<?php
include 'fonctions.php';
$bdd = getBD();
insertSubject($bdd);
header('Location: participants.php');