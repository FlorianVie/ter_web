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

$f_back2 = fopen("2-back.csv", "w");
fputcsv($f_back2, $headers);
foreach ($back2 as $line){
    fputcsv($f_back2, $line);
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
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Type</th>
                            <th>Téléchargement</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>
                                2-back
                            </td>
                            <td>
                                <a href="2-back.csv">Télécharger</a>
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