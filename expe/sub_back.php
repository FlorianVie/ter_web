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

insertRepSub($bdd, $_POST['id_sujet'], 1, $_POST['s1']);
insertRepSub($bdd, $_POST['id_sujet'], 2, $_POST['s2']);
insertRepSub($bdd, $_POST['id_sujet'], 3, $_POST['s3']);
insertRepSub($bdd, $_POST['id_sujet'], 4, $_POST['s4']);
insertRepSub($bdd, $_POST['id_sujet'], 5, $_POST['s5']);
insertRepSub($bdd, $_POST['id_sujet'], 6, $_POST['s6']);

?>