<?php
include 'fonctions.php';
$bdd = getBD();

updatePart($bdd, $_POST['id'], $_POST['angl'], $_POST['frap'], $_POST['age'], $_POST['sexe'], $_POST['groupe']);

header('Location: participant.php?id=' . $_POST['id']);