<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>2-back entrainement</title>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono&family=Lato&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/jspsych.css">
    <link rel="stylesheet" href="css/custom.css">
    <script src="jspsych.js"></script>
    <script src="plugins/jspsych-instructions.js"></script>
    <script src="plugins/jspsych-html-keyboard-response.js"></script>
    <script src="plugins/jspsych-fullscreen.js"></script>
</head>

<script>
    function saveData() {
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'write_data_2back.php'); // change 'write_data.php' to point to php script.
        xhr.setRequestHeader('Content-Type', 'application/json');
        xhr.onload = function () {
            if (xhr.status == 200) {
                var response = JSON.parse(xhr.responseText);
                console.log(response.success);
                alert('Données transmises.')
            }
        };
        xhr.send(jsPsych.data.get().json());
    }
</script>

<body></body>

<?php
include '../fonctions.php';
$bdd = getBD();

$id_sujet = $_GET['id'];
$subject = getSubject($bdd, $id_sujet);
upBack_2($bdd, $id_sujet);
$trialAll = getBack_2($bdd, $subject['back_2_level']);
$trial = $trialAll[0];
$trial2 = $trialAll[1];
unset($trial['id_2_back']);
unset($trial2['id_2_back']);
unset($trial[42]);
unset($trial2[42]);

#$trial = ['R', 'F', 'T', 'F', 'S'];
#$trial2 = ['R', 'F', 'T', 'F', 'S'];
?>

<script>

    var block1 = <?php echo json_encode($trial) ?>;
    console.log(block1);
    var block2 = <?php echo json_encode($trial2) ?>;
    console.log(block2);

    var timeline = [];

    var subject_id = '<?php echo $id_sujet ?>';
    jsPsych.data.addProperties({
        id_subject: subject_id,
    });

    timeline.push({
        type: 'fullscreen',
        fullscreen_mode: true
    });

    var welcome = {
        type: 'instructions',
        pages: ["<h1>Entrainement 2-Back</h1>",
            "<p>Dans cette tâche, une séquence de lettres s'affichera en continu.</p>" +
            "<p>Appuyez sur la barre espace si la lettre affichée est la même que l'avant dernière.</p>",
            "<p style='font-size: 1.3em'>Exemple : <span class='mono' >R, T, F, <strong>T</strong>, H</span> </p>" +
            "<p>Ici, il faut appuyer sur la barre espace lorsque la lettre <span class='mono'>T</span> s'affiche pour la deuxième fois.</p>" +
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
    for ($i = 0; $i < count($trial); $i++) {
    ?>
    var trial = {
        type: 'html-keyboard-response',
        stimulus: "<h1 class='mono'><?php echo $trial[$i] ?></h1>",
        stimulus_duration: 500,
        trial_duration: 2000,
        choices: [32],
        response_ends_trial: false,
        data: {
            part: "2-back",
            letter: "<?php echo $trial[$i] ?>",
            trial_id: "<?php echo $i ?>",
            id_2_back: <?php echo $subject['back_2_level'] ?>,
            prev_letter: function () {
                return jsPsych.data.get().last(2).values()[0].letter;
            },
        },
        on_finish: function (data) {
            if (data.letter === data.prev_letter) {
                data.is_target = 1;
            }
            if (data.letter !== data.prev_letter) {
                data.is_target = 0;
            }
            if (data.key_press === 32 && data.letter === data.prev_letter) {
                data.correct = 1;
            } else {
                data.correct = 0;
            }
            if (data.key_press !== 32 && data.letter !== data.prev_letter) {
                data.correct = 1;
            }
        }
    }
    timeline.push(trial);
    <?php
    }
    ?>

    var feedback = {
        type: 'html-keyboard-response',
        choices: [],
        post_trial_gap: 1000,
        trial_duration: 2500,
        stimulus: function () {
            var moy = jsPsych.data.get().select('correct').sum();
            var pourc = moy / jsPsych.data.get().select('correct').count();
            return '<h1>Fin</h1><h2>Score : ' + pourc * 100 + '%</h2><p>Deuxième partie dans 3 secondes ...</p>';
        },
        data: {
            part: "feedback",
        },
    }
    timeline.push(feedback);

    <?php
    for ($i = 0; $i < count($trial2); $i++) {
    ?>
    var trial2 = {
        type: 'html-keyboard-response',
        stimulus: '<h1><?php echo $trial2[$i] ?></h1>',
        stimulus_duration: 500,
        trial_duration: 2000,
        choices: [32],
        response_ends_trial: false,
        data: {
            part: "2-back",
            letter: "<?php echo $trial2[$i] ?>",
            trial_id: "<?php echo $i ?>",
            id_2_back: <?php echo intval($subject['back_2_level']) + 1 ?>,
            prev_letter: function () {
                return jsPsych.data.get().last(2).values()[0].letter;
            },
        },
        on_finish: function (data) {
            if (data.letter === data.prev_letter) {
                data.is_target = 1;
            }
            if (data.letter !== data.prev_letter) {
                data.is_target = 0;
            }
            if (data.key_press === 32 && data.letter === data.prev_letter) {
                data.correct = 1;
            } else {
                data.correct = 0;
            }
            if (data.key_press !== 32 && data.letter !== data.prev_letter) {
                data.correct = 1;
            }
        }
    }
    timeline.push(trial2);
    <?php
    }
    ?>

    var feedback2 = {
        type: 'html-keyboard-response',
        choices: [32],
        stimulus: function () {
            var moy = jsPsych.data.get().select('correct').sum();
            var pourc = moy / jsPsych.data.get().select('correct').count();
            return '<h1>Fin</h1><h2>Score : ' + pourc * 100 + '%</h2><p>Appuyez sur la touche espace pour envoyer vos résultats.</p>';
        },
        data: {
            part: "feedback",
        },
    }
    timeline.push(feedback2);

    timeline.push({
        type: 'fullscreen',
        fullscreen_mode: false
    });

    jsPsych.init({
        timeline: timeline,
        on_finish: saveData
        /*on_finish: function () {
            jsPsych.data.displayData('csv');
        }*/
    })


</script>

</html>