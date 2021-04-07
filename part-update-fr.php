<?php
include 'fonctions.php';
$bdd = getBD();

updatePartFR($bdd, $_POST['id'], $_POST['frap'], $_POST['age'], $_POST['sexe'], $_POST['groupe']);

header('Location: participant-fr.php?id=' . $_POST['id']);