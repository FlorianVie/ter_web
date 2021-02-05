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

                            <?php
                            for ($i = 0; $i < count($questions); $i++) {
                                ?>
                                <tr>
                                    <td>
                                        <?php echo $questions[$i]['id_question'] ?>
                                    </td>
                                    <td style="font-family: 'Lato', 'Open Sans', 'Arial', sans-serif">
                                        <?php echo $questions[$i]['question'] ?>
                                    </td>
                                    <td>
                                        <div class="select">
                                            <select required
                                                    name="<?php echo "q_" . strval($questions[$i]['id_question']); ?>">
                                                <option value="" selected disabled hidden>---</option>
                                                <option value="Vrai">Vrai</option>
                                                <option value="Faux">Faux</option>
                                            </select>
                                        </div>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
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