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
                        Questions de compréhension
                    </h1>
                    <h2 class="subtitle">
                        ID : <?php echo $subject['id_subject'] ?>
                    </h2>
                </div>
            </div>

            <form action="comp-back.php" method="post">
                <input type="hidden" name="id_sujet" value="<?php echo $subject['id_subject'] ?>">
                <div class="columns is-centered">
                    <div class="column is-6">
                        <table class="table is-striped has-shadow">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Questions</th>
                                <th>Réponses</th>
                            </tr>
                            </thead>
                            <tbody style="font-family: 'Lato', 'Open Sans', 'Arial', sans-serif">
                            <tr>
                                <td>
                                    1
                                </td>
                                <td style="font-family: 'Lato', 'Open Sans', 'Arial', sans-serif">
                                    Avant de commencer cette étude, vous sentiez-vous motivé(e) pour y participer ?
                                </td>
                                <td>
                                    <input type="range" min="0" max="100" list="tickmarks">
                                    <datalist id="tickmarks">
                                        <option value="0" label="Non, pas motivé(e) du tout">
                                        <option value="100" label="Oui, tout à fait motivé(e)">
                                    </datalist>
                                </td>
                            </tr>
                            </tbody>
                        </table>

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