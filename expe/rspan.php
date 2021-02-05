<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reading Span</title>
    <script src="jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/mathjs/8.1.1/math.js"></script>
    <script src="jspsych.js"></script>
    <script src="plugins/jspsych-html-keyboard-response.js"></script>
    <script src="plugins/jspsych-html-button-response.js"></script>
    <script src="plugins/recall-plugin.js"></script>
    <script src="plugins/jspsych-survey-html-form.js"></script>
    <script src="plugins/jspsych-instructions.js"></script>
    <script src="plugins/jspsych-fullscreen.js"></script>

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono&family=Lato&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/jspsych.css">
    <link rel="stylesheet" href="css/custom.css">
</head>

<script>
    function saveData() {
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'write_data_rspan.php'); // change 'write_data.php' to point to php script.
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

$sentences = getSentences($bdd);
$practice = getSentencesPrac($bdd);
$letters = array_column(getLetters($bdd), 'letter');

shuffle($letters);
$letters_grid = $letters;
shuffle($letters_grid);
$letters_both = $letters_grid;
shuffle($letters_both);
$letters_main = $letters_both;
shuffle($letters_main);

$tr_nb = 3;
$both_nb = 3;
$both_size = 2;

// Sizes range from 4-6 with 2 trials for each size
$main_sizes = [4, 4, 5, 5, 6, 6];
//$main_sizes = [2];
?>

