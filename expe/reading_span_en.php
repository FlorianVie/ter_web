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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/mathjs/8.1.1/math.js"></script>
    <script src="jspsych.js"></script>
    <script src="plugins/jspsych-html-keyboard-response.js"></script>
    <script src="plugins/jspsych-html-button-response.js"></script>
    <script src="plugins/recall-plugin.js"></script>
    <script src="plugins/jspsych-survey-html-form.js"></script>
    <script src="plugins/jspsych-instructions.js"></script>
    <link rel="stylesheet" href="css/jspsych.css">
</head>

<body></body>

<?php
include '../fonctions.php';
$bdd = getBD();

$sentences = getSentences($bdd);
$practice = getSentencesPrac($bdd);
$letters = array_column(getLetters($bdd), 'letter');

shuffle($letters);
$letters_grid = $letters;
shuffle($letters_grid);
$letters_both = $letters_grid;
shuffle($letters_both);

$tr_nb = 3;
$both_nb = 3;
$both_size = 2;
?>

<script>

    var feedback_time = 1500;
    var sentences_timeout = 1000;
    var sentences_time = [];
    var sentences_correct_training = [];

    // timeline creation
    var timeline = [];

    // welcome message
    var welcome = {
        type: 'instructions',
        pages: ["<h1>Ecrire le message de bienvenue</h1> Appuyez sur une touche pour continuer."],
        show_clickable_nav: true,
    }
    timeline.push(welcome);

    // instructions
    var instructions_training_recall = {
        type: 'instructions',
        pages: ["Des instructions trop cools à lire !"],
        show_clickable_nav: true,
    }
    timeline.push(instructions_training_recall);

    // -------------------------------------------------------
    // Training letters
    // -------------------------------------------------------

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
    // Training sentences
    // -------------------------------------------------------

    var instructions_training_sentences = {
        type: 'instructions',
        pages: ["Des instructions trop cools à lire pour les phrases !"],
        show_clickable_nav: true,
    }
    timeline.push(instructions_training_sentences);

    <?php
    for ($i = 0; $i < count($practice); $i++) {
    ?>
    var sentence_training = {
        type: 'html-button-response',
        stimulus: "<h3><?php echo $practice[$i][1] ?></p>",
        choices: ['False', 'True'],
        trial_duration: 6000,
        data: {
            make_sense: <?php echo $practice[$i][2] ?>
        },
        on_finish: function (data) {
            if (data.button_pressed === null) {
                data.button_pressed = null;
            }
            if (data.rt === null) {
                data.rt = 6000;
            }
            data.correct = data.button_pressed === data.make_sense;
            console.log('Make sense:', data.button_pressed, data.make_sense, data.correct, data.rt);
            sentences_time.push(data.rt);
            if (data.correct === true) {
                sentences_correct_training.push(1);
            } else {
                sentences_correct_training.push(0);
            }
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
            return math.sum(sentences_correct_training) + ' bonnes réponses sur 15.';
        },
        on_finish: function (data) {
            var sentences_mean = math.mean(sentences_time);
            var sentences_std = math.std(sentences_time);
            var sentences_sum = math.sum(sentences_time);
            console.log('TR sum:', sentences_sum);
            console.log('TR mean:', sentences_mean);
            console.log('TR std:', sentences_std);
            sentences_timeout = sentences_mean + 2.5 * sentences_std;
            console.log('Timeout calculated:', sentences_timeout);
            data.timeout_var = sentences_timeout;
        }
    }
    timeline.push(feedback_training_sentences);

    // -------------------------------------------------------
    // Training both
    // -------------------------------------------------------

    var instructions_training_both = {
        type: 'instructions',
        pages: ["Des instructions trop cools à lire pour les deux !"],
        show_clickable_nav: true,
    }
    timeline.push(instructions_training_both);

    <?php
    for ($i = 0; $i < $both_nb; $i++) {
    // Nb of trials
    shuffle($letters_both);
    shuffle($practice);
    shuffle($letters_grid);
    for ($j = 0; $j < $both_size; $j++) {
    // Size of the trial
    ?>
    var training_both_sentence = {
        type: 'html-button-response',
        stimulus: "<h3><?php echo $practice[$j][1] ?></p>",
        choices: ['False', 'True'],
        trial_duration: function () {
            console.log(sentences_timeout);
            return sentences_timeout;
        },
        data: {
            make_sense: <?php echo $practice[$j][2] ?>
        },
        on_finish: function (data) {
            data.correct = data.button_pressed === data.make_sense;
            console.log('Make sense:', data.button_pressed, data.make_sense, data.correct);
            sentences_time.push(data.rt);
            if (data.correct === true) {
                sentences_correct_training.push(1);
            } else {
                sentences_correct_training.push(0);
            }
        }
    }
    timeline.push(training_both_sentence);

    var training_both_letter = {
        type: 'html-keyboard-response',
        stimulus: "<h1><?php echo $letters_both[$j] ?></h1>",
        trial_duration: 1000,
        choices: "",
    }
    timeline.push(training_both_letter);

    <?php
    }
    ?>
    btn_clicked = '';
    htmlgrid = '<table style="margin: auto" >' +
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

    var training_both_recall = {
        type: 'survey-html-form',
        preamble: '<h2>Rappel :</h2>',
        html: htmlgrid,
        data: {
            correct_letters: '<?php for ($k = 0; $k < $both_size; $k++) {
                echo $letters_both[$i];
            } ?>'
        },
        on_finish: function (data) {
            data.letters_recalled = JSON.parse(data.responses).response;
            data.correct = data.correct_letters === data.letters_recalled;
            console.log('Recalled:', data.letters_recalled, data.correct);
        },
        on_start: function () {
            btn_clicked = '';
            removeInput();
        }
    }
    timeline.push(training_both_recall);
    <?php
    }
    ?>

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