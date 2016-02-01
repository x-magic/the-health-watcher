<?php //This page doesn't have any layout since its output will be inserted into HTML directly.
if (isset($ajaxThreads) && count($ajaxThreads) > 0): ?>
    <?php foreach ($ajaxThreads as $ajaxThread): ?>
        <div class="tab-box ui-tabs-panel ui-widget-content ui-corner-bottom forum-category-item">
            <h4 class="pull-left"><i class="fa fa-chevron-right"></i>
                <?php echo $this->Html->link($ajaxThread['Post']['title'], array('action' => 'thread', $ajaxThread['Post']['id'])); ?>
            </h4>
            <h5 class="pull-right">
                By <b><?php echo $ajaxThread['Post']['username']; ?></b> <?php echo $this->Time->timeAgoInWords($ajaxThread['Post']['time']); ?>
            </h5>
        </div>
    <?php endforeach; ?>
<?php endif; ?>