<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Tâche Principale - N-Back</title>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Lato&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/jspsych.css">
    <link rel="stylesheet" href="css/custom.css">
    <link rel="icon" type="image/svg+xml" href="../assets/thinking.svg">
    <script src="jspsych.js"></script>
    <script src="plugins/jspsych-instructions.js"></script>
    <script src="plugins/jspsych-html-keyboard-response.js"></script>
    <script src="plugins/jspsych-audio-keyboard-response.js"></script>
    <script src="plugins/retranscription.js"></script>
    <script src="plugins/jspsych-fullscreen.js"></script>
</head>

<script>
    function saveData() {
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'write_data_retransc_nback.php'); // change 'write_data.php' to point to php script.
        xhr.setRequestHeader('Content-Type', 'application/json');
        xhr.onload = function () {
            if (xhr.status == 200) {
                var response = JSON.parse(xhr.responseText);
                console.log(response.success);
                alert("Données transmises");
            }
        };
        xhr.send(jsPsych.data.get().json());
    }
</script>

<script>
    function playAudio() {
        new Audio('../assets/beep.mp3').play();
    }
</script>

<body></body>

<?php
include '../fonctions.php';
$bdd = getBD();
$id_sujet = $_GET['id'];
$audio = getAudio($bdd);
$back2 = get_2_back_main($bdd);

$block1 = $back2[0];
$block2 = $back2[1];
$block3 = $back2[2];
$block4 = $back2[3];

unset($block1['id_2_back_main']);
unset($block2['id_2_back_main']);
unset($block3['id_2_back_main']);
unset($block4['id_2_back_main']);
unset($block1[42]);
unset($block2[42]);
unset($block3[42]);
unset($block4[42]);

#$block1 = ['1', 'F', 'T', 'F', 'S', 'R', 'S', 'F'];
#$block2 = ['2', 'F', 'T', 'F', 'S', 'R', 'S', 'F'];
#$block3 = ['3', 'F', 'T', 'F', 'S', 'R', 'S', 'F'];
#$block4 = ['4', 'F', 'T', 'F', 'S', 'R', 'S', 'F'];

?>

