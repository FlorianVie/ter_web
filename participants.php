<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="bulma/css/bulma.css">
    <title>TER</title>
</head>

<?php
include 'fonctions.php';
$bdd = getBD();
$subjects = getAllSubjects($bdd);
?>

<body>
<section class="hero is-dark is-fullheight">
    <div class="hero-body">
        <div class="container has-text-centered">
            <h1 class="title">
                Participants
            </h1>
            <div class="columns is-centered">
                <div class="column is-narrow ">
                    <table class="table is-striped is-hoverable">
                        <thead>
                        <tr>
                            <th>ID Participant</th>
                            <th>Compteur 1-Back</th>
                            <th>Compteur 2-Back</th>
                            <th>Oxford</th>
                            <th>Vitesse frappe</th>
                            <th>Age</th>
                            <th>Sexe</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        for ($i = 0; $i < count($subjects); $i++) {
                            ?>
                            <tr>
                                <td><?php echo $subjects[$i][0] ?></td>
                                <td><?php echo $subjects[$i][1] ?></td>
                                <td><?php echo $subjects[$i][2] ?></td>
                                <td><?php echo $subjects[$i][3] ?></td>
                                <td><?php echo $subjects[$i][4] ?></td>
                                <td><?php echo $subjects[$i][5] ?></td>
                                <td><?php echo $subjects[$i][6] ?></td>
                                <td><a href="participant.php?id=<?php echo $subjects[$i][0] ?>"><button class="button">Gérer</button></a></td>
                            </tr>
                            <?php
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="columns">
                <div class="column">
                    <a href="n-part.php"><button class="button">Nouveau participant</button></a>
                </div>
            </div>
        </div>
    </div>
</section>
</body>
</html>