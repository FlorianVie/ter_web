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

<?php
include '../fonctions.php';
$bdd = getBD();
$subject = getSubject($bdd, $_GET['id']);
$questions = getComprehension($bdd);
?>

<body>
<section class="hero is-light is-fullheight">
    <div class="hero-body">
        <div class="container">
            <div class="columns has-text-centered">
                <div class="column">
                    <h1 class="title">
                        Questions de motivation
                    </h1>
                    <h2 class="subtitle">
                        ID : <?php echo $subject['id_subject'] ?>
                    </h2>
                </div>
            </div>

            <form action="sub_back.php" method="post">
                <input type="hidden" name="id_sujet" value="<?php echo $subject['id_subject'] ?>">

                <div class="columns is-centered" style="margin-top: 50px">
                    <div class="column is-8">
                        <p class="is-size-5">1. Avant de commencer cette étude, vous sentiez-vous motivé(e) pour y
                            participer ?</p>
                        <div class="columns" style="margin-top: 10px">
                            <div class="column">
                                <p style="text-align: right">Non, pas motivé(e) du tout</p>
                            </div>
                            <div class="column">
                                <p><input name="s1" style="width: 100%" type="range" min="0" max="100"></p>
                            </div>
                            <div class="column">
                                <p>Oui, tout à fait motivé(e)</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="columns is-centered" style="margin-top: 50px">
                    <div class="column is-8">
                        <p class="is-size-5">2.	Est-ce que la tâche de mémoire était difficile pour vous ? </p>
                        <div class="columns" style="margin-top: 10px">
                            <div class="column">
                                <p style="text-align: right">Non, très facile</p>
                            </div>
                            <div class="column">
                                <p><input name="s2" style="width: 100%" type="range" min="0" max="100"></p>
                            </div>
                            <div class="column">
                                <p>Oui, très difficile</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="columns is-centered" style="margin-top: 50px">
                    <div class="column is-8">
                        <p class="is-size-5">3.	Est-ce que la tâche de transcription était difficile pour vous ?</p>
                        <div class="columns" style="margin-top: 10px">
                            <div class="column">
                                <p style="text-align: right">Non, très facile</p>
                            </div>
                            <div class="column">
                                <p><input name="s3" style="width: 100%" type="range" min="0" max="100"></p>
                            </div>
                            <div class="column">
                                <p>Oui, très difficile</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="columns is-centered" style="margin-top: 50px">
                    <div class="column is-8">
                        <p class="is-size-5">4.	Est-ce que répondre aux questions était difficile pour vous ?</p>
                        <div class="columns" style="margin-top: 10px">
                            <div class="column">
                                <p style="text-align: right">Non, très facile</p>
                            </div>
                            <div class="column">
                                <p><input name="s4" style="width: 100%" type="range" min="0" max="100"></p>
                            </div>
                            <div class="column">
                                <p>Oui, très difficile</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="columns is-centered" style="margin-top: 50px">
                    <div class="column is-8">
                        <p class="is-size-5">5.	Vous sentez-vous fatigué(e) ?</p>
                        <div class="columns" style="margin-top: 10px">
                            <div class="column">
                                <p style="text-align: right">Non, pas du tout fatigué(e)</p>
                            </div>
                            <div class="column">
                                <p><input name="s5" style="width: 100%" type="range" min="0" max="100"></p>
                            </div>
                            <div class="column">
                                <p>Oui, très fatigué(e)</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="columns is-centered" style="margin-top: 50px">
                    <div class="column is-8">
                        <p class="is-size-5">6.	Seriez-vous prêt maintenant à effectuer une nouvelle tâche de transcription ? </p>
                        <div class="columns" style="margin-top: 10px">
                            <div class="column">
                                <p style="text-align: right">Non, pas du tout</p>
                            </div>
                            <div class="column">
                                <p><input name="s6" style="width: 100%" type="range" min="0" max="100"></p>
                            </div>
                            <div class="column">
                                <p>Oui, tout à fait</p>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="columns">
                    <div class="column">
                        <div class="has-text-centered">
                            <button type="submit" class="button">Envoyer</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
</body>
</html>