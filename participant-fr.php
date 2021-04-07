<!--TODO Questionnaire de comprehension-->
<!--TODO Questionnaire de motivation-->
<!--TODO Panneau de resultats-->
<!--TODO Modificateur du temps de pause-->

<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="bulma/css/bulma.css">
    <link rel="icon" type="image/svg+xml" href="/assets/thinking.svg">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"></script>

    <?php
    include 'fonctions.php';
    $bdd = getBD();
    $subject = getSubjectFR($bdd, $_GET['id']);
    $motiv = getMotiv($bdd, $_GET['id']);
    $compRep = getCompRepFR($bdd, $_GET['id']);
    $compTotal = 0;
    ?>

    <title>TER - Participant <?php echo $subject[0] ?></title>
</head>

<body>
<section class="hero is-light is-fullheight">
    <div class="hero-body">
        <div class="container">
            <h1 class="title has-text-centered">
                Participant <?php echo $subject[0] ?>
            </h1>
            <div class="columns is-centered">
                <div class="column is-half">
                    <h2 class="subtitle">Tâche principale</h2>
                    <table class="table is-half is-striped has-shadow">
                        <thead>
                        <tr>
                            <th>Groupe</th>
                            <th>Lien</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>
                                Vitesse de frappe
                            </td>
                            <td>
                                <a href=""></a>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Groupe Adaptation
                            </td>
                            <td>
                                <a href="expe/transcription-fr.php?id=<?php echo $subject[0] ?>">http://ter.bigfive.890m.com/expe/transcription-fr.php?id=<?php echo $subject[0] ?></a>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Groupe Contrôle
                            </td>
                            <td>
                                <a href="expe/controle-fr.php?id=<?php echo $subject[0] ?>">http://ter.bigfive.890m.com/expe/controle-fr.php?id=<?php echo $subject[0] ?></a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>

                <div class="column is-one-half">
                    <h2 class="subtitle">Questionnaires</h2>
                    <table class="table is-half is-striped has-shadow">
                        <thead>
                        <tr>
                            <th>Questionnaire</th>
                            <th>Lien</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>
                                Compréhension
                            </td>
                            <td>
                                <a href="expe/comprehension-fr.php?id=<?php echo $subject[0] ?>">http://ter.bigfive.890m.com/expe/comprehension-fr.php?id=<?php echo $subject[0] ?></a>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Motivation
                            </td>
                            <td>
                                <a href="expe/subjective-fr.php?id=<?php echo $subject[0] ?>">http://ter.bigfive.890m.com/expe/subjective-fr.php?id=<?php echo $subject[0] ?></a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!--<div class="columns">
                <div class="column is-half">
                    <h2 class="subtitle">2-Back</h2>
                    <canvas id="back2" height="200"></canvas>
                </div>
                <div class="column is-half">
                    <h2 class="subtitle">RSPAN Timeout</h2>
                    <canvas id="rspan" height="200"></canvas>
                </div>
            </div>-->

            <div class="columns">
                <div class="column is-one-third">
                    <h2 class="subtitle">Données complémentaires</h2>
                    <form action="part-update-fr.php" method="post" style="margin-bottom: 40px">
                        <table class="table is-half is-striped has-shadow">
                            <thead>
                            <tr>
                                <th>Données</th>
                                <th>Valeurs</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>
                                    Identifiant
                                </td>
                                <td>
                                    <?php echo $subject[0] ?>
                                    <input name="id" class="input" type="hidden" value="<?php echo $subject[0] ?>">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Frappe
                                </td>
                                <td>
                                    <input name="frap" class="input" type="number" value="<?php echo $subject[1] ?>">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Age
                                </td>
                                <td>
                                    <input name="age" class="input" type="number" value="<?php echo $subject[2] ?>">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Sexe
                                </td>
                                <td>
                                    <input name="sexe" class="input" type="text" value="<?php echo $subject[3] ?>">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Groupe
                                </td>
                                <td>
                                    <div class="select">
                                        <select name="groupe" id="grp">
                                            <option value="Adaptation">Adaptation</option>
                                            <option value="Controle">Controle</option>
                                        </select>
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <button type="submit" class="button is-primary">Modifier</button>
                    </form>
                </div>

                <div class="column is-one-third">
                    <h2 class="subtitle">Motivation</h2>
                    <canvas id="motiv" height="200"></canvas>
                </div>

                <div class="column is-one-third">
                    <h2 class="subtitle">Compréhension</h2>
                    <table class="table is-half is-striped has-shadow">
                        <thead>
                        <tr>
                            <th>N°</th>
                            <th>Question</th>
                            <th>Réponse</th>
                            <th>Points</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php for ($i = 0; $i < count($compRep); $i++) {
                            ?>
                            <tr>
                                <td>
                                    <?php echo $compRep[$i]['id_question']; ?>
                                </td>
                                <td>
                                    <?php echo $compRep[$i]['question']; ?>
                                </td>
                                <td>
                                    <?php echo $compRep[$i]['reponse_sujet']; ?>
                                </td>
                                <td>
                                    <?php
                                    if ($compRep[$i]['reponse_sujet'] == $compRep[$i]['reponse']) {
                                        echo 1;
                                        $compTotal += 1;
                                    } else {
                                        echo 0;
                                        $compTotal += 0;
                                    }
                                    ?>
                                </td>
                            </tr>
                            <?php
                        } ?>
                        </tbody>
                        <tfoot>
                        <tr>
                            <th colspan="3">Total (sur 10 points)</th>
                            <th><?php echo $compTotal; ?></th>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
</body>

</html>