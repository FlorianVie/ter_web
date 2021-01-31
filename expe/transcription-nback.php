<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Tâche Principale</title>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Lato&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/jspsych.css">
    <link rel="stylesheet" href="css/custom.css">
    <script src="jspsych.js"></script>
    <script src="plugins/jspsych-instructions.js"></script>
    <script src="plugins/jspsych-html-keyboard-response.js"></script>
    <script src="plugins/jspsych-audio-keyboard-response.js"></script>
    <script src="plugins/retranscription.js"></script>
</head>

<script>
    function saveData() {
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'write_data_retransc.php'); // change 'write_data.php' to point to php script.
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

<body></body>

<?php
include '../fonctions.php';
$bdd = getBD();
$id_sujet = $_GET['id'];
$audio = getAudio($bdd);
?>

<script>

    var timeline = [];

    var subject_id = '<?php echo $id_sujet ?>';
    jsPsych.data.addProperties({
        subject: subject_id,
    });

    var welcome = {
        type: 'instructions',
        pages: ["<h1>Tâche de retranscription</h1>", "<p><textarea name='rep-instr' id='test-instr-box' cols='40' rows='10' style='font-family: sans-serif; font-size: 1.3em' ></textarea></p>", "Des instructions ici"],
        show_clickable_nav: true,
        data: {
            part: "instruction",
        }
    }
    timeline.push(welcome);

    <?php
    for ($i = 0; $i < count($audio); $i++) {
    ?>

    var audio = {
        type: 'audio-keyboard-response',
        stimulus: 'audio/mp3/<?php echo $audio[$i]['fichier'] ?>',
        prompt: '<p>Audio <?php echo $i + 1 ?> ...</p>',
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
        html: '<p><textarea name="rep" id="test-resp-box" cols="40" rows="10" style="font-family: sans-serif; font-size: 1.3em" ></textarea></p>',
        autofocus: 'test-resp-box',
        button_label: "",
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

    jsPsych.init({
        timeline: timeline,
        on_finish: saveData
        /*on_finish: function () {
            jsPsych.data.displayData();
        }*/
    })


</script>

</html>