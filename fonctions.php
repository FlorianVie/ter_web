<?php
include 'bd.php';

function getSentences($bdd)
{
    $req = $bdd->prepare("SELECT * FROM sentences");
    $req->execute();
    $sentences = $req->fetchAll();
    $req->closeCursor();
    return $sentences;
}

function getSentencesPrac($bdd)
{
    $req = $bdd->prepare("SELECT * FROM practice");
    $req->execute();
    $sentences = $req->fetchAll();
    $req->closeCursor();
    return $sentences;
}

function getLetters($bdd)
{
    $req = $bdd->prepare("SELECT letter FROM letters");
    $req->execute();
    $letters = $req->fetchAll();
    $req->closeCursor();
    return $letters;
}