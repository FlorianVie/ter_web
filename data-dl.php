<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="bulma/css/bulma.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"></script>
    <title>TER - Données</title>
</head>

<?php
include 'fonctions.php';
$bdd = getBD();

$back2 = get2backData($bdd);
$headers = array_keys($back2[0]);
$f_back2 = fopen("data/CSV/2-back.csv", "w");
fputcsv($f_back2, $headers);
foreach ($back2 as $line) {
    fputcsv($f_back2, $line);
}

$t_back = getDataTexteBack($bdd);
$t_back_headers = array_keys($t_back[0]);
$f_t_back = fopen("data/CSV/texte-back.csv", "w");
fputcsv($f_t_back, $t_back_headers);
foreach ($t_back as $line) {
    fputcsv($f_t_back, $line);
}

$t_rspan = getDataTexteRspan($bdd);
$t_rspan_headers = array_keys($t_rspan[0]);
$f_t_rspan = fopen("data/CSV/rspan-texte.csv", "w");
fputcsv($f_t_rspan, $t_rspan_headers);
foreach ($t_rspan as $line) {
    fputcsv($f_t_rspan, $line);
}

$n_back = getDataMainBack($bdd);
$n_back_headers = array_keys($n_back[0]);
$f_n_back = fopen("data/CSV/nback-back.csv", "w");
fputcsv($f_n_back, $n_back_headers);
foreach ($n_back as $line) {
    fputcsv($f_n_back, $line);
}

$n_rspan = getDataMainRspan($bdd);
$n_rspan_headers = array_keys($n_rspan[0]);
$f_n_rspan = fopen("data/CSV/rspan-prepost.csv", "w");
fputcsv($f_n_rspan, $n_rspan_headers);
foreach ($n_rspan as $line) {
    fputcsv($f_n_rspan, $line);
}


?>

<body>
<section class="hero is-light is-fullheight">
    <div class="hero-body">
        <div class="container">
            <h1 class="title has-text-centered">
                Données
            </h1>
            <div class="columns is-centered">
                <div class="column is-narrow">
                    <table class="table is-striped">
                        <thead>
                        <tr>
                            <th>Groupe</th>
                            <th>Données</th>
                            <th>Téléchargement</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>
                                N-Back
                            </td>
                            <td>
                                Entrainement
                            </td>
                            <td>
                                <a href="data/CSV/2-back.csv">Télécharger</a>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                N-Back
                            </td>
                            <td>
                                Retranscription
                            </td>
                            <td>
                                <a href="data/CSV/texte-back.csv">Télécharger</a>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                N-Back
                            </td>
                            <td>
                                Pre-Post
                            </td>
                            <td>
                                <a href="data/CSV/nback-back.csv">Télécharger</a>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                RSPAN
                            </td>
                            <td>
                                Retranscription
                            </td>
                            <td>
                                <a href="data/CSV/rspan-texte.csv">Télécharger</a>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                RSPAN
                            </td>
                            <td>
                                Pre-Post
                            </td>
                            <td>
                                <a href="data/CSV/rspan-prepost.csv">Télécharger</a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
</body>

</html>