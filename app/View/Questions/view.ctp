<?php
/**
 * @var View $this
 * @var array $question
 * @var array $filterListDisease
 */
$QuestionRandom = false;
$QuestionPreferred = false;
$QuestionCategorized = false;
$selectedCategory = $this->Session->read('Question.selectedCategory');
if (!$this->Session->read('Question.selectedCategory')) $selectedCategory = 0;

//Get preferences
if ($this->Session->consume('Question.randomlyChosen')) {
    $QuestionRandom = true;
    if ($this->Session->consume('Question.preferredChosen'))
        $QuestionPreferred = true;
    if ($selectedCategory)
        $QuestionCategorized = true;
}
//Load page-specific script
$this->Html->script('questions-view', array('inline' => false));
$this->Html->css('karma-form-standard', array('inline' => false));
$this->Html->script('chosen.jquery.min', array('inline' => false));
$this->Html->css('chosen.min', array('inline' => false));
?>
<!-- ***************** - Main Content Area - ***************** -->
<div id="main" class="tt-slider-karma-custom-jquery-3">
    <div class="main-area">
        <!-- ***************** - Breadcrumbs Start Here - ***************** -->
        <div class="tools">
            <span class="tools-top"></span>
            <div class="frame">
                <h1>View Quiz Question</h1>
                <p class="breadcrumb"><?php echo $this->Html->link('Home', '/') ?><?php echo $this->Html->link('Quiz', array('controller' => 'questions', 'action' => 'index')) ?><span class='current_crumb'>View Question</span></p>
            </div><!-- END frame -->
            <span class="tools-bottom"></span>
        </div><!-- END tools -->
        <main role="main" id="content" class="content_full_width">
            <?php if ($QuestionRandom): ?>
            <div class="callout2" style="margin-top: -20px; margin-bottom: 20px; text-align: center;">
                <div>You may filter questions by a specific category: <span style="text-align: left;"><?php echo $this->Form->select('formDisease', $filterListDisease, array('empty' => '-- No filter --', 'class' => 'chosen-select', 'value' => $selectedCategory)) ?></span></div>
            </div><!-- END callout2 -->
            <div class="callout2" style="margin-top: -20px; margin-bottom: 10px; text-align: center;">
                <span>
                    Following question is randomly selected<?php if($QuestionPreferred): ?><?php if($QuestionCategorized): ?> in <?php echo $question['VhissDisease']['value']; ?> <?php else: ?> and customized by filtered results in case statistics page<?php endif; ?><?php endif; ?> for you.
                </span>
            </div><!-- END callout2 -->
            <?php endif; ?>
            <div class="tt-testimonial-wrapper">
                <div class="testimonials flexslider">
                    <ul class="slides">
                        <li>
                            <blockquote>
                                <p style="font-size: 18px; line-height: 30px;"><b>Question: </b><?php echo $question['Question']['content']; ?></p>
                            </blockquote>
                        </li>
                    </ul>
                </div>
            </div><!-- END testimonials -->
            <div class="callout2" style="height: 36px;">
                <span>
                    <div id="answerDescription" style="text-align: center;">Please choose one of following answers</div>
                </span>
            </div><!-- END callout2 -->
            <br class="clearfix" />
            <?php if (empty($question['Question']['answer_d'])): ?>
                <?php if (empty($question['Question']['answer_c'])): ?>
                    <div class="row">
                        <div class="one_half tt-column">
                            <a href="#" id="question-answer-a" class="tt-icon-box answer-option-btn" data-answer="a">
                                <h4>Option A</h4>
                                <p><?php echo $question['Question']['answer_a']; ?></p>
                            </a>
                        </div>
                        <div class="one_half_last tt-column">
                            <a href="#" id="question-answer-b" class="tt-icon-box answer-option-btn" data-answer="b">
                                <h4>Option B</h4>
                                <p><?php echo $question['Question']['answer_b']; ?></p>
                            </a>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="row">
                        <div class="one_third tt-column">
                            <a href="#" id="question-answer-a" class="tt-icon-box answer-option-btn" data-answer="a">
                                <h4>Option A</h4>
                                <p><?php echo $question['Question']['answer_a']; ?></p>
                            </a>
                        </div>
                        <div class="one_third tt-column">
                            <a href="#" id="question-answer-b" class="tt-icon-box answer-option-btn" data-answer="b">
                                <h4>Option B</h4>
                                <p><?php echo $question['Question']['answer_b']; ?></p>
                            </a>
                        </div>
                        <div class="one_third_last tt-column">
                            <a href="#" id="question-answer-c" class="tt-icon-box answer-option-btn" data-answer="c">
                                <h4>Option C</h4>
                                <p><?php echo $question['Question']['answer_c']; ?></p>
                            </a>
                        </div>
                    </div>
                <?php endif; ?>
            <?php else: ?>
                <div class="row">
                    <div class="one_fourth tt-column">
                        <a href="#" id="question-answer-a" class="tt-icon-box answer-option-btn" data-answer="a">
                            <h4>Option A</h4>
                            <p><?php echo $question['Question']['answer_a']; ?></p>
                        </a>
                    </div>
                    <div class="one_fourth tt-column">
                        <a href="#" id="question-answer-b" class="tt-icon-box answer-option-btn" data-answer="b">
                            <h4>Option B</h4>
                            <p><?php echo $question['Question']['answer_b']; ?></p>
                        </a>
                    </div>
                    <div class="one_fourth tt-column">
                        <a href="#" id="question-answer-c" class="tt-icon-box answer-option-btn" data-answer="c">
                            <h4>Option C</h4>
                            <p><?php echo $question['Question']['answer_c']; ?></p>
                        </a>
                    </div>
                    <div class="one_fourth_last tt-column">
                        <a href="#" id="question-answer-d" class="tt-icon-box answer-option-btn" data-answer="d">
                            <h4>Option D</h4>
                            <p><?php echo $question['Question']['answer_d']; ?></p>
                        </a>
                    </div>
                </div>
            <?php endif; ?>
            <p style="text-align: center; clear: both;">
                <a href="#" id="showAnswer" class="ka_button small_button small_limegreen">Just show me the answer</a>
                <?php echo $this->Html->link('Go to another question', array('controller' => 'questions', 'action' => 'index', 'admin' => false), array('class' => 'ka_button small_button small_skyblue')); ?>
            </p>
            <div style="text-align: center; clear: both; font-size: 14px;">
                This question is realted to: <?php echo $question['VhissDisease']['value']; ?>
                <p id="answer-sharing" style="display: none;">You may share this question with your friend using social network services</p>
            </div>
        </main><!-- END main #content -->
    </div><!-- END main-area -->
    <div id="footer-top">&nbsp;</div>
</div><!-- END main -->
<!-- answer of question -->
<script>
    var correctAnswer = "<?php echo $question['Question']['answer']; ?>";
    jQuery(document).ready(function(){
        //Load chosen
        $(".chosen-select").chosen({allow_single_deselect:true,disable_search_threshold: 5});
        //Set category id when user uses the filter
        $(".chosen-select").chosen().change(function(){
            window.location.href = "<?php echo $this->Html->url(array('action' => 'selectCategory')) ?>" + "/" + $(this).val();
        });
    });
</script>