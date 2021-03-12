<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Tâche Écoute - RSPAN</title>
    <script src="jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/mathjs/8.1.1/math.js"></script>
    <script src="jspsych.js"></script>
    <script src="plugins/jspsych-html-keyboard-response.js"></script>
    <script src="plugins/jspsych-html-button-response.js"></script>
    <script src="plugins/recall-plugin.js"></script>
    <script src="plugins/jspsych-survey-html-form.js"></script>
    <script src="plugins/jspsych-instructions.js"></script>
    <script src="plugins/jspsych-fullscreen.js"></script>
    <script src="plugins/jspsych-audio-keyboard-response.js"></script>

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono&family=Lato&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/jspsych.css">
    <link rel="stylesheet" href="css/custom.css">
    <link rel="icon" type="image/svg+xml" href="../assets/thinking.svg">
</head>

<script>
    function saveData() {
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'write_data_control_rspan.php'); // change 'write_data.php' to point to php script.
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

$timeout = getTimeout($bdd, $id_sujet);
$timeout = end($timeout)[0];

$sentences = getSentences($bdd);
$sentencesPre = getSentencesPre($bdd);
$sentencesPost = getSentencesPost($bdd);
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
#$main_sizes = [2, 2];


?>

<script>
    var timeout_var = <?php echo $timeout ?>;
    console.log('Timeout :', timeout_var);

    var feedback_time = 1500;
    var sentences_timeout = timeout_var;
    var sentences_time = [];
    var sentences_correct_training = [];

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
        pages: ["<h1>Tâche d'écoute</h1>",
            "<h1>Présentation</h1>" +
            "<p>Dans cette session, vous allez écouter une conférence en anglais.</p>" +
            "<p>La durée totale de l'écoute est d'environ 30 minutes.</p>" +
            "<p>Avant de débuter l'écoute, vous effecturez une tâche Reading Span similaire à la session d'entrainement (les deux parties combinées).</p>" +
            "<p>A la fin de l'écoute, une deuxième tâche Reading Span démarrera automatiquement.</p>",
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


    var main_instuctions = {
        type: 'instructions',
        pages: [
            "<h2>Tâche Reading Span</h2>" +
            "<p>Dans la cette tâche, vous aurez une phrase à lire et vous devrez juger si elle fait du sens ou non.</p>" +
            "<p>Une fois que vous aurez pris votre décision concernant la phrase, une lettre apparaîtra à l'écran. Essayez de vous souvenir de la lettre.</p>" +
            "<p>Lors de l'entrainement, l'ordinateur a calculé votre temps moyen pour lire les phrases.</p>" +
            "<p>Si vous prenez plus de temps que votre temps moyen, l'ordinateur vous fera automatiquement passer à la partie suivante de la lettre, sautant ainsi la partie True ou False et comptera ce problème comme une erreur de phrase.</p>" +
            "<p>Il est donc TRÈS important de lire les phrases aussi vite et aussi précisément que possible.</p>",

            "<p>Une fois la lettre disparue, une autre phrase apparaîtra, puis une autre lettre.</p>" +
            "<p>À la fin de chaque série de lettres et de phrases, un écran de rappel apparaîtra.</p>" +
            "<p>Faites de votre mieux pour mettre les lettres dans le bon ordre.</p>" +
            "<p>Il est important de travailler RAPIDEMENT et PRECISEMENT sur les phrases.</p>" +
            "<p>Assurez-vous de savoir si la phrase a un sens ou non avant de passer à l'écran suivant.</p>" +
            "<p>On ne vous dira pas si votre réponse concernant la phrase est correcte.</p>" +
            "<p><b><i>Cliquez sur 'Suivant' pour commencer ...</i></b></p>"
        ],
        show_clickable_nav: true,
        data: {
            part: 'instruction'
        }
    }
    timeline.push(main_instuctions);


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
    // Pre rspan
    // ---------------------------------------

    <?php
    shuffle($main_sizes);
    $id_sentence = 0;
    for ($i = 0; $i < count($main_sizes); $i++) {
    shuffle($letters_main);
    shuffle($letters_grid);
    // Size
    for ($j = 0; $j < $main_sizes[$i]; $j++) {
    ?>
    var main_sentence = {
        type: 'html-button-response',
        stimulus: "<p style='font-size: 1.3em'><?php echo $sentencesPre[$id_sentence][1] ?></p>",
        choices: ['False', 'True'],
        trial_duration: function () {
            console.log(sentences_timeout);
            return sentences_timeout;
        },
        data: {
            make_sense: <?php echo $sentencesPre[$id_sentence][2] ?>,
            part: 'sentence-pre'
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
    timeline.push(main_sentence);

    var main_letter = {
        type: 'html-keyboard-response',
        stimulus: "<p class='mono' style='font-size: 2.5em' ><?php echo $letters_main[$j] ?></p>",
        trial_duration: 1000,
        choices: "",
        post_trial_gap: 300,
        data: {
            part: 'letter-pre'
        }
    }
    timeline.push(main_letter);

    <?php
    $id_sentence++;
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
        '<p><button class="jspsych-btn" id="supp" onclick="btn_clicked =  getInputGrid(this, btn_clicked)" style="font-size: 1em" type="button" >_</button></p>' +
        '<p><input type="text" name="response" id="resp" style="font-size: 1.3em; text-align: center" ></p>' +
        '<p><button class="jspsych-btn" id="supp" onclick="btn_clicked =  removeInput()" style="background-color: grey; font-size: 1em" type="button" >Effacer</button></p>'

    var main_recall = {
        type: 'survey-html-form',
        preamble: '<h2>Rappel :</h2>',
        html: htmlgrid,
        data: {
            correct_letters: '<?php for ($k = 0; $k < $main_sizes[$i]; $k++) {
                echo $letters_main[$k];
            } ?>',
            part: 'recall-pre',
            set_number: <?php echo $i + 1 ?>,
            size: <?php echo $main_sizes[$i] ?>
        },
        on_finish: function (data) {
            data.letters_recalled = JSON.parse(data.responses).response;
            if (data.correct_letters === data.letters_recalled) {
                data.correct = 1;
            } else {
                data.correct = 0;
            }

            console.log('Recalled:', data.letters_recalled, data.correct, data.correct_letters);
        },
        on_start: function () {
            btn_clicked = '';
            removeInput();
        }
    }
    timeline.push(main_recall);
    <?php
    }
    ?>

    // ---------------------------------------
    // ECOUTE
    // ---------------------------------------

    var instruction_retran = {
        type: 'instructions',
        pages: ["<h1>Écoute de la conférence</h1>" +
        "<p>Cette tâche consiste à écouter le discours que vous entendrez.</p>" +
        "<p>Deux phases alternent durant la tâche : une phase d'écoute et une pause.</p>" +
        "<p>Durant les phases d'écoute, vous entendrez une portion de la conférence audio.</p>" +
        "<p>Durant les phases de pause, vous pourrrez prendre des notes si vous le souhaitez dans la zone prévue à cet effet.</p>" +
        "<p>Les pauses sont calibrées pour durer un certain temps, lorsque celles-ci seront écoulées, le programme bascule automatiquement sur une nouvelle phase d'écoute.</p>" +
        "<p>Les notes qui vous prennez disparaissent durant la phase d'écoute et reviennent durant les pauses.</p>",
            "<p>Voici un exemple de la zone dans laquelle vous pourrez prendre des notes :</p>" +
            "<p><textarea name='rep-instr' id='test-instr-box' cols='40' rows='10' style='font-family: sans-serif; font-size: 1.3em' ></textarea></p>" +
            "<p>Vous pouvez essayer de taper du texte pour essayer si cela fonctionne.</p>" +
            "<p>Le curseur sera automatiquement placé dans la zone de texte, vous n'aurez pas besoin d'utiliser votre souris.</p>",
            "<h2>Attention !</h2>" +
            "<p>Lorsque la tâche de retranscription sera terminée, une deuxième tâche Reading Span démarrera automatiquement.</p>",
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

            jsPsych.pluginAPI.setTimeout(function () {
                var tonote = jsPsych.data.get().select('retransc').values;
                tonote = tonote[tonote.length - 1]
                console.log(tonote);
                if (typeof(tonote) === "undefined") {
                    setNotes("");
                } else {
                    setNotes(tonote);
                }
                document.getElementById("test-resp-box").scrollTop = document.getElementById("test-resp-box").scrollHeight;
            }, 1);
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
    // Post rspan
    // ---------------------------------------

    var pause_rspan = {
        type: 'html-keyboard-response',
        choices: [],
        trial_duration: 2000,
        post_trial_gap: 500,
        stimulus: "<h1>Reading Span</h1>",
        data: {
            part: "Pause",
        },
    }
    timeline.push(pause_rspan);

    <?php
    shuffle($main_sizes);
    $id_sentence = 0;
    for ($i = 0; $i < count($main_sizes); $i++) {
    shuffle($letters_main);
    shuffle($letters_grid);
    // Size
    for ($j = 0; $j < $main_sizes[$i]; $j++) {
    ?>
    var main_sentence_post = {
        type: 'html-button-response',
        stimulus: "<p style='font-size: 1.3em'><?php echo $sentencesPost[$id_sentence][1] ?></p>",
        choices: ['False', 'True'],
        trial_duration: function () {
            console.log(sentences_timeout);
            return sentences_timeout;
        },
        data: {
            make_sense: <?php echo $sentencesPost[$id_sentence][2] ?>,
            part: 'sentence-post'
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
    timeline.push(main_sentence_post);

    var main_letter_post = {
        type: 'html-keyboard-response',
        stimulus: "<p class='mono' style='font-size: 2.5em' ><?php echo $letters_main[$j] ?></p>",
        trial_duration: 1000,
        choices: "",
        post_trial_gap: 300,
        data: {
            part: 'letter-post'
        }
    }
    timeline.push(main_letter_post);

    <?php
    $id_sentence++;
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
        '<p><button class="jspsych-btn" id="supp" onclick="btn_clicked =  getInputGrid(this, btn_clicked)" style="font-size: 1em" type="button" >_</button></p>' +
        '<p><input type="text" name="response" id="resp" style="font-size: 1.3em; text-align: center" ></p>' +
        '<p><button class="jspsych-btn" id="supp" onclick="btn_clicked =  removeInput()" style="background-color: grey; font-size: 1em" type="button" >Effacer</button></p>'

    var main_recall_post = {
        type: 'survey-html-form',
        preamble: '<h2>Rappel :</h2>',
        html: htmlgrid,
        data: {
            correct_letters: '<?php for ($k = 0; $k < $main_sizes[$i]; $k++) {
                echo $letters_main[$k];
            } ?>',
            part: 'recall-post',
            set_number: <?php echo $i + 1 ?>,
            size: <?php echo $main_sizes[$i] ?>
        },
        on_finish: function (data) {
            data.letters_recalled = JSON.parse(data.responses).response;
            if (data.correct_letters === data.letters_recalled) {
                data.correct = 1;
            } else {
                data.correct = 0;
            }

            console.log('Recalled:', data.letters_recalled, data.correct, data.correct_letters);
        },
        on_start: function () {
            btn_clicked = '';
            removeInput();
        }
    }
    timeline.push(main_recall_post);
    <?php
    }
    ?>

    // ---------------------------------------

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

<script>
    function setNotes(n) {
        document.getElementById("test-resp-box").value = n;
    }
</script>

</html>