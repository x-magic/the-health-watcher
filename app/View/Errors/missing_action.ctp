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
            <div class="four_error_other">
                <div class="four_message">
                    <h1 class="four_o_four"><?php echo __d('cake_dev', 'Missing Method in %s', h($controller)); ?></h1>
                    Our Apologies, but <?php echo __d('cake_dev', 'the action %1$s is not defined in controller %2$s', '<em>' . h($action) . '</em>', '<em>' . h($controller) . '</em>'); ?>. <br />
                    <?php echo __d('cake_dev', 'Create %1$s%2$s in file: %3$s.', '<em>' . h($controller) . '::</em>', '<em>' . h($action) . '()</em>', APP_DIR . DS . 'Controller' . DS . h($controller) . '.php'); ?><br />
					<pre>
&lt;?php
class <?php echo h($controller); ?> extends AppController {
<strong>
    public function <?php echo h($action); ?>() {

    }
</strong>
}
					</pre>
                    <?php echo $this->Html->link('Back to previous page', $this->request->referer(), array('class' => 'ka_button small_button small_skyblue')); ?>
                </div><!-- END four_message -->
            </div><!-- END four_error -->
            <div class="tt-testimonial-wrapper">
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
        </main><!-- END main #content -->
    </div><!-- END main-area -->
</div><!-- END main -->