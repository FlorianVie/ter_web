<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reading Span - EN</title>
    <script src="jspsych.js"></script>
    <script src="plugins/jspsych-html-keyboard-response.js"></script>
    <script src="plugins/jspsych-html-button-response.js"></script>
    <script src="plugins/recall-plugin.js"></script>
    <link rel="stylesheet" href="css/jspsych.css">
</head>
<body></body>

<?php
include '../fonctions.php';
$bdd = getBD();

$sentences = getSentences($bdd);
$letters = array_column(getLetters($bdd), 'letter');

$tr_nb = 3;
shuffle($letters);
print_r($letters);


?>

<script>
    // timeline creation
    var timeline = [];

    // welcome message
    var welcome = {
        type: 'html-keyboard-response',
        stimulus: "<h1>Ecrire le message de bienvenue</h1> Appuyez sur une touche pour continuer.",
    }
    timeline.push(welcome);

    // instructions
    var instructions = {
        type: 'html-keyboard-response',
        stimulus: "Des instructions trop cools à lire !",
    }
    timeline.push(instructions);

    // training
    <?php
    for ($i = 0; $i < $tr_nb; $i++) {
    ?>
    var training_trial = {
        type: 'html-keyboard-response',
        stimulus: "<h1><?php echo $letters[$i] ?></h1>",
        trial_duration: 1000,
        choices: "",
    }
    timeline.push(training_trial);
    <?php
    }
    ?>

    var training_recall = {
        type: 'recall-letters',

    }
    timeline.push(training_recall)

    jsPsych.init({
        timeline: timeline,
        on_finish: function () {
            jsPsych.data.displayData();
        }
    })

</script>

</html>