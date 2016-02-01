<?php //This page doesn't have any layout since its output will be inserted into HTML directly.
$fbUser = $this->Session->read('fbUser');
$currentFbUserID = ($this->Session->check('fbUser') && !empty($fbUser))?$fbUser['id']:null;
if (isset($ajaxPosts) && count($ajaxPosts) > 0): ?>
    <?php foreach ($ajaxPosts as $ajaxPost): ?>
        <li class="comment depth-2 childThread" >
            <div class="comment-content" >
                <div class="comment-gravatar">
                    <?php echo $this->Html->image('https://graph.facebook.com/'.$ajaxPost['Post']['userid'].'/picture', array('class' => 'avatar avatar-60 photo', 'height' => 60, 'width' => 60)); ?>
                </div><!-- END comment-gravatar -->
                <div class="comment-text">
                    <span class="comment-author"><?php echo $ajaxPost['Post']['username']; ?></span> &nbsp;<span class="comment-date"><?php echo $this->Time->timeAgoInWords($ajaxPost['Post']['time']); ?></span><br />
                    <p><?php echo $ajaxPost['Post']['content']; ?></p>
                    <?php if ($isAuthorized || $currentFbUserID == $ajaxPost['Post']['userid']) echo $this->Form->postLink(__('Remove this thread'), array('controller' => 'posts', 'action' => 'removepost', $ajaxPost['Post']['id']), array('class' => 'comment-delete-link', 'confirm' => __('Are you sure you want to remove your thread?'))); ?>
                </div><!-- END comment-text -->
            </div><!-- END comment-content -->
        </li><!-- #comment -->
    <?php endforeach; ?>
<?php endif; ?>