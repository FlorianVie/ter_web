<?php
include 'fonctions.php';
$bdd = getBD();
insertSubjectFR($bdd);
header('Location: participants-fr.php');