<script>
    var block1 = <?php echo json_encode($block1) ?>;
    console.log(block1);
    var block2 = <?php echo json_encode($block2) ?>;
    console.log(block2);
    var block3 = <?php echo json_encode($block3) ?>;
    console.log(block2);
    var block4 = <?php echo json_encode($block4) ?>;
    console.log(block2);

    var timeline = [];

    var subject_id = '<?php echo $id_sujet ?>';
    jsPsych.data.addProperties({
        subject_id: subject_id,
    });

    timeline.push({
        type: 'fullscreen',
        fullscreen_mode: true
    });

    var instruction_start = {
        type: 'instructions',
        pages: ["<h1>Tâche de retranscription</h1>",
            "<h1>Présentation</h1>" +
            "<p>Dans cette session, vous allez effectuer un tâche de retranscription d'une conférence en anglais.</p>" +
            "<p>La durée totale de la tâche de retranscription est d'envirion 30 minutes.</p>" +
            "<p>Avant de débuter la retranscription, vous effecturez une tâche 2-back similaire à la session d'entrainement.</p>" +
            "<p>A la fin de la retranscription, une deuxième tâche 2-back démarrera automatiquement.</p>",
            "<h2>Vérification du son</h2>" +
            "<p>En appuyant sur le bouton, entendez vous du son ?</p>" +
            "<button class='jspsych-btn' type='button' onclick='playAudio()' >Tester le son</button>" +
            "<p>Si vous entendez le 'beep', vous pouvez continuer, sinon prevenez l'expérimentateur.</p>"],
        show_clickable_nav: true,
        data: {
            part: "instruction",
        }
    }
    timeline.push(instruction_start);

    var instruction_nback = {
        type: 'instructions',
        pages: ["<h1>2-Back</h1>" +
        "<p>Dans cette tâche, une séquence de lettres s'affichera en continu.</p>" +
        "<p>Appuyez sur la touche 'O' si la lettre affichée est la même que l'avant-dernière. Si elle est différente, appuyez sur la touche 'E'.</p>" +
        "<p style='font-size: 1.3em'>Exemple : <span class='mono' >R, T, F, <strong>T</strong>, H</span> </p>" +
        "<p>Ici, il faut appuyer sur la touche 'O' lorsque la lettre <span class='mono'>T</span> s'affiche pour la deuxième fois et appuyer sur la touche 'E' pour les autres lettres.</p>" +
        "<p>Vous avez le temps d'appuyer sur les touches jusqu'à l'apparition de la lettre suivante, même si la dernière présentée disparait.</p>" +
        "<p>Vous devez également appuyer sur les touches pour les premières lettres présentées.</p>",
            "<h2>Attention !</h2>" +
            "<p>Cette tâche se déroule en deux parties qui s'enchainent avec 3 secondes d'intervalle.</p>" +
            "<p>Il en va de même vour la tâche après la retranscription.</p>",
            "<p>Appuyez sur 'Suivant' pour commencer ...</p>"],
        show_clickable_nav: true,
        data: {
            part: "instruction",
        }
    }
    timeline.push(instruction_nback);

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
        on_start: function () {
            console.log('pause')
        },
        data: {
            part: "Pause"
        }
    }
    timeline.push(prepause);


    // ---------------------------------------
    // Pre n-back - block 1 & 2
    // ---------------------------------------

    <?php
    for ($i = 0; $i < count($block1); $i++) {
    ?>
    var nback_block_1 = {
        type: 'html-keyboard-response',
        stimulus: "<h1 class='mono'><?php echo $block1[$i] ?></h1>",
        stimulus_duration: 500,
        trial_duration: 2000,
        choices: [69, 79],
        response_ends_trial: false,
        data: {
            part: "2-back-pre",
            letter: "<?php echo $block1[$i] ?>",
            trial_id: "<?php echo $i ?>",
            id_2_back: 1,
            block_part: 1,
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
            if (data.key_press === 79 && data.letter === data.prev_letter) {
                data.correct = 1;
                data.response_type = "Target";
                console.log(data.key_press, 'Correct');
            }
            // Mismatch
            if (data.key_press === 69 && data.letter === data.prev_letter) {
                data.correct = 0;
                data.response_type = "Mismatch";
                console.log(data.key_press, 'Incorrect: Mismatch');
            }
            // False-alarm
            if (data.key_press === 79 && data.letter !== data.prev_letter) {
                data.correct = 0;
                data.response_type = "False-alarm";
                console.log(data.key_press, 'Incorrect: False-alarm');
            }
            // Non-target
            if (data.key_press === 69 && data.letter !== data.prev_letter) {
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
    timeline.push(nback_block_1);
    <?php
    }
    ?>

    var pause_back = {
        type: 'html-keyboard-response',
        choices: [],
        trial_duration: 3000,
        stimulus: "<h2>Reprise dans 3 secondes ...</h2>",
        data: {
            part: "Pause",
        },
    }
    timeline.push(pause_back);

    timeline.push(prepause)

    <?php
    for ($i = 0; $i < count($block2); $i++) {
    ?>
    var nback_block_2 = {
        type: 'html-keyboard-response',
        stimulus: "<h1 class='mono'><?php echo $block2[$i] ?></h1>",
        stimulus_duration: 500,
        trial_duration: 2000,
        choices: [69, 79],
        response_ends_trial: false,
        data: {
            part: "2-back-pre",
            letter: "<?php echo $block2[$i] ?>",
            trial_id: "<?php echo $i ?>",
            id_2_back: 2,
            block_part: 2,
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
            if (data.key_press === 79 && data.letter === data.prev_letter) {
                data.correct = 1;
                data.response_type = "Target";
                console.log(data.key_press, 'Correct');
            }
            // Mismatch
            if (data.key_press === 69 && data.letter === data.prev_letter) {
                data.correct = 0;
                data.response_type = "Mismatch";
                console.log(data.key_press, 'Incorrect: Mismatch');
            }
            // False-alarm
            if (data.key_press === 79 && data.letter !== data.prev_letter) {
                data.correct = 0;
                data.response_type = "False-alarm";
                console.log(data.key_press, 'Incorrect: False-alarm');
            }
            // Non-target
            if (data.key_press === 69 && data.letter !== data.prev_letter) {
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
    timeline.push(nback_block_2);
    <?php
    }
    ?>


    // ---------------------------------------
    // RETRANSCRIPTION
    // ---------------------------------------

    var instruction_retran = {
        type: 'instructions',
        pages: ["<h1>Tâche de retranscription</h1>" +
        "<p>Cette tâche consiste à retranscrire le discours que vous entendez.</p>" +
        "<p>Deux phases alternent durant la tâche : une phase d'écoute et une phase de retranscription.</p>" +
        "<p>Durant les phases d'écoute, vous entendrez une portion de la conférence audio.</p>" +
        "<p>Durant les phases de retranscription, vous devrez retranscrire les paroles que vous avez entendu.</p>" +
        "<p>La phase de retranscription est calibrée pour durer un certain temps, lorsque celui-ci sera écoulé, le programme bascule automatiquement sur une nouvelle phase d'écoute.</p>" +
        "<p>Si vous n'avez pas réussi à finir de taper votre texte, ne vous en faites pas, il sera tout de même pris en compte.</p>",
            "<p>Voici un exemple de la zone dans laquelle vous pourrez retranscrire le discours :</p>" +
            "<p><textarea name='rep-instr' id='test-instr-box' cols='40' rows='10' style='font-family: sans-serif; font-size: 1.3em' ></textarea></p>" +
            "<p>Vous pouvez essayer de taper du texte pour essayer si cela fonctionne.</p>" +
            "<p>Le curseur sera automatiquement placé dans la zone de texte, vous n'aurez pas besoin d'utiliser votre souris.</p>",
            "<h2>Attention !</h2>" +
            "<p>Lorsque la tâche de retranscription sera terminée, une deuxième tâche 2-back démarrera automatiquement.</p>",
            "<p>Appuyez sur 'Suivant' pour commencer ...</p>"],
        show_clickable_nav: true,
        data: {
            part: "instruction",
        }
    }
    timeline.push(instruction_retran);

    timeline.push(prepause)

    var pre_audio_beep = {
        type: 'audio-keyboard-response',
        stimulus: '../assets/beep_beep_beep.mp3',
        prompt: "<p><img src='../assets/speaker-filled-audio-tool.png' width='100'></p>" +
            "<p>Préparez vous ...</p>",
        choices: jsPsych.NO_KEYS,
        trial_ends_after_audio: true,
        data: {
            part: "Beep Beep Beep",
        },
        on_start: function () {
            console.log("Audio : Beep Beep Beep")
        }
    };
    timeline.push(pre_audio_beep);

    timeline.push(prepause)

    <?php
    for ($i = 0; $i < count($audio); $i++) {
    ?>
    var audio = {
        type: 'audio-keyboard-response',
        stimulus: 'audio/mp3/<?php echo $audio[$i]['fichier'] ?>',
        prompt: "<p><img src='../assets/speaker-filled-audio-tool.png' width='100'></p>" +
            "<p>Audio <?php echo $i + 1 ?></p>",
        choices: jsPsych.NO_KEYS,
        trial_ends_after_audio: true,
        data: {
            part: "Audio",
            audio_id: <?php echo $i + 1 ?>,
            audio_file: "<?php echo $audio[$i]['fichier'] ?>"
        },
        on_start: function () {
            console.log("Audio : <?php echo $audio[$i]['fichier'] ?>", <?php echo $audio[$i]['duree'] ?>)
        }
    };
    timeline.push(audio);

    var retranscription = {
        type: 'survey-html-form',
        html: '<h1>Retranscription :</h1>' +
            '<p><textarea name="rep" id="test-resp-box" cols="40" rows="10" style="font-family: sans-serif; font-size: 1.3em" ></textarea></p>',
        autofocus: 'test-resp-box',
        button_label: "",
        data: {
            part: "Retranscription",
        },
        on_start: function () {
            jsPsych.pluginAPI.setTimeout(function () {
                document.getElementById("jspsych-survey-html-form-next").click();
            }, <?php echo (intval($audio[$i]['duree']) * 2.5) * 1000 ?>);
        },
        on_finish: function (data) {
            data.retransc = JSON.parse(data.responses).rep;
            console.log(data.retransc);
        }
    }
    timeline.push(retranscription)

    <?php
    }
    ?>


    // ---------------------------------------
    // Post n-back - block 1 & 2
    // ---------------------------------------

    timeline.push(prepause);
    var pause_pre_back = {
        type: 'html-keyboard-response',
        choices: [],
        trial_duration: 3000,
        stimulus: "<h2>2-back dans 3 secondes ...</h2>" +
            "<p>Préparez vous à appuyez sur 'E' et 'O'</p>",
        data: {
            part: "Pause",
        },
    }
    timeline.push(pause_pre_back);
    timeline.push(prepause);

    <?php
    for ($i = 0; $i < count($block3); $i++) {
    ?>
    var nback_block_3 = {
        type: 'html-keyboard-response',
        stimulus: "<h1 class='mono'><?php echo $block3[$i] ?></h1>",
        stimulus_duration: 500,
        trial_duration: 2000,
        choices: [69, 79],
        response_ends_trial: false,
        data: {
            part: "2-back-post",
            letter: "<?php echo $block3[$i] ?>",
            trial_id: "<?php echo $i ?>",
            id_2_back: 3,
            block_part: 1,
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
            if (data.key_press === 79 && data.letter === data.prev_letter) {
                data.correct = 1;
                data.response_type = "Target";
                console.log(data.key_press, 'Correct');
            }
            // Mismatch
            if (data.key_press === 69 && data.letter === data.prev_letter) {
                data.correct = 0;
                data.response_type = "Mismatch";
                console.log(data.key_press, 'Incorrect: Mismatch');
            }
            // False-alarm
            if (data.key_press === 79 && data.letter !== data.prev_letter) {
                data.correct = 0;
                data.response_type = "False-alarm";
                console.log(data.key_press, 'Incorrect: False-alarm');
            }
            // Non-target
            if (data.key_press === 69 && data.letter !== data.prev_letter) {
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
    timeline.push(nback_block_3);
    <?php
    }
    ?>

    timeline.push(pause_back);

    timeline.push(prepause)

    <?php
    for ($i = 0; $i < count($block4); $i++) {
    ?>
    var nback_block_4 = {
        type: 'html-keyboard-response',
        stimulus: "<h1 class='mono'><?php echo $block4[$i] ?></h1>",
        stimulus_duration: 500,
        trial_duration: 2000,
        choices: [69, 79],
        response_ends_trial: false,
        data: {
            part: "2-back-post",
            letter: "<?php echo $block4[$i] ?>",
            trial_id: "<?php echo $i ?>",
            id_2_back: 4,
            block_part: 2,
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
            if (data.key_press === 79 && data.letter === data.prev_letter) {
                data.correct = 1;
                data.response_type = "Target";
                console.log(data.key_press, 'Correct');
            }
            // Mismatch
            if (data.key_press === 69 && data.letter === data.prev_letter) {
                data.correct = 0;
                data.response_type = "Mismatch";
                console.log(data.key_press, 'Incorrect: Mismatch');
            }
            // False-alarm
            if (data.key_press === 79 && data.letter !== data.prev_letter) {
                data.correct = 0;
                data.response_type = "False-alarm";
                console.log(data.key_press, 'Incorrect: False-alarm');
            }
            // Non-target
            if (data.key_press === 69 && data.letter !== data.prev_letter) {
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
    timeline.push(nback_block_4);
    <?php
    }
    ?>


    timeline.push({
        type: 'fullscreen',
        fullscreen_mode: false
    });

    jsPsych.init({
        timeline: timeline,
        show_progress_bar: true,
        on_finish: saveData
        /*on_finish: function () {
            jsPsych.data.displayData('csv');
        }*/
    })


</script>

</html>