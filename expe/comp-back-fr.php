<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../bulma/css/bulma.css">
    <link rel="stylesheet" href="css/custom.css">
    <title>Compréhension</title>
</head>

<body>
<section class="hero is-light is-fullheight">
    <div class="hero-body">
        <div class="container">
            <div class="columns has-text-centered">
                <div class="column">
                    <h1 class="title">
                        Merci !
                    </h1>
                </div>
            </div>
        </div>
    </div>
</section>
</body>
</html>


<?php
include '../fonctions.php';
$bdd = getBD();
$post = $_POST;
#print_r($post);

insertRepCompFR($bdd, strval($post['id_sujet']), '1', $post['q1']);
insertRepCompFR($bdd, strval($post['id_sujet']), '2', $post['q2']);
insertRepCompFR($bdd, strval($post['id_sujet']), '3', $post['q3']);
insertRepCompFR($bdd, strval($post['id_sujet']), '4', $post['q4']);
insertRepCompFR($bdd, strval($post['id_sujet']), '5', $post['q5']);
insertRepCompFR($bdd, strval($post['id_sujet']), '6', $post['q6']);
insertRepCompFR($bdd, strval($post['id_sujet']), '7', $post['q7']);
insertRepCompFR($bdd, strval($post['id_sujet']), '8', $post['q8']);
insertRepCompFR($bdd, strval($post['id_sujet']), '9', $post['q9']);
insertRepCompFR($bdd, strval($post['id_sujet']), '10', $post['q10']);
?>