<?php
/**
 * @var View $this
 */
$productName = Configure::read('productName');
$this->Html->css('karma-form-standard', array('inline' => false));
?>
<div id="main">
    <div class="main-area">
        <?php echo $this->Flash->render('flash') ?>
        <div class="tools">
            <span class="tools-top"></span>
            <div class="frame">
                <h1>Feedback</h1>
                <p class="breadcrumb"><?php echo $this->Html->link('Home', '/') ?><span class='current_crumb'>Feedback </span></p>
            </div><!-- END frame -->

            <span class="tools-bottom"></span>
        </div><!-- END tools -->

        <main role="main" id="content" class="content_full_width contact_smartphone_content">
            <div class="two_thirds">
                <h3 dir="ltr">We want to hear from you.</h3>
                <p dir="ltr">Please help us make <?php echo $productName ?> better!</p>
                <!-- ***************** - START Contact Form - ***************** -->
                <div class="iphorm-outer">
                    <?php echo $this->Form->create('Feedback', array('class' => 'iphorm')); ?>
                        <div class="iphorm-wrapper">
                            <div class="iphorm-inner">
                                <div class="iphorm-message"></div>
                                <div class="iphorm-container clearfix">
                                    <!-- Begin Name element -->
                                    <div class="element-wrapper name-element-wrapper clearfix">
                                        <label for="name">Your Name <span class="required">(required)</span></label>
                                        <div class="input-wrapper name-input-wrapper">
                                            <?php echo $this->Form->input('name', array(
                                                'label' => false,
                                                'div' => false,
                                                'class' => 'name-element',
                                                'placeholder' => 'Your name here',
                                                'error' => false
                                            )); ?>
                                        </div>
                                        <span style="color: red;"><?php echo $this->Form->error('name'); ?></span>
                                    </div>
                                    <!-- End Name element -->
                                    <!-- Begin Email element -->
                                    <div class="element-wrapper email-element-wrapper clearfix">
                                        <label for="email">Your Email <span class="required">(required)</span></label>
                                        <div class="input-wrapper email-input-wrapper">
                                            <?php echo $this->Form->input('email', array(
                                                'label' => false,
                                                'div' => false,
                                                'class' => 'email-element',
                                                'placeholder' => 'Your email address here',
                                                'error' => false
                                            )); ?>
                                        </div>
                                        <span style="color: red;"><?php echo $this->Form->error('email'); ?></span>
                                    </div>
                                    <!-- End Email element -->
                                    <!-- Begin Message element -->
                                    <div class="element-wrapper message-element-wrapper clearfix">
                                        <label for="message">What do you want to share with us?  <span class="required">(required)</span></label>
                                        <div class="input-wrapper message-input-wrapper clearfix">
                                            <?php echo $this->Form->input('content', array(
                                                'label' => false,
                                                'div' => false,
                                                'type' => 'textarea',
                                                'class' => 'message-element',
                                                'placeholder' => 'Please left your feedback here, then click "send feedback" button. ',
                                                'rows' => 7,
                                                'cols' => 45,
                                                'error' => false
                                            )); ?>
                                        </div>
                                        <span style="color: red;"><?php echo $this->Form->error('content'); ?></span>
                                    </div>
                                    <!-- End Message element -->
                                    <!-- Begin Submit button -->
                                    <div class="button-wrapper submit-button-wrapper clearfix">
                                        <div class="loading-wrapper"><span class="loading"><?php echo $this->Flash->render('flash') ?></span></div>
                                        <div class="button-input-wrapper submit-button-input-wrapper">
                                            <?php echo $this->Form->submit('Send feedback', array('div' => false, 'class' => 'ka-form-submit')); ?>
                                        </div>
                                    </div>
                                    <!-- End Submit button -->
                                </div>
                            </div>
                        </div>
                    <?php echo $this->Form->end(); ?>
                </div>
                <!-- ***************** - END Contact Form - ***************** -->
                <p>&nbsp;</p>
            </div><!-- END two_thirds -->

            <div class="one_third_last">
                <?php echo $this->Html->image('resources/feedback-hero.jpg'); ?>
            </div><!-- END one_third_last -->
            <br class="clear" />

        </main><!-- END main #content -->
    </div><!-- END main-area -->

    <div id="footer-top">&nbsp;</div>
</div><!-- END main -->