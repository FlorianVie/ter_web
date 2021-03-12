<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Transcription - Test</title>
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

    // ---------------------------------------
    // RETRANSCRIPTION
    // ---------------------------------------

    var instruction_retran = {
        type: 'instructions',
        pages: ["<h1>Tâche de retranscription</h1>" +
        "<p>Cette tâche consiste à retranscrire le discours que vous entendez.</p>" +
        "<p>Deux phases alternent durant la tâche : une phase d'écoute et une phase de retranscription.</p>" +
        "<p>Durant les phases d'écoute, vous entendrez une portion de la conférence audio.</p>" +
        "<p>Durant les phases de retranscription, vous devrez retranscrire le discours que vous avez entendu.</p>" +
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
    for ($i = 0; $i < 5; $i++) {
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

    timeline.push({
        type: 'fullscreen',
        fullscreen_mode: false
    });

    jsPsych.init({
        timeline: timeline,
        show_progress_bar: true,
        //on_finish: saveData
        on_finish: function () {
            jsPsych.data.displayData('csv');
        }
    })


</script>

</html>