<script>

    var subject_id = <?php echo $_GET['id']; ?>;
    jsPsych.data.addProperties({
        subject_id: subject_id,
    });

    var feedback_time = 1500;
    var sentences_timeout = 1000;
    var sentences_time = [];
    var sentences_correct_training = [];

    // timeline creation
    var timeline = [];

    timeline.push({
        type: 'fullscreen',
        fullscreen_mode: true
    });

    // welcome message
    var welcome = {
        type: 'instructions',
        pages: ["<h1>Bienvenue</h1> Merci de participer à cette expérience." +
        "<p>Identifiant : <b>" + subject_id + "</b></p>"],
        show_clickable_nav: true,
        data: {
            part: "instruction",
        }
    }
    timeline.push(welcome);

    // instructions
    var instructions_training_recall = {
        type: 'instructions',
        pages: [
            "<h2>Présentation générale</h2>" +
            "<p>Dans cette tâche, il vous sera demandé de mémoriser des lettres qui s'affichent à l'écran pendant que vous lisez des phrases.</p>" +
            "<p>Un entrainement à la tâche vous permettra de vous familiariser.</p>" +
            "<p>Nous commencerons par s'entrainer à la mémorisation et au rappel des lettres.</p>",
            "<h2>Tâche de rappel</h2>" +
            "<p>Pour cette tâche, des lettres vont apparaitre à l'écran une après l'autre. Essayez de vous rappeler les lettres dans l'ordre présenté.</p>" +
            "<p>Après 2-3 lettres présentées, sur l'écran s'affichera une grille avec les 12 lettres possibles.</p>" +
            "<p>Vous devrez rappeler les lettres en cliquant sur les boutons correspondants de la grille puis sur '<i>Continuer</i>'.</p>" +
            "<p>Si vous faites une erreur, vous pouvez appuyer sur le bouton '<i>Effacer</i>' pour recommencer votre saisie.</p>" +
            "<p>Si vous avez oublié une lettre, vous pouvez appuyer sur le button '<i>_</i>'.</p>" +
            "<p><b><i>Cliquez sur 'Suivant' pour commencer l'entrainement au rappel.</i></b></p>"
        ],
        show_clickable_nav: true,
        data: {
            part: "instruction",
        }
    }
    timeline.push(instructions_training_recall);

    // -------------------------------------------------------
    // Training letters
    // -------------------------------------------------------

    var pause_trial = {
        type: 'html-keyboard-response',
        stimulus: "",
        trial_duration: 1500,
        choices: "",
        data: {
            part: "pause",
        }
    }
    timeline.push(pause_trial);

    <?php
    for ($i = 0; $i < $tr_nb; $i++) {
    ?>
    var training_trial = {
        type: 'html-keyboard-response',
        stimulus: "<p class='mono' style='font-size: 2.5em' ><?php echo $letters[$i] ?></p>",
        trial_duration: 1000,
        choices: "",
        post_trial_gap: 300,
        data: {
            part: "training-letters",
        }
    }
    timeline.push(training_trial);
    <?php
    }
    ?>

    var btn_clicked = '';
    var htmlgrid = '<table style="margin: auto" >' +
        '<tr>' +
        '<td><button class="jspsych-btn mono" id="1" onclick="btn_clicked = getInputGrid(this, btn_clicked)" type="button"><?php echo $letters_grid[0] ?></button></td>' +
        '<td><button class="jspsych-btn mono" id="2" onclick="btn_clicked = getInputGrid(this, btn_clicked)" type="button"><?php echo $letters_grid[1] ?></button></td>' +
        '<td><button class="jspsych-btn mono" id="3" onclick="btn_clicked = getInputGrid(this, btn_clicked)" type="button"><?php echo $letters_grid[2] ?></button></td>' +
        '</tr>' +
        '<tr>' +
        '<td><button class="jspsych-btn mono" id="1" onclick="btn_clicked = getInputGrid(this, btn_clicked)" type="button"><?php echo $letters_grid[3] ?></button></td>' +
        '<td><button class="jspsych-btn mono" id="2" onclick="btn_clicked = getInputGrid(this, btn_clicked)" type="button"><?php echo $letters_grid[4] ?></button></td>' +
        '<td><button class="jspsych-btn mono" id="3" onclick="btn_clicked = getInputGrid(this, btn_clicked)" type="button"><?php echo $letters_grid[5] ?></button></td>' +
        '</tr>' +
        '<tr>' +
        '<td><button class="jspsych-btn mono" id="1" onclick="btn_clicked = getInputGrid(this, btn_clicked)" type="button"><?php echo $letters_grid[6] ?></button></td>' +
        '<td><button class="jspsych-btn mono" id="2" onclick="btn_clicked = getInputGrid(this, btn_clicked)" type="button"><?php echo $letters_grid[7] ?></button></td>' +
        '<td><button class="jspsych-btn mono" id="3" onclick="btn_clicked = getInputGrid(this, btn_clicked)" type="button"><?php echo $letters_grid[8] ?></button></td>' +
        '</tr>' +
        '<tr>' +
        '<td><button class="jspsych-btn mono" id="1" onclick="btn_clicked = getInputGrid(this, btn_clicked)" type="button"><?php echo $letters_grid[9] ?></button></td>' +
        '<td><button class="jspsych-btn mono" id="2" onclick="btn_clicked = getInputGrid(this, btn_clicked)" type="button"><?php echo $letters_grid[10] ?></button></td>' +
        '<td><button class="jspsych-btn mono" id="3" onclick="btn_clicked = getInputGrid(this, btn_clicked)" type="button"><?php echo $letters_grid[11] ?></button></td>' +
        '</tr>' +
        '</table>' +
        '<p><button class="jspsych-btn mono" id="supp" onclick="btn_clicked =  getInputGrid(this, btn_clicked)" style="font-size: 1em" type="button" >_</button></p>' +
        '<p><input class="mono" type="text" name="response" id="resp" style="font-size: 1.3em; text-align: center" ></p>' +
        '<p><button class="jspsych-btn" id="supp" onclick="btn_clicked =  removeInput()" style="background-color: grey; font-size: 1em" type="button" >Effacer</button></p>'

    var training_recall = {
        type: 'survey-html-form',
        preamble: '<h2>Rappel :</h2>',
        html: htmlgrid,
        data: {
            correct_letters: '<?php for ($i = 0; $i < $tr_nb; $i++) {
                echo $letters[$i];
            } ?>',
            part: "training-recall"
        },
        on_finish: function (data) {
            data.letters_recalled = JSON.parse(data.responses).response;
            if (data.correct_letters === data.letters_recalled) {
                data.correct = 1;
            } else {
                data.correct = 0;
            }
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
                return "<h2>Correct !</h2>";
            } else {
                return "<h2>Faux.</h2>"
            }
        },
        data: {
            part: "feedback",
        }
    }
    timeline.push(feedback);


    // ----------------------

    timeline.push(pause_trial);

    <?php
    shuffle($letters);
    for ($i = 0; $i < $tr_nb + 1; $i++) {
    ?>
    var training_trial_2 = {
        type: 'html-keyboard-response',
        stimulus: "<p class='mono'  style='font-size: 2.5em'  ><?php echo $letters[$i] ?></p>",
        trial_duration: 1000,
        choices: "",
        post_trial_gap: 300,
        data: {
            part: "training-letters",
        }
    }
    timeline.push(training_trial_2);
    <?php
    }
    ?>

    btn_clicked = '';
    htmlgrid = '<table style="margin: auto" >' +
        '<tr>' +
        '<td><button class="jspsych-btn mono" id="1" onclick="btn_clicked = getInputGrid(this, btn_clicked)" type="button"><?php echo $letters_grid[0] ?></button></td>' +
        '<td><button class="jspsych-btn mono" id="2" onclick="btn_clicked = getInputGrid(this, btn_clicked)" type="button"><?php echo $letters_grid[1] ?></button></td>' +
        '<td><button class="jspsych-btn mono" id="3" onclick="btn_clicked = getInputGrid(this, btn_clicked)" type="button"><?php echo $letters_grid[2] ?></button></td>' +
        '</tr>' +
        '<tr>' +
        '<td><button class="jspsych-btn mono" id="1" onclick="btn_clicked = getInputGrid(this, btn_clicked)" type="button"><?php echo $letters_grid[3] ?></button></td>' +
        '<td><button class="jspsych-btn mono" id="2" onclick="btn_clicked = getInputGrid(this, btn_clicked)" type="button"><?php echo $letters_grid[4] ?></button></td>' +
        '<td><button class="jspsych-btn mono" id="3" onclick="btn_clicked = getInputGrid(this, btn_clicked)" type="button"><?php echo $letters_grid[5] ?></button></td>' +
        '</tr>' +
        '<tr>' +
        '<td><button class="jspsych-btn mono" id="1" onclick="btn_clicked = getInputGrid(this, btn_clicked)" type="button"><?php echo $letters_grid[6] ?></button></td>' +
        '<td><button class="jspsych-btn mono" id="2" onclick="btn_clicked = getInputGrid(this, btn_clicked)" type="button"><?php echo $letters_grid[7] ?></button></td>' +
        '<td><button class="jspsych-btn mono" id="3" onclick="btn_clicked = getInputGrid(this, btn_clicked)" type="button"><?php echo $letters_grid[8] ?></button></td>' +
        '</tr>' +
        '<tr>' +
        '<td><button class="jspsych-btn mono" id="1" onclick="btn_clicked = getInputGrid(this, btn_clicked)" type="button"><?php echo $letters_grid[9] ?></button></td>' +
        '<td><button class="jspsych-btn mono" id="2" onclick="btn_clicked = getInputGrid(this, btn_clicked)" type="button"><?php echo $letters_grid[10] ?></button></td>' +
        '<td><button class="jspsych-btn mono" id="3" onclick="btn_clicked = getInputGrid(this, btn_clicked)" type="button"><?php echo $letters_grid[11] ?></button></td>' +
        '</tr>' +
        '</table>' +
        '<p><button class="jspsych-btn mono" id="supp" onclick="btn_clicked =  getInputGrid(this, btn_clicked)" style="font-size: 1em" type="button" >_</button></p>' +
        '<p><input class="mono" type="text" name="response" id="resp" style="font-size: 1.3em; text-align: center" ></p>' +
        '<p><button class="jspsych-btn" id="supp" onclick="btn_clicked =  removeInput()" style="background-color: grey; font-size: 1em" type="button" >Effacer</button></p>'


    var training_recall_2 = {
        type: 'survey-html-form',
        preamble: '<h2>Rappel :</h2>',
        html: htmlgrid,
        data: {
            correct_letters: '<?php for ($i = 0; $i < $tr_nb + 1; $i++) {
                echo $letters[$i];
            } ?>',
            part: "training-recall"
        },
        on_start: function () {
            btn_clicked = '';
            removeInput();
        },
        on_finish: function (data) {
            data.letters_recalled = JSON.parse(data.responses).response;
            if (data.correct_letters === data.letters_recalled) {
                data.correct = 1;
            } else {
                data.correct = 0;
            }
            console.log('Recalled:', data.letters_recalled, data.correct);
        }
    }
    timeline.push(training_recall_2);

    var feedback_2 = {
        type: 'html-keyboard-response',
        trial_duration: feedback_time,
        choices: "",
        stimulus: function () {
            var last_trial_correct = jsPsych.data.get().last(1).values()[0].correct;
            if (last_trial_correct) {
                return "<h2>Correct !</h2>";
            } else {
                return "<h2>Faux.</h2>"
            }
        },
        data: {
            part: "feedback",
        }
    }
    timeline.push(feedback_2);

    // ----------------------------------------------------

    timeline.push(pause_trial);

    <?php
    shuffle($letters);
    for ($i = 0; $i < $tr_nb + 2; $i++) {
    ?>
    var training_trial_3 = {
        type: 'html-keyboard-response',
        stimulus: "<p class='mono'  style='font-size: 2.5em'  ><?php echo $letters[$i] ?></p>",
        trial_duration: 1000,
        choices: "",
        post_trial_gap: 300,
        data: {
            part: "training-letters",
        }
    }
    timeline.push(training_trial_3);
    <?php
    }
    ?>

    btn_clicked = '';
    htmlgrid = '<table style="margin: auto" >' +
        '<tr>' +
        '<td><button class="jspsych-btn mono" id="1" onclick="btn_clicked = getInputGrid(this, btn_clicked)" type="button"><?php echo $letters_grid[0] ?></button></td>' +
        '<td><button class="jspsych-btn mono" id="2" onclick="btn_clicked = getInputGrid(this, btn_clicked)" type="button"><?php echo $letters_grid[1] ?></button></td>' +
        '<td><button class="jspsych-btn mono" id="3" onclick="btn_clicked = getInputGrid(this, btn_clicked)" type="button"><?php echo $letters_grid[2] ?></button></td>' +
        '</tr>' +
        '<tr>' +
        '<td><button class="jspsych-btn mono" id="1" onclick="btn_clicked = getInputGrid(this, btn_clicked)" type="button"><?php echo $letters_grid[3] ?></button></td>' +
        '<td><button class="jspsych-btn mono" id="2" onclick="btn_clicked = getInputGrid(this, btn_clicked)" type="button"><?php echo $letters_grid[4] ?></button></td>' +
        '<td><button class="jspsych-btn mono" id="3" onclick="btn_clicked = getInputGrid(this, btn_clicked)" type="button"><?php echo $letters_grid[5] ?></button></td>' +
        '</tr>' +
        '<tr>' +
        '<td><button class="jspsych-btn mono" id="1" onclick="btn_clicked = getInputGrid(this, btn_clicked)" type="button"><?php echo $letters_grid[6] ?></button></td>' +
        '<td><button class="jspsych-btn mono" id="2" onclick="btn_clicked = getInputGrid(this, btn_clicked)" type="button"><?php echo $letters_grid[7] ?></button></td>' +
        '<td><button class="jspsych-btn mono" id="3" onclick="btn_clicked = getInputGrid(this, btn_clicked)" type="button"><?php echo $letters_grid[8] ?></button></td>' +
        '</tr>' +
        '<tr>' +
        '<td><button class="jspsych-btn mono" id="1" onclick="btn_clicked = getInputGrid(this, btn_clicked)" type="button"><?php echo $letters_grid[9] ?></button></td>' +
        '<td><button class="jspsych-btn mono" id="2" onclick="btn_clicked = getInputGrid(this, btn_clicked)" type="button"><?php echo $letters_grid[10] ?></button></td>' +
        '<td><button class="jspsych-btn mono" id="3" onclick="btn_clicked = getInputGrid(this, btn_clicked)" type="button"><?php echo $letters_grid[11] ?></button></td>' +
        '</tr>' +
        '</table>' +
        '<p><button class="jspsych-btn mono" id="supp" onclick="btn_clicked =  getInputGrid(this, btn_clicked)" style="font-size: 1em" type="button" >_</button></p>' +
        '<p><input class="mono" type="text" name="response" id="resp" style="font-size: 1.3em; text-align: center" ></p>' +
        '<p><button class="jspsych-btn" id="supp" onclick="btn_clicked =  removeInput()" style="background-color: grey; font-size: 1em" type="button" >Effacer</button></p>'


    var training_recall_3 = {
        type: 'survey-html-form',
        preamble: '<h2>Rappel :</h2>',
        html: htmlgrid,
        data: {
            correct_letters: '<?php for ($i = 0; $i < $tr_nb + 2; $i++) {
                echo $letters[$i];
            } ?>',
            part: "training-recall"
        },
        on_start: function () {
            btn_clicked = '';
            removeInput();
        },
        on_finish: function (data) {
            data.letters_recalled = JSON.parse(data.responses).response;
            if (data.correct_letters === data.letters_recalled) {
                data.correct = 1;
            } else {
                data.correct = 0;
            }
            console.log('Recalled:', data.letters_recalled, data.correct);
        }
    }
    timeline.push(training_recall_3);

    var feedback_3 = {
        type: 'html-keyboard-response',
        trial_duration: feedback_time,
        choices: "",
        stimulus: function () {
            var last_trial_correct = jsPsych.data.get().last(1).values()[0].correct;
            if (last_trial_correct) {
                return "<h2>Correct !</h2>";
            } else {
                return "<h2>Faux.</h2>"
            }
        },
        data: {
            part: "feedback",
        }
    }
    timeline.push(feedback_3);

    // -------------------------------------------------------
    // Training sentences
    // -------------------------------------------------------

    var instructions_training_sentences = {
        type: 'instructions',
        pages: [
            "<h2>Lecture de phrases</h2>" +
            "<p>Maintenant, vous allez nous entraîner à faire la partie lecture de la phrase.</p>" +
            "<p>Une phrase en anglais apparaîtra à l'écran, comme ceci :</p>" +
            "<h3>I like to run in the park.</h3>" +
            "<p>Dès que vous voyez la phrase, vous devez la lire et déterminer si elle a un sens ou non. La phrase ci-dessus a un sens.</p>" +
            "<p>Voici un exemple de phrase qui n'a pas de sens :</p>" +
            "<h3>I like to run in the sky.</h3>" +
            "<p>Lorsque vous avez lu la phrase et déterminé si elle a un sens ou non, vous devez cliquer sur le button '<i>True</i>' si elle a du sens ou '<i>False</i>' s'il n'en a pas.</p>",
            "<h3>Lecture de phrases</h3>" +
            "<p>Il est TRÈS important que vous répondiez correctement aux problèmes de phrases. Il est également important que vous essayiez de lire les phrases le plus rapidement possible.</p>" +
            "<p><b><i>Cliquez sur 'Suivant' pour commencer l'entrainement aux phrases.</i></b></p>"
        ],
        show_clickable_nav: true,
        data: {
            part: "instruction"
        }
    }
    timeline.push(instructions_training_sentences);

    timeline.push(pause_trial);

    <?php
    for ($i = 0; $i < count($practice); $i++) {
    ?>
    var sentence_training = {
        type: 'html-button-response',
        stimulus: "<p style='font-size: 1.3em'><?php echo $practice[$i][1] ?></p>",
        choices: ['False', 'True'],
        trial_duration: 20000,
        data: {
            make_sense: <?php echo $practice[$i][2] ?>,
            part: 'training-sentence'
        },
        on_finish: function (data) {
            if (data.button_pressed === null) {
                data.button_pressed = null;
            }
            if (data.rt === null) {
                data.rt = 6000;
            }
            if (data.button_pressed === data.make_sense) {
                data.correct = 1;
            } else {
                data.correct = 0;
            }
            console.log('Make sense:', data.button_pressed, data.make_sense, data.correct, data.rt);
            sentences_time.push(data.rt);
            if (data.correct === 1) {
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
        data: {
            part: 'feedback'
        },
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
        pages: [
            "<h2>Entrainement au deux parties</h2>" +
            "<p>Vous allez maintenant vous entraîner à faire les deux parties de la tâche en même temps.</p>" +
            "<p>Dans la prochaine série de pratiques, vous aurez une phrase à lire.</p>" +
            "<p>Une fois que vous aurez pris votre décision concernant la phrase, une lettre apparaîtra à l'écran. Essayez de vous souvenir de la lettre.</p>" +
            "<p>Dans la section précédente où vous ne lisiez que les phrases, l'ordinateur a calculé votre temps moyen pour lire les phrases.</p>" +
            "<p>Si vous prenez plus de temps que votre temps moyen, l'ordinateur vous fera automatiquement passer à la partie suivante de la lettre, sautant ainsi la partie Vrai ou Faux et comptera ce problème comme une erreur de phrase.</p>" +
            "<p>Il est donc TRÈS important de lire les phrases aussi vite et aussi précisément que possible.</p>",
            "<p>Une fois la lettre disparue, une autre phrase apparaîtra, puis une autre lettre.</p>" +
            "<p>À la fin de chaque série de lettres et de phrases, un écran de rappel apparaîtra.</p>" +
            "<p>Faites de votre mieux pour mettre les lettres dans le bon ordre.</p>" +
            "<p>Il est important de travailler RAPIDEMENT et PRECISEMENT sur les phrases.</p>" +
            "<p>Assurez-vous de savoir si la phrase a un sens ou non avant de passer à l'écran suivant.</p>" +
            "<p>On ne vous dira pas si votre réponse concernant la phrase est correcte.</p>" +
            "<p>Après l'écran de rappel, vous recevrez un feedback sur votre performance concernant à la fois le nombre de lettres rappelées et le pourcentage correct sur les problèmes de phrase.</p>" +
            "<p><b><i>Cliquez sur 'Suivant' pour commencer l'entrainement.</i></b></p>"
        ],
        show_clickable_nav: true,
        data: {
            part: 'instruction'
        }
    }
    timeline.push(instructions_training_both);

    timeline.push(pause_trial);

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
        stimulus: "<p style='font-size: 1.3em'><?php echo $practice[$j][1] ?></p>",
        choices: ['False', 'True'],
        trial_duration: function () {
            console.log(sentences_timeout);
            return sentences_timeout;
        },
        data: {
            make_sense: <?php echo $practice[$j][2] ?>,
            part: 'training-both-sentence'
        },
        on_finish: function (data) {
            if (data.button_pressed === data.make_sense) {
                data.correct = 1;
            } else {
                data.correct = 0;
            }
            console.log('Make sense:', data.button_pressed, data.make_sense, data.correct);
            sentences_time.push(data.rt);
            if (data.correct === 1) {
                sentences_correct_training.push(1);
            } else {
                sentences_correct_training.push(0);
            }
        }
    }
    timeline.push(training_both_sentence);

    var training_both_letter = {
        type: 'html-keyboard-response',
        stimulus: "<p class='mono' style='font-size: 2.5em' ><?php echo $letters_both[$j] ?></p>",
        trial_duration: 1000,
        choices: "",
        post_trial_gap: 300,
        data: {
            part: 'training-both-letter'
        }
    }
    timeline.push(training_both_letter);

    <?php
    }
    ?>
    btn_clicked = '';
    htmlgrid = '<table style="margin: auto" >' +
        '<tr>' +
        '<td><button class="jspsych-btn mono" id="1" onclick="btn_clicked = getInputGrid(this, btn_clicked)" type="button"><?php echo $letters_grid[0] ?></button></td>' +
        '<td><button class="jspsych-btn mono" id="2" onclick="btn_clicked = getInputGrid(this, btn_clicked)" type="button"><?php echo $letters_grid[1] ?></button></td>' +
        '<td><button class="jspsych-btn mono" id="3" onclick="btn_clicked = getInputGrid(this, btn_clicked)" type="button"><?php echo $letters_grid[2] ?></button></td>' +
        '</tr>' +
        '<tr>' +
        '<td><button class="jspsych-btn mono" id="1" onclick="btn_clicked = getInputGrid(this, btn_clicked)" type="button"><?php echo $letters_grid[3] ?></button></td>' +
        '<td><button class="jspsych-btn mono" id="2" onclick="btn_clicked = getInputGrid(this, btn_clicked)" type="button"><?php echo $letters_grid[4] ?></button></td>' +
        '<td><button class="jspsych-btn mono" id="3" onclick="btn_clicked = getInputGrid(this, btn_clicked)" type="button"><?php echo $letters_grid[5] ?></button></td>' +
        '</tr>' +
        '<tr>' +
        '<td><button class="jspsych-btn mono " id="1" onclick="btn_clicked = getInputGrid(this, btn_clicked)" type="button"><?php echo $letters_grid[6] ?></button></td>' +
        '<td><button class="jspsych-btn mono " id="2" onclick="btn_clicked = getInputGrid(this, btn_clicked)" type="button"><?php echo $letters_grid[7] ?></button></td>' +
        '<td><button class="jspsych-btn mono " id="3" onclick="btn_clicked = getInputGrid(this, btn_clicked)" type="button"><?php echo $letters_grid[8] ?></button></td>' +
        '</tr>' +
        '<tr>' +
        '<td><button class="jspsych-btn mono" id="1" onclick="btn_clicked = getInputGrid(this, btn_clicked)" type="button"><?php echo $letters_grid[9] ?></button></td>' +
        '<td><button class="jspsych-btn mono" id="2" onclick="btn_clicked = getInputGrid(this, btn_clicked)" type="button"><?php echo $letters_grid[10] ?></button></td>' +
        '<td><button class="jspsych-btn mono" id="3" onclick="btn_clicked = getInputGrid(this, btn_clicked)" type="button"><?php echo $letters_grid[11] ?></button></td>' +
        '</tr>' +
        '</table>' +
        '<p><button class="jspsych-btn" id="supp" onclick="btn_clicked =  getInputGrid(this, btn_clicked)" style="font-size: 1em" type="button" >_</button></p>' +
        '<p><input type="text" name="response" id="resp" style="font-size: 1.3em; text-align: center" ></p>' +
        '<p><button class="jspsych-btn" id="supp" onclick="btn_clicked =  removeInput()" style="background-color: grey; font-size: 1em" type="button" >Effacer</button></p>'

    var training_both_recall = {
        type: 'survey-html-form',
        preamble: '<h2>Rappel :</h2>',
        html: htmlgrid,
        data: {
            correct_letters: '<?php for ($k = 0; $k < $both_size; $k++) {
                echo $letters_both[$k];
            } ?>',
            part: 'training-both-recall'
        },
        on_finish: function (data) {
            data.letters_recalled = JSON.parse(data.responses).response;
            if (data.correct_letters === data.letters_recalled) {
                data.correct = 1;
            } else {
                data.correct = 0;
            }
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

    var feedback_final = {
        type: 'html-keyboard-response',
        choices: [32],
        stimulus: function () {
            var recall_letters = jsPsych.data.get().filter({part: 'training-recall'}).select('correct').sum();
            console.log(recall_letters);

            var sementics = jsPsych.data.get().filter({part: 'training-sentence'}).select('correct').sum();
            console.log(sementics);

            var both_recall_score = jsPsych.data.get().filter({part: 'training-both-recall'}).select('correct').sum();
            console.log(both_recall_score);

            var both_sentences_score = jsPsych.data.get().filter({part: 'training-both-sentence'}).select('correct').sum();
            console.log(both_sentences_score)

            var printhtml = "<h1>Fin</h1>" +
                "<p>Rappel des lettres : " + recall_letters + " / 3</p>" +
                "<p>Jugement de phrases : " + sementics + " / 15</p>" +
                "<p>Rappel entrainement complet : " + both_recall_score + " / 3</p>" +
                "<p>Jugement entrainement complet : " + both_sentences_score + "/ 3</p>" +
                "<p>Appuyez sur la touche 'espace' pour envoyer les données ...</p>"

            return printhtml;
        },
        data: {
            part: "feedback",
        },
    }
    timeline.push(feedback_final);

    var fin = {
        type: 'instructions',
        pages: ["<h1>Fin</h1>" +
        "<p>Appuyez sur suivant pour envoyer les données.</p>"],
        show_clickable_nav: true,
        data: {
            part: 'fin'
        }
    }
    //timeline.push(fin);

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