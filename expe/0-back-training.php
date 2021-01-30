<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>0-back entrainement</title>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono&family=Lato&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/jspsych.css">
    <link rel="stylesheet" href="css/custom.css">
    <script src="jspsych.js"></script>
    <script src="plugins/jspsych-instructions.js"></script>
    <script src="plugins/jspsych-html-keyboard-response.js"></script>
</head>

<script>
    function saveData() {
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'write_data_0back.php'); // change 'write_data.php' to point to php script.
        xhr.setRequestHeader('Content-Type', 'application/json');
        xhr.onload = function () {
            if (xhr.status == 200) {
                var response = JSON.parse(xhr.responseText);
                console.log(response.success);
            }
        };
        xhr.send(jsPsych.data.get().json());
    }
</script>

<body></body>

<?php
include '../fonctions.php';
$bdd = getBD();
$stim = ['B', 'C', 'D', 'F', 'G', 'H', 'J', 'K', 'L', 'M', 'N', 'P', 'Q', 'R', 'S', 'T', 'V', 'W', 'X', 'Z'];
$target = $stim;
shuffle($target);
$target_0 = 'M';
$back_0 = ['T', 'H', 'M', 'C', 'G', 'M', 'D', 'P', 'M', 'Z', 'B', 'S', 'F', 'J', 'K', 'M', 'V', 'X', 'W', 'M', 'C', 'B', 'M', 'L', 'F', 'M', 'C', 'M', 'J', 'M', 'H', 'Z', 'M', 'V', 'X', 'K', 'M', 'N', 'M', 'G', 'F', 'B'];
#$back_0 = ['T', 'H', 'M', 'C', 'G', 'M', 'D'];

$id_sujet = $_GET['id'];

?>

<script>

    var back_0 = ['T', 'H', 'M', 'C', 'G', 'M', 'D', 'P', 'M', 'Z', 'B', 'S', 'F', 'J', 'K', 'M', 'V', 'X', 'W', 'M',
        'C', 'B', 'M', 'L', 'F', 'M', 'C', 'M', 'J', 'M', 'H', 'Z', 'M', 'V', 'X', 'K', 'M', 'N', 'M', 'G', 'F', 'B'];

    var timeline = [];

    var subject_id = '<?php echo $id_sujet ?>';
    jsPsych.data.addProperties({
        subject: subject_id,
    });

    var welcome = {
        type: 'instructions',
        pages: ["<h1>Entrainement 0-Back</h1>",
            "<p>Dans cette tâche, une séquence de lettres s'affichera en continu.</p>" +
            "<p>Appuyez sur la barre espace si la lettre affichée est la lettre <strong><span class='mono' style='font-size: 1.3em'>M</span></strong>.</p>",
            "<p style='font-size: 1.3em'>Exemple : <span class='mono' >R, T, F, <strong>M</strong>, H</span> </p>" +
            "<p>Ici, il faut appuyer sur la barre espace à chaque fois que la lettre <span class='mono' >M</span> s'affiche.</p>" +
            "<p>Vous avez le temps d'appuyer sur la barre espace jusqu'à l'apparition de la lettre suivante, même si la dernière présentée disparait.</p>",
            "<p>Appuyez sur 'Suivant' pour commencer ...</p>"],
        show_clickable_nav: true,
        data: {
            part: "instruction",
        }
    }
    timeline.push(welcome);

    var prepause = {
        type: 'html-keyboard-response',
        stimulus: '',
        trial_duration: 1000,
        choices: [],
        response_ends_trial: false,
        data: {
            part: "Pause"
        }
    }
    timeline.push(prepause);

    <?php
    for ($i = 0; $i < count($back_0); $i++) {
    ?>
    var trial = {
        type: 'html-keyboard-response',
        stimulus: "<h1 class='mono'><?php echo $back_0[$i] ?></h1>",
        stimulus_duration: 500,
        trial_duration: 2000,
        choices: [32],
        response_ends_trial: false,
        data: {
            letter: "<?php echo $back_0[$i] ?>",
            trial_id: "<?php echo $i ?>"
        },
        on_finish: function (data) {
            if (data.key_press === 32 && data.letter === 'M') {
                data.correct = 1;
                data.is_target = 1;
            } else {
                data.correct = 0;
                data.is_target = 0;
            }
            if (data.key_press !== 32 && data.letter !== 'M') {
                data.correct = 1;
                data.is_target = 0;
            }
        }
    }
    timeline.push(trial);
    <?php
    }
    ?>

    var feedback = {
        type: 'html-keyboard-response',
        choices: [32],
        stimulus: function () {
            var moy = jsPsych.data.get().select('correct').mean();
            var pourc = Math.round(moy * 100);
            return '<h1>Fin</h1><h2>Score : ' + pourc + '%</h2><p>Appuyez sur la touche espace pour envoyer vos résultats.</p>';
        },
        data: {
            part: "feedback",
        },
    }
    timeline.push(feedback);

    jsPsych.init({
        timeline: timeline,
        on_finish: saveData
        /*on_finish: function () {
            jsPsych.data.displayData('csv');
        }*/
    })


</script>

</html>