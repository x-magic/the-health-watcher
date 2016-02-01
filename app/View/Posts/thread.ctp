<?php
/**
 * @var View $this
 * @var bool $isAuthorized
 * @var array $threads
 * @var array $subThreads
 */
$this->Html->script('posts-front-thread', array('inline' => false));

$mainThread = $threads['Post'];
$threadDisease = $threads['VhissDisease'];

//Load user's Facebook login info
$fbUser = $this->Session->read('fbUser');
$logoutURL = $this->Session->read('fbLogout');
$currentFbUserID = ($this->Session->check('fbUser') && !empty($fbUser))?$fbUser['id']:null;
?>
<div id="main">
    <div class="main-area">
        <?php if ($isAuthorized): ?>
            <div id="flash-flash" class="karma_notify message_blue" style="font-size:13px;">
                <p>You are currently logged in as an Administrator. You can remove any post. To create posts, please login using your Facebook account. </p>
            </div>
        <?php endif; ?>
        <?php echo $this->Flash->render('flash') ?>
        <!-- ***************** - Breadcrumbs Start Here - ***************** -->
        <div class="tools">
            <span class="tools-top"></span>
            <div class="frame">
                <h1><?php echo $mainThread['title'] ?></h1>
                <p class="breadcrumb">
                    <?php echo $this->Html->link('Home', '/') ?>
                    <?php echo $this->Html->link('Discussion' , array('controller' => 'posts', 'action' => 'index')) ?>
                    <?php echo $this->Html->link($threadDisease['value'] , array('controller' => 'posts', 'action' => 'category', $threadDisease['id'])) ?>
                    <span class='current_crumb'>Thread</span>
                </p>
            </div><!-- END frame -->

            <span class="tools-bottom"></span>
        </div><!-- END tools -->

        <main role="main" id="content" class="content_full_width">
            <!-- Parent thread -->
            <ol id="post-comments">
                <li class="comment odd alt thread-alt depth-1">
                    <div class="comment-content">
                        <div class="comment-gravatar">
                            <?php echo $this->Html->image('https://graph.facebook.com/'.$mainThread['userid'].'/picture', array('class' => 'avatar avatar-60 photo', 'height' => 60, 'width' => 60)); ?>
                        </div><!-- END comment-gravatar -->
                        <div class="comment-text">
                            <span class="comment-author"><?php echo $mainThread['username']; ?></span> &nbsp;<span class="comment-date"><?php echo $this->Time->timeAgoInWords($mainThread['time']); ?></span><br />
                            <p><?php echo $mainThread['content']; ?></p>
                            <?php if ($isAuthorized || $currentFbUserID == $mainThread['userid']) echo $this->Form->postLink(__('Remove this thread'), array('controller' => 'posts', 'action' => 'removepost', $mainThread['id']), array('class' => 'comment-delete-link', 'confirm' => __('Are you sure you want to remove this thread: %s? ATTENTION: All posts under this thread will be removed as well!', $mainThread['title']))); ?>
                        </div><!-- END comment-text -->
                    </div><!-- END comment-content -->
                    <!-- Child threads -->
                    <ul class="children" id="thread-children">
                        <?php foreach($subThreads as $subThread): ?>
                        <li class="comment depth-2 childThread" >
                            <div class="comment-content" >
                                <div class="comment-gravatar">
                                    <?php echo $this->Html->image('https://graph.facebook.com/'.$subThread['Post']['userid'].'/picture', array('class' => 'avatar avatar-60 photo', 'height' => 60, 'width' => 60)); ?>
                                </div><!-- END comment-gravatar -->
                                <div class="comment-text">
                                    <span class="comment-author"><?php echo $subThread['Post']['username']; ?></span> &nbsp;<span class="comment-date"><?php echo $this->Time->timeAgoInWords($subThread['Post']['time']); ?></span><br />
                                    <p><?php echo $subThread['Post']['content']; ?></p>
                                    <?php if ($isAuthorized || $currentFbUserID == $subThread['Post']['userid']) echo $this->Form->postLink(__('Remove this thread'), array('controller' => 'posts', 'action' => 'removepost', $subThread['Post']['id']), array('class' => 'comment-delete-link', 'confirm' => __('Are you sure you want to remove your thread?'))); ?>
                                </div><!-- END comment-text -->
                            </div><!-- END comment-content -->
                        </li><!-- #comment -->
                        <?php endforeach; ?>
                    </ul><!-- .children -->
                </li><!-- #comment-## -->
            </ol>
            <div style="text-align: center;">
                <a class="ka_button small_button small_skyblue" href="#" id="loadMorePostBtn">Click here to show more</a>
                <div id="loadMorePostIndicator" style="display:none"><?php echo $this->Html->image('loading.gif'); ?></div>
                <div id="noMorePostIndicator" style="display:none">No more post</div>
            </div>
            <?php if (empty($currentFbUserID)): ?>
                <div style="text-align: center; padding: 40px 0;">
                    <div>Please login to reply</div>
                    <div><?php echo $this->Html->link($this->Html->image('fb_login.png', array('alt' => 'Facebook Login')), array('controller' => 'fb', 'action' => 'login'), array('escape' => false)); ?></div>
                </div>
            <?php else: ?>
                <?php echo $this->Form->create('Post', array('action' => 'addpost', 'class' => 'comment-form')); ?>
                    <h2><i class="fa fa-pencil-square-o discussion-title"></i>Add a reply</h2>
                    <p class="comment-textarea-wrap">
                        <?php echo $this->Form->textarea('content', array('class' => 'comment-textarea forum-reply', 'tabindex' => 4, 'rows' => 5, 'placeholder' => 'Please write your reply here before send.')); ?>
                        <?php echo $this->Form->hidden('disease_id', array('value' => $mainThread['disease_id'])); ?>
                        <?php echo $this->Form->hidden('parent_id', array('value' => $mainThread['id'])); ?>
                    </p>
                    <p class="form-submit">
                        <?php echo $this->Form->submit('Send Reply', array('div' => false, 'id' => 'ka-comment-form-submit', 'disabled' => true)); ?>
                        <?php echo $this->Html->link($this->Html->image('fb_logout.png', array('alt' => 'Facebook Logout')), array('controller' => 'fb', 'action' => 'logout'), array('class' => 'pull-right', 'escape' => false)); ?>
                    </p>
                <?php echo $this->Form->end(); ?>
            <?php endif; ?>
        </main><!-- END main #content -->
    </div><!-- END main-area -->
</div><!-- END main -->
<script>
    var ajaxMorePostURL = "<?php echo $this->Html->url(array('controller' => 'posts', 'action' => 'ajaxposts')) ?>";
    var postParent = <?php echo $mainThread['id'] ?>;
    var postCount = -1;
    jQuery(document).ready(function(){
        //Bind ajax function to load more button
        jQuery('#loadMorePostBtn').on('click', ajaxGetMorePosts);
        jQuery('.forum-reply').bind('input propertychange', checkReplyContent);
        //Recount number of posts
        countChildThreads();
        //Hide load more button when definitely nothing to load
        if (postCount < 4) noMoreLoad();
    });
</script>