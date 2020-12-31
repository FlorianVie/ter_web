/*
 * Example plugin template
 */

jsPsych.plugins["recall-letters"] = (function () {

    var plugin = {};

    plugin.info = {
        name: "recall-letters",
        parameters: {
            letters_choices: {
                type: jsPsych.plugins.parameterType.STRING, // BOOL, STRING, INT, FLOAT, FUNCTION, KEYCODE, SELECT, HTML_STRING, IMAGE, AUDIO, VIDEO, OBJECT, COMPLEX
                pretty_name: 'Letters choices',
                array: true,
                default: undefined
            },
        }
    }


    plugin.trial = function (display_element, trial) {

        var html_content = "<p>Test d'un paragraphe</p>";
        display_element.innerHTML = html_content;

        // start time
        var start_time = performance.now();

        // store response
        var response = {
            rt: null,
            button: null
        };

        // data saving
        var trial_data = {
            parameter_name: 'letters_choices'
        };

        // end trial
        jsPsych.finishTrial(trial_data);
    };

    return plugin;
})();
