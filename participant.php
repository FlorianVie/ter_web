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
$subject = getSubject($bdd, $_GET['id']);
?>

<body>
<section class="hero is-dark is-fullheight">
    <div class="hero-body">
        <div class="container">
            <h1 class="title has-text-centered">
                Participant <?php echo $subject[0] ?>
            </h1>

            <div class="columns is-centered">
                <div class="column is-narrow">
                    <table class="table is-hoverable is-striped">
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
                                <a href="http://ter.bigfive.890m.com/expe/0-back-training.php?id=<?php echo $subject[0] ?>">http://ter.bigfive.890m.com/expe/0-back-training.php?id=<?php echo $subject[0] ?></a>
                            </td>
                        </tr>
                        <tr>
                            <td>1-Back</td>
                            <td>
                                <a href="http://ter.bigfive.890m.com/expe/1-back-training.php?id=<?php echo $subject[0] ?>">http://ter.bigfive.890m.com/expe/1-back-training.php?id=<?php echo $subject[0] ?></a>
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