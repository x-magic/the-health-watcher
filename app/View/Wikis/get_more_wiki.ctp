<?php //This page doesn't have any layout since its output will be inserted into HTML directly.
//It's almost the same stuff that can be found in "index.ctp"
if (isset($topViewPages) && count($topViewPages) > 0): ?>
    <?php $topViewCounter = 0;
    foreach ($topViewPages as $topViewPage):
        if ($topViewCounter%2 == 0): ?>
            <div class="one_half tt-column topViewBox">
                <div class="message_karma_saffronblue colored_box" style="font-size:13px;">
                    <h6><?php echo $topViewPage['Wiki']['title']; ?></h6>
                    <p>
                        <?php echo substr(strip_tags($topViewPage['Wiki']['definition']), 0, 170)."..."; ?><br />
                    </p>
                    <?php echo $this->Html->link('Click to read more', array('controller' => 'wikis', 'action' => 'view', $topViewPage['Wiki']['id'], 'admin' => false), array('class' => 'pull-right')); ?>
                </div>
                <br class="clear" />
            </div>
        <?php else: ?>
            <div class="one_half_last tt-column topViewBox">
                <div class="message_karma_saffronblue colored_box" style="font-size:13px;">
                    <h6><?php echo $topViewPage['Wiki']['title']; ?></h6>
                    <p>
                        <?php echo substr(strip_tags($topViewPage['Wiki']['definition']), 0, 170)."..."; ?><br />
                    </p>
                    <?php echo $this->Html->link('Click to read more', array('controller' => 'wikis', 'action' => 'view', $topViewPage['Wiki']['id'], 'admin' => false), array('class' => 'pull-right')); ?>
                </div>
                <br class="clear" />
            </div>
            <br class="clear" />
        <?php endif;
        $topViewCounter++;
    endforeach; ?>
<?php endif; ?>
