jQuery(document).ready(pageInit);

function pageInit() {
    jQuery('.answer-option-btn').on('click', userAnswerAction);
    jQuery('#showAnswer').on('click', showAnswer);
}

function showAnswer() {
    var answerOptionButtons = jQuery('.answer-option-btn');
    var showAnswerButton = jQuery('#showAnswer');
    //Disable option buttons
    answerOptionButtons.unbind();
    answerOptionButtons.on('click', returnNothing);
    showAnswerButton.unbind();
    showAnswerButton.on('click', returnNothing);
    //Display message
    jQuery("#answerDescription").fadeOut(200, function() {
        jQuery(this).text("The correct answer is option " + correctAnswer.toUpperCase()).fadeIn(200);
    });
    //Light up option block
    jQuery("#question-answer-" + correctAnswer).addClass("tt-icon-box-correct");
    //Show sharing tips
    jQuery('#answer-sharing').animate({opacity: 'toggle', height: 'toggle'}, 200);
    return false;
}

function userAnswerAction() {
    var answerOptionButtons = jQuery('.answer-option-btn');
    var showAnswerButton = jQuery('#showAnswer');
    //Disable option buttons
    answerOptionButtons.unbind();
    answerOptionButtons.on('click', returnNothing);
    showAnswerButton.unbind();
    showAnswerButton.on('click', returnNothing);
    var userAnswer = jQuery(this).attr('data-answer');
    //Light up correct option block
    jQuery("#question-answer-" + correctAnswer).addClass("tt-icon-box-correct");
    //Determine if user answers correctly
    if (userAnswer.toLowerCase() == correctAnswer.toLowerCase()) {
        //Display message
        jQuery("#answerDescription").fadeOut(200, function() {
            jQuery(this).text("Your answer is correct").fadeIn(200);
        });
    } else {
        //Light up wrong option block
        jQuery("#question-answer-" + userAnswer.toLowerCase()).addClass("tt-icon-box-warning");
        //Display message
        jQuery("#answerDescription").fadeOut(200, function() {
            jQuery(this).text("The correct answer is option " + correctAnswer.toUpperCase()).fadeIn(200);
        });
    }
    //Show sharing tips
    jQuery('#answer-sharing').animate({opacity: 'toggle', height: 'toggle'}, 200);
    return false;
}

function returnNothing() {
    return false;
}