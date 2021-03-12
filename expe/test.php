<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reading Span - EN</title>
    <script src="jquery.js"></script>
    <script src="jspsych.js"></script>
    <script src="plugins/jspsych-html-keyboard-response.js"></script>
    <script src="plugins/button-response-grid.js"></script>
    <script src="plugins/jspsych-survey-html-form.js"></script>
    <script src="plugins/jspsych-survey-multi-select.js"></script>
    <link rel="stylesheet" href="css/jspsych.css">
</head>
<body></body>

<?php
include '../fonctions.php';
$bdd = getBD();

$sentences = getSentences($bdd);
$letters = array_column(getLetters($bdd), 'letter');

$tr_nb = 3;
shuffle($letters);

?>

<script>
    // timeline creation
    var timeline = [];

    var retranscription = {
        type: 'survey-html-form',
        html: '<h1>Vos notes :</h1>' +
            '<p><textarea name="rep" id="test-resp-box" cols="40" rows="10" style="font-family: sans-serif; font-size: 1.3em"></textarea></p>',
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

    var recall = {
        type: 'button-response-grid',
        stimulus: 'TEST',
        choices: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12'],
        margin_vertical: '20px',
        margin_horizontal: '20px',
    }
    timeline.push(recall);

    function getInputGrid(button, btn_clicked) {
        btn_clicked += $(button).text();
        $('#resp').val(btn_clicked);
        return btn_clicked;
    }

    function removeInput() {
        $('#resp').val("")
    }

    var btn_clicked = '';
    var htmlgrid = '<table style="margin: auto" >' +
        '<tr>' +
        '<td><button class="jspsych-btn" id="1" onclick="btn_clicked = getInputGrid(this, btn_clicked)" type="button">A</button></td>' +
        '<td><button class="jspsych-btn" id="2" onclick="btn_clicked = getInputGrid(this, btn_clicked)" type="button">B</button></td>' +
        '<td><button class="jspsych-btn" id="3" onclick="btn_clicked = getInputGrid(this, btn_clicked)" type="button">C</button></td>' +
        '</tr>' +
        '<tr>' +
        '<td><button class="jspsych-btn" id="1" onclick="btn_clicked = getInputGrid(this, btn_clicked)" type="button">A</button></td>' +
        '<td><button class="jspsych-btn" id="2" onclick="btn_clicked = getInputGrid(this, btn_clicked)" type="button">B</button></td>' +
        '<td><button class="jspsych-btn" id="3" onclick="btn_clicked = getInputGrid(this, btn_clicked)" type="button">C</button></td>' +
        '</tr>' +
        '<tr>' +
        '<td><button class="jspsych-btn" id="1" onclick="btn_clicked = getInputGrid(this, btn_clicked)" type="button">A</button></td>' +
        '<td><button class="jspsych-btn" id="2" onclick="btn_clicked = getInputGrid(this, btn_clicked)" type="button">B</button></td>' +
        '<td><button class="jspsych-btn" id="3" onclick="btn_clicked = getInputGrid(this, btn_clicked)" type="button">C</button></td>' +
        '</tr>' +
        '<tr>' +
        '<td><button class="jspsych-btn" id="1" onclick="btn_clicked = getInputGrid(this, btn_clicked)" type="button">A</button></td>' +
        '<td><button class="jspsych-btn" id="2" onclick="btn_clicked = getInputGrid(this, btn_clicked)" type="button">B</button></td>' +
        '<td><button class="jspsych-btn" id="3" onclick="btn_clicked = getInputGrid(this, btn_clicked)" type="button">C</button></td>' +
        '</tr>' +
        '</table>' +
        '<p><input type="text" name="response" id="resp" style="font-size: 1.3em; text-align: center" ></p>' +
        '<p><button class="jspsych-btn" id="supp" onclick="removeInput()" style="background-color: grey; font-size: 1em" type="button" >Effacer</button></p>'

    var recall2 = {
        type: 'survey-html-form',
        preamble: '<h2>Rappel :</h2>',
        html: htmlgrid,
    }
    timeline.push(recall2);

    var formu = {
        type: 'survey-html-form',
        preamble: '<p>Retranscription :</p>',
        html: '<p><textarea name="response" id="test-resp-box" cols="60" rows="10"></textarea></p>',
        autofocus: 'test-resp-box'
    }
    timeline.push(formu);


    jsPsych.init({
        timeline: timeline,
        on_finish: function () {
            jsPsych.data.displayData();
        }
    })

</script>

</html>