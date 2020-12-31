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
    <script src="plugins/button-response-grid.js"></script>
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

?>

<script>
    // timeline creation
    var timeline = [];

    var recall = {
        type: 'button-response-grid',
        stimulus: 'TEST',
        choices: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12'],
        margin_vertical: '20px',
        margin_horizontal: '20px',
    }
    timeline.push(recall);

    jsPsych.init({
        timeline: timeline,
        on_finish: function () {
            jsPsych.data.displayData();
        }
    })

</script>

</html>