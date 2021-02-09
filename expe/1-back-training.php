<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>1-back entrainement</title>
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
        xhr.open('POST', 'write_data_1back.php'); // change 'write_data.php' to point to php script.
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
upBack_1($bdd, $id_sujet);
$trial = getBack_1($bdd, $subject['back_1_level']);
unset($trial['id_1_back']);
unset($trial[42]);

//$trial = ['R', 'F', 'F', 'G'];
?>

<script>

    var block = <?php echo json_encode($trial) ?>;
    console.log(block);

    var timeline = [];

    var subject_id = '<?php echo $id_sujet ?>';
    jsPsych.data.addProperties({
        id_subject: subject_id,
        id_1_back: <?php echo $subject['back_1_level'] ?>,
    });

    timeline.push({
        type: 'fullscreen',
        fullscreen_mode: true
    });

    var welcome = {
        type: 'instructions',
        pages: ["<h1>Entrainement 1-Back</h1>",
            "<p>Dans cette tâche, une séquence de lettres s'affichera en continu.</p>" +
            "<p>Appuyez sur la touche '<strong>J</strong>' si la lettre affichée est la même que la dernière. Sinon appuyez sur la touche '<strong>F</strong>'.</p>",
            "<p style='font-size: 1.3em'>Exemple : <span class='mono'>R, T, K, <strong>K</strong>, H</span> </p>" +
            "<p>Ici, il faut appuyer sur la touche '<strong>J</strong>' lorsque la lettre <span class='mono'>K</span> s'affiche pour la deuxième fois et sur la touche '<strong>F</strong>' pour les autres.</p>" +
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
            part: "1-back",
            letter: "<?php echo $trial[$i] ?>",
            trial_id: "<?php echo $i ?>",
            prev_letter: function () {
                return jsPsych.data.get().last(1).values()[0].letter;
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