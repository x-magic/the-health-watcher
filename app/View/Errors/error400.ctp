<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Errors
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
$this->layout = 'default'; //Force use front-end layout
?>

<div id="main">
	<div class="main-area">
		<main role="main" id="content" class="content_full_width">
			<div class="four_error">
				<div class="four_message">
					<h1 class="four_o_four"><?php echo $message; ?></h1>
					Our Apologies, but <?php printf(__d('cake', 'the requested address %s could not be found'), "<strong>'{$url}'</strong>"); ?>. <br />
                    Here are some links that you might find useful:
					<ul>
						<li><?php echo $this->Html->link('Back to previous page', $this->request->referer()); ?></li>
						<li><?php echo $this->Html->link('Go to home page', '/'); ?></li>
						<li><?php echo $this->Html->link('Leave a feedback', array('controller' => 'feedback', 'action' => 'add')) ?></li>
					</ul>
				</div><!-- END four_message -->
			</div><!-- END four_error -->
            <div class="tt-testimonial-wrapper" >
                <div class="testimonials flexslider">
                    <ul class="slides">
                        <li>
                            <blockquote>
                                <p style="text-align: center;">
                                    This page is missing, neither are more than 1,600 missing people in Australia.<br />
                                    To help Australian find their loved ones <br />
                                    <?php echo $this->Html->link('Click here', 'http://www.missingpersons.gov.au', array('class' => 'ka_button small_button small_skyblue', 'target' => '_blank')); ?>
                                </p>
                            </blockquote>
                        </li>
                    </ul>
                </div>
            </div><!-- END testimonials -->
            <?php if (Configure::read('debug') > 0): ?>
                <div class="tt-testimonial-wrapper" >
                    <div class="testimonials flexslider">
                        <ul class="slides">
                            <li>
                                <blockquote>
                                    <p><?php echo $this->element('exception_stack_trace'); ?></p>
                                </blockquote>
                            </li>
                        </ul>
                    </div>
                </div><!-- END testimonials -->
            <?php endif; ?>
		</main><!-- END main #content -->
	</div><!-- END main-area -->
</div><!-- END main -->