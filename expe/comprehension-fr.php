<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../bulma/css/bulma.css">
    <link rel="stylesheet" href="css/custom.css">
    <link rel="icon" type="image/svg+xml" href="../assets/thinking.svg">
    <title>Compréhension</title>
</head>

<?php
include '../fonctions.php';
$bdd = getBD();
$subject = getSubjectFR($bdd, $_GET['id']);
$questions = getComprehensionFR($bdd);
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

            <form action="comp-back-fr.php" method="post">
                <input type="hidden" name="id_sujet" value="<?php echo $subject['id_subject'] ?>">
                <div class="columns is-centered">
                    <div class="column is-narrow">
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
                                    De combien de moments en moyenne est constituée une vie ?
                                </td>
                                <td>
                                    <div class="select">
                                        <select required
                                                name="q1">
                                            <option value="" selected disabled hidden>---</option>
                                            <option value="500 000">500 000</option>
                                            <option value="200 000 000">200 000 000</option>
                                            <option value="500 000 000">500 000 000</option>
                                        </select>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    2
                                </td>
                                <td style="font-family: 'Lato', 'Open Sans', 'Arial', sans-serif">
                                    L'une des clefs du bonheur est d'enfouir en soi les problèmes que l'on rencontre.
                                </td>
                                <td>
                                    <div class="select">
                                        <select required
                                                name="q2">
                                            <option value="" selected disabled hidden>---</option>
                                            <option value="Vrai">Vrai</option>
                                            <option value="Faux">Faux</option>
                                        </select>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    3
                                </td>
                                <td style="font-family: 'Lato', 'Open Sans', 'Arial', sans-serif">
                                    Jonathan en tant qu'avocat était :
                                </td>
                                <td>
                                    <div class="select">
                                        <select required
                                                name="q3">
                                            <option value="" selected disabled hidden>---</option>
                                            <option value="Heureux">Heureux</option>
                                            <option value="Pauvre">Pauvre</option>
                                            <option value="Malheureux">Malheureux</option>
                                        </select>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    4
                                </td>
                                <td style="font-family: 'Lato', 'Open Sans', 'Arial', sans-serif">
                                    La méditation rend plus heureux et plus intelligent.
                                </td>
                                <td>
                                    <div class="select">
                                        <select required
                                                name="q4">
                                            <option value="" selected disabled hidden>---</option>
                                            <option value="Vrai">Vrai</option>
                                            <option value="Faux">Faux</option>
                                        </select>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    5
                                </td>
                                <td style="font-family: 'Lato', 'Open Sans', 'Arial', sans-serif">
                                    Le bonheur se situe principalement :
                                </td>
                                <td>
                                    <div class="select">
                                        <select required
                                                name="q5">
                                            <option value="" selected disabled hidden>---</option>
                                            <option value="En nous même">En nous même</option>
                                            <option value="Dans les relations avec autrui">Dans les relations avec
                                                autrui
                                            </option>
                                            <option value="Dans notre épanouissement professionnel">Dans notre
                                                épanouissement professionnel
                                            </option>
                                        </select>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    6
                                </td>
                                <td style="font-family: 'Lato', 'Open Sans', 'Arial', sans-serif">
                                    Nous avons la capacité de changer nos états mentaux émotionnels.
                                </td>
                                <td>
                                    <div class="select">
                                        <select required
                                                name="q6">
                                            <option value="" selected disabled hidden>---</option>
                                            <option value="Vrai">Vrai</option>
                                            <option value="Faux">Faux</option>
                                        </select>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    7
                                </td>
                                <td style="font-family: 'Lato', 'Open Sans', 'Arial', sans-serif">
                                    Lequel de ces termes a été employé au cours de la conférence :
                                </td>
                                <td>
                                    <div class="select">
                                        <select required
                                                name="q7">
                                            <option value="" selected disabled hidden>---</option>
                                            <option value="éliminer la tyrannie du mental">Éliminer la tyrannie du
                                                mental
                                            </option>
                                            <option value="Sortir les poubelles mentales">Sortir les poubelles mentales
                                            </option>
                                            <option value="faire entrer le bonheur">Faire entrer le bonheur
                                            </option>
                                        </select>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    8
                                </td>
                                <td style="font-family: 'Lato', 'Open Sans', 'Arial', sans-serif">
                                    Lors de sa conférence Jonathan a évoqué le clonage des animaux.
                                </td>
                                <td>
                                    <div class="select">
                                        <select required
                                                name="q8">
                                            <option value="" selected disabled hidden>---</option>
                                            <option value="Vrai">Vrai</option>
                                            <option value="Faux">Faux</option>
                                        </select>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    9
                                </td>
                                <td style="font-family: 'Lato', 'Open Sans', 'Arial', sans-serif">
                                    Quelle affirmation semble la plus juste :
                                </td>
                                <td>
                                    <div class="select">
                                        <select required
                                                name="q9">
                                            <option value="" selected disabled hidden>---</option>
                                            <option value="il faut beaucoup d'efforts pour changer les choses">Il faut
                                                beaucoup d'efforts pour changer les choses
                                            </option>
                                            <option value="Les petites choses peuvent produire de grands changements">
                                                Les petites choses peuvent produire de grands changements
                                            </option>
                                        </select>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    10
                                </td>
                                <td style="font-family: 'Lato', 'Open Sans', 'Arial', sans-serif">
                                    Le deuxième aspect de la tyrannie du mental est que le mental est négatif.
                                </td>
                                <td>
                                    <div class="select">
                                        <select required
                                                name="q10">
                                            <option value="" selected disabled hidden>---</option>
                                            <option value="Vrai">Vrai</option>
                                            <option value="Faux">Faux</option>
                                        </select>
                                    </div>
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