<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>1-back entrainement</title>
    <link rel="stylesheet" href="css/jspsych.css">
    <script src="jspsych.js"></script>
    <script src="plugins/jspsych-instructions.js"></script>
    <script src="plugins/jspsych-html-keyboard-response.js"></script>
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

    var welcome = {
        type: 'instructions',
        pages: ["<h1>Entrainement 1-Back</h1>", "Des instructions ici"],
        show_clickable_nav: true,
        data: {
            part: "instruction",
        }
    }
    timeline.push(welcome);

    <?php
    for ($i = 0; $i < count($trial); $i++) {
    ?>
    var trial = {
        type: 'html-keyboard-response',
        stimulus: '<h1><?php echo $trial[$i] ?></h1>',
        stimulus_duration: 500,
        trial_duration: 2000,
        choices: [32],
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