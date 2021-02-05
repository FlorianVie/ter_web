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

insertRepComp($bdd, strval($post['id_sujet']), '1', $post['q_1']);
insertRepComp($bdd, strval($post['id_sujet']), '2', $post['q_2']);
insertRepComp($bdd, strval($post['id_sujet']), '3', $post['q_3']);
insertRepComp($bdd, strval($post['id_sujet']), '4', $post['q_4']);
insertRepComp($bdd, strval($post['id_sujet']), '5', $post['q_5']);
insertRepComp($bdd, strval($post['id_sujet']), '6', $post['q_6']);
insertRepComp($bdd, strval($post['id_sujet']), '7', $post['q_7']);
insertRepComp($bdd, strval($post['id_sujet']), '8', $post['q_8']);
insertRepComp($bdd, strval($post['id_sujet']), '9', $post['q_9']);
insertRepComp($bdd, strval($post['id_sujet']), '10', $post['q_10']);
insertRepComp($bdd, strval($post['id_sujet']), '11', $post['q_11']);
insertRepComp($bdd, strval($post['id_sujet']), '12', $post['q_12']);
insertRepComp($bdd, strval($post['id_sujet']), '13', $post['q_13']);
insertRepComp($bdd, strval($post['id_sujet']), '14', $post['q_14']);
insertRepComp($bdd, strval($post['id_sujet']), '15', $post['q_15']);
insertRepComp($bdd, strval($post['id_sujet']), '16', $post['q_16']);
?>