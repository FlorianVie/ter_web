<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="bulma/css/bulma.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"></script>
    <title>TER</title>
</head>

<?php
include 'fonctions.php';
$bdd = getBD();
$subject = getSubject($bdd, $_GET['id']);
$back2 = getBack_2_subject($bdd, $_GET['id']);
$back2fa = getBack_2_subject_fa($bdd, $_GET['id']);
$back2JSON = json_encode($back2);
?>

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
                <div class="column is-narrow">
                    <h2 class="subtitle">Entrainements</h2>
                    <table class="table is-half is-striped has-shadow is-bordered">
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

                    <h2 class="subtitle">Tâche principale</h2>
                    <table class="table is-half is-striped has-shadow is-bordered">
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

                    <h2 class="subtitle">Questionnaires</h2>
                    <table class="table is-half is-striped has-shadow is-bordered">
                        <thead>
                        <tr>
                            <th>Groupe</th>
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
                                Subjective
                            </td>
                            <td>

                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="column is-half">
                    <canvas id="back2" height="200"></canvas>
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
                    echo $back2[$i]['id_2_back'] . ', ';
                } ?>],
                datasets: [{
                    label: 'Score 2-Back',
                    data: [<?php for ($i = 0; $i < count($back2); $i++) {
                        echo $back2[$i]['target_correct'] - $back2fa[$i]['false_alarm'] . ', ';
                    } ?>],
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
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
</script>

</html>