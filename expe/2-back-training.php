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

#$trial = ['R', 'F', 'T', 'F', 'S', 'R', 'S', 'F'];
#$trial2 = ['R', 'F', 'T', 'F', 'S', 'R', 'S', 'F'];
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
            "<p>Appuyez sur la touche 'J' si la lettre affichée est la même que l'avant-dernière. Si elle est différente, appuyez sur la touche 'F'.</p>",
            "<p style='font-size: 1.3em'>Exemple : <span class='mono' >R, T, F, <strong>T</strong>, H</span> </p>" +
            "<p>Ici, il faut appuyer sur la touche 'J' lorsque la lettre <span class='mono'>T</span> s'affiche pour la deuxième fois et appuyer sur la touche 'F' pour les autres lettres.</p>" +
            "<p>Vous avez le temps d'appuyer sur les touches jusqu'à l'apparition de la lettre suivante, même si la dernière présentée disparait.</p>",
            "<p>Appuyez sur 'Suivant' pour commencer ...</p>"],
        show_clickable_nav: true,
        data: {
            part: "instruction",
        }
    }
    timeline.push(welcome);

    var preparation_main_droite = {
        type: 'html-keyboard-response',
        stimulus: "<h1>Positionnement de la main droite</h1>" +
            "<p>Placez l'index de votre <strong>main droite</strong> sur la touche '<strong>J</strong>'</p>" +
            "<p>Vous devrez garder votre doigt en position durant toute la session.</p>" +
            "<p>Lorsque vous êtes prêt appuyez sur la touche '<strong>J</strong>' pour continuer.</p>",
        choices: [74],
        post_trial_gap: 500,
        data: {
            part: "Preparation"
        }
    }
    timeline.push(preparation_main_droite);

    var preparation_main_gauche = {
        type: 'html-keyboard-response',
        stimulus: "<h1>Positionnement de la main gauche</h1>" +
            "<p>Placez l'index de votre <strong>main gauche</strong> sur la touche '<strong>F</strong>'</p>" +
            "<p>Vous devrez garder votre doigt en position durant toute la session.</p>" +
            "<p>Lorsque vous êtes prêt appuyez sur la touche '<strong>F</strong>' pour commencer la tâche.</p>",
        choices: [70],
        data: {
            part: "Preparation"
        }
    }
    timeline.push(preparation_main_gauche);

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
        choices: [70, 74],
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
                console.log('Target', data.prev_letter, data.letter);
            }
            if (data.letter !== data.prev_letter) {
                data.is_target = 0;
                console.log('Non-target', data.prev_letter, data.letter);
            }

            // Target
            if (data.key_press === 74 && data.letter === data.prev_letter) {
                data.correct = 1;
                data.response_type = "Target";
                console.log(data.key_press, 'Correct');
            }
            // Mismatch
            if (data.key_press === 70 && data.letter === data.prev_letter) {
                data.correct = 0;
                data.response_type = "Mismatch";
                console.log(data.key_press, 'Incorrect: Mismatch');
            }
            // False-alarm
            if (data.key_press === 74 && data.letter !== data.prev_letter) {
                data.correct = 0;
                data.response_type = "False-alarm";
                console.log(data.key_press, 'Incorrect: False-alarm');
            }
            // Non-target
            if (data.key_press === 70 && data.letter !== data.prev_letter) {
                data.correct = 1;
                data.response_type = "Non-target";
                console.log(data.key_press, 'Correct');
            }
            // No input
            if (data.key_press === null) {
                data.correct = 0;
                data.response_type = "No-input";
                console.log(data.key_press, 'Incorrect: no input');
            }
        }
    }
    timeline.push(trial);
    <?php
    }
    ?>

    var feedback = {
        type: 'html-keyboard-response',
        choices: [74],
        post_trial_gap: 1000,
        //trial_duration: 2500,
        stimulus: function () {
            var nb_target = jsPsych.data.get().filter({is_target: 1}).count();
            console.log('Targets counts :', nb_target);
            var targets = jsPsych.data.get().filter({response_type: 'Target'}).count();
            console.log('Targets :', targets / nb_target);
            var mismatch = jsPsych.data.get().filter({response_type: 'Mismatch'}).count();
            console.log('Mismatches :', mismatch);
            var false_alarms = jsPsych.data.get().filter({response_type: 'False-alarm'}).count();
            console.log('False alarms :', false_alarms);
            var non_targets = jsPsych.data.get().filter({response_type: 'Non-target'}).count();
            console.log('Non-targets :', non_targets);
            var no_inputs = jsPsych.data.get().filter({response_type: 'No-input'}).count();
            console.log('No-inputs :', no_inputs);

            var moy = jsPsych.data.get().select('correct').sum();
            var pourc = moy / jsPsych.data.get().select('correct').count();

            return '<h1>Pause</h1>' +
                '<h2>Cibles trouvées : ' + (targets / nb_target) * 100 + '%</h2>' +
                '<h2>Cibles manquées : ' + mismatch + '</h2>' +
                '<h2>Fausses alarmes : ' + false_alarms + '</h2>' +
                '<p>Appuyez sur la touche "J" pour continuer.</p>';
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
        stimulus: "<h1 class='mono'><?php echo $trial2[$i] ?></h1>",
        stimulus_duration: 500,
        trial_duration: 2000,
        choices: [70, 74],
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
                console.log('Target', data.prev_letter, data.letter);
            }
            if (data.letter !== data.prev_letter) {
                data.is_target = 0;
                console.log('Non-target', data.prev_letter, data.letter);
            }

            // Target
            if (data.key_press === 74 && data.letter === data.prev_letter) {
                data.correct = 1;
                data.response_type = "Target";
                console.log(data.key_press, 'Correct');
            }
            // Mismatch
            if (data.key_press === 70 && data.letter === data.prev_letter) {
                data.correct = 0;
                data.response_type = "Mismatch";
                console.log(data.key_press, 'Incorrect: Mismatch');
            }
            // False-alarm
            if (data.key_press === 74 && data.letter !== data.prev_letter) {
                data.correct = 0;
                data.response_type = "False-alarm";
                console.log(data.key_press, 'Incorrect: False-alarm');
            }
            // Non-target
            if (data.key_press === 70 && data.letter !== data.prev_letter) {
                data.correct = 1;
                data.response_type = "Non-target";
                console.log(data.key_press, 'Correct');
            }
            // No input
            if (data.key_press === null) {
                data.correct = 0;
                data.response_type = "No-input";
                console.log(data.key_press, 'Incorrect: no input');
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
            var nb_target = jsPsych.data.get().filter({is_target: 1}).count();
            console.log('Targets counts :', nb_target);
            var targets = jsPsych.data.get().filter({response_type: 'Target'}).count();
            console.log('Targets :', targets / nb_target);
            var mismatch = jsPsych.data.get().filter({response_type: 'Mismatch'}).count();
            console.log('Mismatches :', mismatch);
            var false_alarms = jsPsych.data.get().filter({response_type: 'False-alarm'}).count();
            console.log('False alarms :', false_alarms);
            var non_targets = jsPsych.data.get().filter({response_type: 'Non-target'}).count();
            console.log('Non-targets :', non_targets);
            var no_inputs = jsPsych.data.get().filter({response_type: 'No-input'}).count();
            console.log('No-inputs :', no_inputs);

            var moy = jsPsych.data.get().select('correct').sum();
            var pourc = moy / jsPsych.data.get().select('correct').count();
            return '<h1>Fin</h1>' +
                '<h2>Cibles trouvées : ' + (targets / nb_target) * 100 + '%</h2>' +
                '<h2>Cibles manquées : ' + mismatch + '</h2>' +
                '<h2>Fausses alarmes : ' + false_alarms + '</h2>' +
                '<p>Appuyez sur la touche "Espace" pour envoyer vos données.</p>';
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