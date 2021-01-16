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

function getPhrases($bdd)
{
    $req = $bdd->prepare("SELECT * FROM phrases");
    $req->execute();
    $sentences = $req->fetchAll();
    $req->closeCursor();
    return $sentences;
}

function getEntrainement($bdd)
{
    $req = $bdd->prepare("SELECT * FROM entrainement");
    $req->execute();
    $sentences = $req->fetchAll();
    $req->closeCursor();
    return $sentences;
}

function getSubject($bdd, $id)
{
    $req = $bdd->prepare("SELECT * FROM subjects WHERE subjects.id_subject = :id");
    $req->bindParam(':id', $id);
    $req->execute();
    $subject = $req->fetchAll();
    $req->closeCursor();
    return $subject[0];
}

function getBack_1($bdd, $id)
{
    $req = $bdd->prepare("SELECT * FROM 1_back WHERE id_1_back = :id");
    $req->bindParam(':id', $id);
    $req->execute();
    $trial = $req->fetchAll();
    $req->closeCursor();
    return $trial[0];
}

function upBack_1($bdd, $id)
{
    $req = $bdd->prepare("UPDATE subjects SET back_1_level = back_1_level + 1 WHERE id_subject = :id");
    $req->bindParam(':id', $id);
    $req->execute();
    $req->closeCursor();
}

function getAllSubjects($bdd)
{
    $req = $bdd->prepare("SELECT * FROM subjects");
    $req->execute();
    $subject = $req->fetchAll();
    $req->closeCursor();
    return $subject;
}

function insertSubject($bdd)
{
    $req = $bdd->prepare("INSERT INTO subjects VALUES ()");
    $req->execute();
    $req->closeCursor();
}