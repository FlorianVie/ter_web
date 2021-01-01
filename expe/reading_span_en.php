<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reading Span - EN</title>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono&display=swap" rel="stylesheet">
    <script src="jquery.js"></script>
    <script src="jspsych.js"></script>
    <script src="plugins/jspsych-html-keyboard-response.js"></script>
    <script src="plugins/jspsych-html-button-response.js"></script>
    <script src="plugins/recall-plugin.js"></script>
    <script src="plugins/jspsych-survey-html-form.js"></script>
    <link rel="stylesheet" href="css/jspsych.css">
</head>

<body></body>

<?php
include '../fonctions.php';
$bdd = getBD();

$sentences = getSentences($bdd);
$practice = getSentencesPrac($bdd);
$letters = array_column(getLetters($bdd), 'letter');

$tr_nb = 3;
shuffle($letters);
$letters_grid = $letters;
shuffle($letters_grid);
?>

<script>

    var feedback_time = 1500;
    var sentences_timeout = 1000;
    var sentences_time = [];

    // timeline creation
    var timeline = [];

    // welcome message
    var welcome = {
        type: 'html-keyboard-response',
        stimulus: "<h1>Ecrire le message de bienvenue</h1> Appuyez sur une touche pour continuer.",
    }
    timeline.push(welcome);

    // instructions
    var instructions_training_recall = {
        type: 'html-keyboard-response',
        stimulus: "Des instructions trop cools à lire !",
    }
    timeline.push(instructions_training_recall);

    // training
    <?php
    for ($i = 0; $i < $tr_nb; $i++) {
    ?>
    var training_trial = {
        type: 'html-keyboard-response',
        stimulus: "<h1><?php echo $letters[$i] ?></h1>",
        trial_duration: 1000,
        choices: "",
    }
    timeline.push(training_trial);
    <?php
    }
    ?>

    var btn_clicked = '';
    var htmlgrid = '<table style="margin: auto" >' +
        '<tr>' +
        '<td><button class="jspsych-btn" id="1" onclick="btn_clicked = getInputGrid(this, btn_clicked)" type="button"><?php echo $letters_grid[0] ?></button></td>' +
        '<td><button class="jspsych-btn" id="2" onclick="btn_clicked = getInputGrid(this, btn_clicked)" type="button"><?php echo $letters_grid[1] ?></button></td>' +
        '<td><button class="jspsych-btn" id="3" onclick="btn_clicked = getInputGrid(this, btn_clicked)" type="button"><?php echo $letters_grid[2] ?></button></td>' +
        '</tr>' +
        '<tr>' +
        '<td><button class="jspsych-btn" id="1" onclick="btn_clicked = getInputGrid(this, btn_clicked)" type="button"><?php echo $letters_grid[3] ?></button></td>' +
        '<td><button class="jspsych-btn" id="2" onclick="btn_clicked = getInputGrid(this, btn_clicked)" type="button"><?php echo $letters_grid[4] ?></button></td>' +
        '<td><button class="jspsych-btn" id="3" onclick="btn_clicked = getInputGrid(this, btn_clicked)" type="button"><?php echo $letters_grid[5] ?></button></td>' +
        '</tr>' +
        '<tr>' +
        '<td><button class="jspsych-btn" id="1" onclick="btn_clicked = getInputGrid(this, btn_clicked)" type="button"><?php echo $letters_grid[6] ?></button></td>' +
        '<td><button class="jspsych-btn" id="2" onclick="btn_clicked = getInputGrid(this, btn_clicked)" type="button"><?php echo $letters_grid[7] ?></button></td>' +
        '<td><button class="jspsych-btn" id="3" onclick="btn_clicked = getInputGrid(this, btn_clicked)" type="button"><?php echo $letters_grid[8] ?></button></td>' +
        '</tr>' +
        '<tr>' +
        '<td><button class="jspsych-btn" id="1" onclick="btn_clicked = getInputGrid(this, btn_clicked)" type="button"><?php echo $letters_grid[9] ?></button></td>' +
        '<td><button class="jspsych-btn" id="2" onclick="btn_clicked = getInputGrid(this, btn_clicked)" type="button"><?php echo $letters_grid[10] ?></button></td>' +
        '<td><button class="jspsych-btn" id="3" onclick="btn_clicked = getInputGrid(this, btn_clicked)" type="button"><?php echo $letters_grid[11] ?></button></td>' +
        '</tr>' +
        '</table>' +
        '<p><input type="text" name="response" id="resp" style="font-size: 1.3em; text-align: center" ></p>' +
        '<p><button class="jspsych-btn" id="supp" onclick="btn_clicked =  removeInput()" style="background-color: grey; font-size: 1em" type="button" >Effacer</button></p>'

    var training_recall = {
        type: 'survey-html-form',
        preamble: '<h2>Rappel :</h2>',
        html: htmlgrid,
        data: {
            correct_letters: '<?php for ($i = 0; $i < $tr_nb; $i++) {
                echo $letters[$i];
            } ?>'
        },
        on_finish: function (data) {
            data.letters_recalled = JSON.parse(data.responses).response;
            data.correct = data.correct_letters === data.letters_recalled;
            console.log('Recalled:', data.letters_recalled, data.correct);
        }
    }
    timeline.push(training_recall);

    var feedback = {
        type: 'html-keyboard-response',
        trial_duration: feedback_time,
        choices: "",
        stimulus: function () {
            var last_trial_correct = jsPsych.data.get().last(1).values()[0].correct;
            if (last_trial_correct) {
                return "<h2>Correct!</h2>";
            } else {
                return "<h2>Wrong.</h2>"
            }
        }
    }
    timeline.push(feedback);

    // -------------------------------------------------------

    var instructions_training_sentences = {
        type: 'html-keyboard-response',
        stimulus: "Des instructions trop cools à lire pour les phrases !",
    }
    timeline.push(instructions_training_sentences);

    <?php
    for ($i = 0; $i < count($practice); $i++) {
    ?>
    var sentence_training = {
        type: 'html-button-response',
        stimulus: "<h3><?php echo $practice[$i][1] ?></p>",
        choices: ['False', 'True'],
        data: {
            make_sense: <?php echo $practice[$i][2] ?>
        },
        on_finish: function (data) {
            data.correct = data.button_pressed === data.make_sense;
            console.log('Make sense:', data.button_pressed, data.make_sense, data.correct);
            sentences_time.push(data.rt);
        }
    }
    timeline.push(sentence_training);
    <?php
    }
    ?>

    var feedback_training_sentences = {
        type: 'html-keyboard-response',
        trial_duration: 3000,
        choices: "",
        stimulus: function () {
            var sum = 0;
            for (var i = 0; i < sentences_time.length; i++) {
                sum += sentences_time[i];
            }
            var avg = sum / sentences_time.length;

            return avg;
        },
    }
    timeline.push(feedback_training_sentences);


    jsPsych.init({
        timeline: timeline,
        on_finish: function () {
            jsPsych.data.displayData();
        }
    })

</script>

<script>
    function getInputGrid(button, btn_clicked) {
        btn_clicked += $(button).text();
        $('#resp').val(btn_clicked);
        return btn_clicked;
    }

    function removeInput() {
        $('#resp').val("");
        return "";
    }
</script>

</html>