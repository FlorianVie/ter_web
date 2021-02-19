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
    <script src="plugins/jspsych-fullscreen.js"></script>
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

    timeline.push({
        type: 'fullscreen',
        fullscreen_mode: true
    });

    var welcome = {
        type: 'instructions',
        pages: ["<h1>Entrainement 0-Back</h1>",
            "<p>Dans cette tâche, une séquence de lettres s'affichera en continu.</p>" +
            "<p>Appuyez sur la touche '<strong>O</strong>' si la lettre affichée est la lettre <strong class='mono'>M</strong>. Sinon appuyez sur la touche '<strong>E</strong>'.</p>",
            "<p style='font-size: 1.3em'>Exemple : <span class='mono'>R, T, K, <strong>M</strong>, H</span> </p>" +
            "<p>Ici, il faut appuyer sur la touche '<strong>O</strong>' lorsque la lettre <span class='mono'>M</span> s'affiche, et sur la touche '<strong>E</strong>' pour les autres lettres.</p>" +
            "<p>Vous avez le temps d'appuyer sur les touches jusqu'à l'apparition de la lettre suivante, même si la dernière présentée disparait.</p>" +
            "<p>Vous devez également appuyer sur les touches pour les premières lettres présentées.</p>",
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
            "<p>Placez l'index de votre <strong>main droite</strong> sur la touche '<strong>O</strong>'</p>" +
            "<p>Vous devrez garder votre doigt en position durant toute la session.</p>" +
            "<p>Lorsque vous êtes prêt appuyez sur la touche '<strong>O</strong>' pour continuer.</p>",
        choices: [79],
        post_trial_gap: 500,
        data: {
            part: "Preparation"
        }
    }
    timeline.push(preparation_main_droite);

    var preparation_main_gauche = {
        type: 'html-keyboard-response',
        stimulus: "<h1>Positionnement de la main gauche</h1>" +
            "<p>Placez l'index de votre <strong>main gauche</strong> sur la touche '<strong>E</strong>'</p>" +
            "<p>Vous devrez garder votre doigt en position durant toute la session.</p>" +
            "<p>Lorsque vous êtes prêt appuyez sur la touche '<strong>E</strong>' pour commencer la tâche.</p>",
        choices: [69],
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
    for ($i = 0; $i < count($back_0); $i++) {
    ?>
    var trial = {
        type: 'html-keyboard-response',
        stimulus: "<h1 class='mono'><?php echo $back_0[$i] ?></h1>",
        stimulus_duration: 500,
        trial_duration: 2000,
        choices: [69, 79],
        response_ends_trial: false,
        data: {
            letter: "<?php echo $back_0[$i] ?>",
            trial_id: "<?php echo $i ?>"
        },
        on_finish: function (data) {
            if (data.letter === 'M') {
                data.is_target = 1;
                console.log('Target', data.letter);
            }
            if (data.letter !== 'M') {
                data.is_target = 0;
                console.log('Non-target', data.letter);
            }

            // Target
            if (data.key_press === 79 && data.letter === 'M') {
                data.correct = 1;
                data.response_type = "Target";
                console.log(data.key_press, 'Correct');
            }
            // Mismatch
            if (data.key_press === 69 && data.letter === 'M') {
                data.correct = 0;
                data.response_type = "Mismatch";
                console.log(data.key_press, 'Incorrect: Mismatch');
            }
            // False-alarm
            if (data.key_press === 79 && data.letter !== 'M') {
                data.correct = 0;
                data.response_type = "False-alarm";
                console.log(data.key_press, 'Incorrect: False-alarm');
            }
            // Non-target
            if (data.key_press === 69 && data.letter !== 'M') {
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