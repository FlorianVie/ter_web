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
    $subject = getSubject($bdd, $_GET['id']);
    $back2 = getBack_2_subject($bdd, $_GET['id']);
    $back2fa = getBack_2_subject_fa($bdd, $_GET['id']);
    $back2JSON = json_encode($back2);
    $timeouts = getTimeout($bdd, $_GET['id']);
    $motiv = getMotiv($bdd, $_GET['id']);
    $compRep = getCompRep($bdd, $_GET['id']);
    $compTotal = 0;
    ?>

    <title>TER - Participant <?php echo $subject[0] ?></title>
</head>


<script>
    var back2 = <?php echo $back2JSON ?>;
    console.log(back2);
</script>

<body>
<section class="hero is-light is-fullheight">
    <div class="hero-body">
        <div class="container">
            <h1 class="title has-text-centered">
                Participant <?php echo $subject[0] ?>
            </h1>
            <div class="columns is-centered">
                <div class="column is-half">
                    <h2 class="subtitle">Entrainements</h2>
                    <table class="table is-half is-striped has-shadow">
                        <thead>
                        <tr>
                            <th>Tâche</th>
                            <th>Lien</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>0-Back</td>
                            <td>
                                <a href="expe/0-back-training.php?id=<?php echo $subject[0] ?>">http://ter.bigfive.890m.com/expe/0-back-training.php?id=<?php echo $subject[0] ?></a>
                            </td>
                        </tr>
                        <tr>
                            <td>1-Back</td>
                            <td>
                                <a href="expe/1-back-training.php?id=<?php echo $subject[0] ?>">http://ter.bigfive.890m.com/expe/1-back-training.php?id=<?php echo $subject[0] ?></a>
                            </td>
                        </tr>
                        <tr>
                            <td>2-Back</td>
                            <td>
                                <a href="expe/2-back-training.php?id=<?php echo $subject[0] ?>">http://ter.bigfive.890m.com/expe/2-back-training.php?id=<?php echo $subject[0] ?></a>
                            </td>
                        </tr>
                        <tr>
                            <td>RSPAN</td>
                            <td>
                                <a href="expe/rspan.php?id=<?php echo $subject[0] ?>">http://ter.bigfive.890m.com/expe/rspan.php?id=<?php echo $subject[0] ?></a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
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
                                Transcription n-back
                            </td>
                            <td>
                                <a href="expe/transcription-nback.php?id=<?php echo $subject[0] ?>">http://ter.bigfive.890m.com/expe/transcription-nback.php?id=<?php echo $subject[0] ?></a>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Transcription RSPAN
                            </td>
                            <td>
                                <a href="expe/transcription-rspan.php?id=<?php echo $subject[0] ?>">http://ter.bigfive.890m.com/expe/transcription-rspan.php?id=<?php echo $subject[0] ?></a>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Contrôle n-back
                            </td>
                            <td>
                                <a href="expe/controle-nback.php?id=<?php echo $subject[0] ?>">http://ter.bigfive.890m.com/expe/controle-nback.php?id=<?php echo $subject[0] ?></a>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Contrôle RSPAN
                            </td>
                            <td>
                                <a href="expe/controle-rspan.php?id=<?php echo $subject[0] ?>">http://ter.bigfive.890m.com/expe/controle-rspan.php?id=<?php echo $subject[0] ?></a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="columns">
                <div class="column is-half">
                    <h2 class="subtitle">2-Back</h2>
                    <canvas id="back2" height="200"></canvas>
                </div>
                <div class="column is-half">
                    <h2 class="subtitle">RSPAN Timeout</h2>
                    <canvas id="rspan" height="200"></canvas>
                </div>
            </div>

            <div class="columns">
                <div class="column is-half">
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
                                <a href="expe/comprehension.php?id=<?php echo $subject[0] ?>">http://ter.bigfive.890m.com/expe/comprehension.php?id=<?php echo $subject[0] ?></a>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Motivation
                            </td>
                            <td>
                                <a href="expe/subjective.php?id=<?php echo $subject[0] ?>">http://ter.bigfive.890m.com/expe/subjective.php?id=<?php echo $subject[0] ?></a>
                            </td>
                        </tr>
                        </tbody>
                    </table>

                    <h2 class="subtitle">Motivation</h2>
                    <canvas id="motiv" height="200"></canvas>
                </div>
                <div class="column is-half">
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
                            <th colspan="3">Total (sur 16 points)</th>
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

<script>
    var ctx = document.getElementById('back2').getContext('2d');
    var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: [<?php for ($i = 0; $i < count($back2); $i++) {
                    echo $back2[$i]['id_2_back'] + 1 . ', ';
                } ?>],
                datasets: [{
                    label: 'Score 2-Back',
                    data: [<?php for ($i = 0; $i < count($back2); $i++) {
                        echo $back2[$i]['target_correct'] - $back2fa[$i]['false_alarm'] . ', ';
                    } ?>],
                    borderColor: 'rgba(168, 32, 26, 1)',
                    borderWidth: 2
                }
                ]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                            max: 1
                        }
                    }]
                }
            }
        })
    ;

    var ctxRSPAN = document.getElementById('rspan').getContext('2d');
    var myChartRSPAN = new Chart(ctxRSPAN, {
            type: 'bar',
            data: {
                labels: [<?php for ($i = 0; $i < count($timeouts); $i++) {
                    echo $i + 1 . ', ';
                } ?>],
                datasets: [{
                    label: 'Timeout',
                    data: [<?php for ($i = 0; $i < count($timeouts); $i++) {
                        echo $timeouts[$i]['timeout_var'] . ', ';
                    } ?>],
                    borderColor: 'rgba(241, 194, 50, 1)',
                    borderWidth: 2
                }
                ]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                            //max: 1
                        }
                    }]
                }
            }
        })
    ;

    var ctxMotiv = document.getElementById('motiv').getContext('2d');
    var myChartMotiv = new Chart(ctxMotiv, {
            type: 'radar',
            data: {
                labels: ["Pré-motivation", "Mem. difficulté", "Transc. difficulté", "Questions difficulté", "Fatigue", "Recommencer"],
                datasets: [{
                    label: 'Réponses',
                    data: [<?php for ($i = 0; $i < count($motiv); $i++) {
                        echo $motiv[$i]['reponse_sub_sujet'] . ', ';
                    } ?>],
                    borderColor: 'rgba(80, 125, 188, 1)',
                    borderWidth: 2
                }
                ]
            },
            options: {
                scales: {
                    yAxes: [{
                        gridLines: {
                            display: false
                        },
                        ticks: {
                            display: false
                        }
                    }]
                }
            }
        })
    ;
</script>

</html>