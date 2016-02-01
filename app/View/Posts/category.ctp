<?php
/**
 * @var View $this
 * @var array $threads
 * @var array $disease
 * @var bool $isAuthorized
 */
$this->Html->script('posts-front-category', array('inline' => false));
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
                <h1>Forum of <?php echo $disease['VhissDisease']['value']; ?></h1>
                <p class="breadcrumb">
                    <?php echo $this->Html->link('Home', '/'); ?>
                    <?php echo $this->Html->link('Discussion', array('action' => 'index')); ?>
                    <span class='current_crumb'><?php echo $disease['VhissDisease']['value']; ?></span>
                </p>
            </div><!-- END frame -->
            <span class="tools-bottom"></span>
        </div><!-- END tools -->
        <main role="main" id="content" class="content_full_width">
            <h4 class="heading-horizontal" style="margin:0 0 30px 0;"><span>Please choose one of follwing threads</span></h4>
            <?php foreach($threads as $thread): ?>
            <div class="tab-box ui-tabs-panel ui-widget-content ui-corner-bottom forum-category-item">
                <h4 class="pull-left"><i class="fa fa-chevron-right"></i>
                    <?php echo $this->Html->link($thread['Post']['title'], array('action' => 'thread', $thread['Post']['id'])); ?>
                </h4>
                <h5 class="pull-right">
                    By <b><?php echo $thread['Post']['username']; ?></b> <?php echo $this->Time->timeAgoInWords($thread['Post']['time']); ?>
                </h5>
            </div>
            <?php endforeach; ?>
            <br class="clear" id="more-thread-anchor" />
            <div style="text-align: center; padding: 20px 0;">
                <a class="ka_button small_button small_skyblue" href="#" id="loadMorePostBtn">Click here to show more</a>
                <div id="loadMorePostIndicator" style="display:none"><?php echo $this->Html->image('loading.gif'); ?></div>
                <div id="noMorePostIndicator" style="display:none">No more thread</div>
            </div>
            <?php if (empty($currentFbUserID)): ?>
                <div style="text-align: center; padding: 40px 0;">
                    <div>Please login to start new thread</div>
                    <div><?php echo $this->Html->link($this->Html->image('fb_login.png', array('alt' => 'Facebook Login')), array('controller' => 'fb', 'action' => 'login'), array('escape' => false)); ?></div>
                </div>
            <?php else: ?>
                <?php echo $this->Form->create('Post', array('action' => 'addpost', 'class' => 'comment-form')); ?>
                <h2><i class="fa fa-pencil-square-o discussion-title"></i>Start a new thread</h2>
                <p class="comment-input-wrap pad comment-title">
                    <?php echo $this->Form->input('title', array('class' => 'comment-input', 'div' => false, 'label' => false, 'placeholder' => 'Please write thread title here', 'size' => 60)); ?>
                </p>
                <p class="comment-textarea-wrap">
                    <?php echo $this->Form->textarea('content', array('class' => 'comment-textarea forum-reply', 'tabindex' => 4, 'rows' => 5, 'placeholder' => 'Please write thread content before send.')); ?>
                    <?php echo $this->Form->hidden('disease_id', array('value' => $disease['VhissDisease']['id'])); ?>
                </p>
                <p class="form-submit">
                    <?php echo $this->Form->submit('Add thread', array('div' => false, 'id' => 'ka-comment-form-submit', 'disabled' => true)); ?>
                    <?php echo $this->Html->link($this->Html->image('fb_logout.png', array('alt' => 'Facebook Logout')), array('controller' => 'fb', 'action' => 'logout'), array('class' => 'pull-right', 'escape' => false)); ?>
                </p>
                <?php echo $this->Form->end(); ?>
            <?php endif; ?>
        </main><!-- END main #content -->
    </div><!-- END main-area -->
</div><!-- END main -->
<script>
    var ajaxMorePostURL = "<?php echo $this->Html->url(array('controller' => 'posts', 'action' => 'ajaxcategory')) ?>";
    var postCategory = <?php echo $disease['VhissDisease']['id'] ?>;
    var postCount = 0;
    jQuery(document).ready(function(){
        //Bind ajax function to load more button
        jQuery('#loadMorePostBtn').on('click', ajaxGetMorePosts);
        jQuery('.comment-input').on('change', checkAddContent);
        jQuery('.forum-reply').bind('input propertychange', checkAddContent);
        //Recount number of posts
        countChildThreads();
        //Hide load more button when definitely nothing to load
        if (postCount < 10) noMoreLoad();
    });
</script>