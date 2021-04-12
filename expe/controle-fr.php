<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Tâche Principale - Transcription FR</title>
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
        xhr.open('POST', 'write_data_fr_control.php'); // change 'write_data.php' to point to php script.
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
$audio = getAudioFR($bdd);
?>

<script>
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
            "<p>Dans cette session, vous allez effectuer une tâche de retranscription d'une conférence en français.</p>" +
            "<p>La durée totale de la tâche de retranscription est d'environ 19 minutes.</p>",
            "<h2>Vérification du son</h2>" +
            "<p>En appuyant sur le bouton, entendez vous du son ?</p>" +
            "<button class='jspsych-btn' type='button' onclick='playAudio()' >Tester le son</button>" +
            "<p>Si vous entendez le 'beep', vous pouvez continuer, sinon prevenez l'expérimentateur.</p>",
            "<h2>Instructions</h2>" +
            "<p>Cette expérience consiste à retranscrire le discours que vous entendez.</p>" +
            "<p>Deux phases alternent durant la tâche : une phase d'écoute et une phase de retranscription.</p>" +
            "<p>Durant les phases d'écoute, vous entendrez une portion d'une conférence audio.</p>" +
            "<p>Durant les phases de retranscription, vous devrez retranscrire les paroles que vous avez entendu le plus fidèlement possible.</p>" +
            "<p>Il n'est pas nécessaire de retranscrire la ponctuation.</p>" +
            "<p>La phase de retranscription est calibrée pour durer un certain temps, lorsque celui-ci sera écoulé, le programme basculera automatiquement sur une nouvelle phase d'écoute.</p>" +
            "<p>Si vous n'avez pas réussi à finir de taper votre texte, ne vous en faites pas, il sera tout de même pris en compte.</p>",
            "<p>Voici un exemple de la zone dans laquelle vous pourrez retranscrire le discours :</p>" +
            "<p><textarea name='rep-instr' id='test-instr-box' cols='40' rows='10' style='font-family: sans-serif; font-size: 1.3em' ></textarea></p>" +
            "<p>Vous pouvez essayer de taper du texte pour vérifier si cela fonctionne.</p>" +
            "<p>Le curseur sera automatiquement placé dans la zone de texte, vous n'aurez pas besoin d'utiliser votre souris.</p>",
            "<h2>Attention !</h2>" +
            "<p>Lorsque l'expérimentation sera finie, attendez d'être notifié de la transmission des données avant de quitter la page.</p>" +
            "<p>Appuyez sur 'Suivant' pour commencer ...</p>"],
        show_clickable_nav: true,
        data: {
            part: "instruction",
        }
    }
    timeline.push(instruction_start);

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
        stimulus: 'audio/mp3_fr/<?php echo $audio[$i]['fichier'] ?>',
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
            console.log("Audio : <?php echo $audio[$i]['fichier'] ?>", <?php echo $audio[$i]['duree'] ?>, <?php echo (floatval($audio[$i]['duree']) * 3) ?>)
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
            }, <?php echo (floatval($audio[$i]['duree']) * 3 * 1000) ?>); // TODO Changer variable temps de pause
        },
        on_finish: function (data) {
            data.retransc = JSON.parse(data.responses).rep;
            //console.log(data.retransc);
            data.audio_id = <?php echo $i + 1 ?>;
            console.log(data.audio_id, data.retransc);
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
        on_finish: saveData
        /*on_finish: function () {
            jsPsych.data.displayData('csv');
        }*/
    })


</script>

</html>