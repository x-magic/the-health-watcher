<?php
/**
 * @var View $this
 * @var array $favouritePages
 * @var array $pinnedPages
 * @var array $topViewPages
 */
$this->Html->script('wiki-front-index', array('inline' => false));
?>
<div id="main">
    <div class="main-area">
        <!-- ***************** - Breadcrumbs Start Here - ***************** -->
        <div class="tools">
            <span class="tools-top"></span>
            <div class="frame">
                <h1>Health Wiki</h1>
                <p class="breadcrumb"><?php echo $this->Html->link('Home', '/') ?><span class='current_crumb'>Health Wiki</span></p>
            </div><!-- END frame -->

            <span class="tools-bottom"></span>
        </div><!-- END tools -->

        <main role="main" id="content" class="content_full_width">
            <?php if (isset($favouritePages) && count($favouritePages) > 0): ?>
                <!-- ***************** - Favourites Start Here - ***************** -->
                <h4 class="heading-horizontal" style="margin:20px 0;"><span>You may be interested in</span></h4>
                    <?php if (count($favouritePages) > 1): //Found more than one article ?>
                        <div class="one_half tt-column">
                            <div class="message_karma_coolblue colored_box" style="font-size:13px;">
                                <h6><?php echo $favouritePages[0]['Wiki']['title']; ?></h6>
                                <p>
                                    <?php echo substr(strip_tags($favouritePages[0]['Wiki']['definition']), 0, 180)."..."; ?><br />
                                </p>
                                <?php echo $this->Html->link('Click to read more', array('controller' => 'wikis', 'action' => 'view', $favouritePages[0]['Wiki']['id'], 'admin' => false), array('class' => 'pull-right')); ?>
                            </div>
                            <br class="clear" />
                        </div>
                        <div class="one_half_last tt-column">
                            <div class="message_karma_coolblue colored_box" style="font-size:13px;">
                                <h6><?php echo $favouritePages[1]['Wiki']['title']; ?></h6>
                                <p>
                                    <?php echo substr(strip_tags($favouritePages[1]['Wiki']['definition']), 0, 180)."..."; ?><br />
                                </p>
                                <?php echo $this->Html->link('Click to read more', array('controller' => 'wikis', 'action' => 'view', $favouritePages[1]['Wiki']['id'], 'admin' => false), array('class' => 'pull-right')); ?>
                            </div>
                            <br class="clear" />
                        </div>
                    <?php else: //only one article is found ?>
                        <div class="one_last tt-column">
                            <div class="message_karma_coolblue colored_box" style="font-size:13px;">
                                <h6><?php echo $favouritePages[0]['Wiki']['title']; ?></h6>
                                <p>
                                    <?php echo substr(strip_tags($favouritePages[0]['Wiki']['definition']), 0, 220)."..."; ?><br />
                                </p>
                                <?php echo $this->Html->link('Click to read more', array('controller' => 'wikis', 'action' => 'view', $favouritePages[0]['Wiki']['id'], 'admin' => false), array('class' => 'pull-right')); ?>
                            </div>
                            <br class="clear" />
                        </div>
                    <?php endif; ?>
                <br class="clear" />
                <p style="text-align:center;margin-top:-40px;">
                    These wiki pages come from filtered results in case statistics <br />
                    <?php echo $this->Html->link('Click here to change criteria', array('controller' => 'statistics', 'action' => 'index', 'admin' => false), array('class' => 'ka_button small_button small_skyblue')); ?>
                </p>
                <br class="clear" />
            <?php endif; ?>
            <?php if (isset($pinnedPages) && count($pinnedPages) > 0): ?>
                <!-- ***************** - Pinnedpages Start Here - ***************** -->
                <h4 class="heading-horizontal" style="margin:20px 0;"><span>Editor's choice</span></h4>
                <?php $pinnedCounter = 0;
                foreach ($pinnedPages as $pinnedPage):
                    if ($pinnedCounter%2 == 0): ?>
                        <div class="one_half tt-column">
                            <div class="message_karma_steelgreen colored_box" style="font-size:13px;">
                                <h6><?php echo $pinnedPage['Wiki']['title']; ?></h6>
                                <p>
                                    <?php echo substr(strip_tags($pinnedPage['Wiki']['definition']), 0, 170)."..."; ?><br />
                                </p>
                                <?php echo $this->Html->link('Click to read more', array('controller' => 'wikis', 'action' => 'view', $pinnedPage['Wiki']['id'], 'admin' => false), array('class' => 'pull-right')); ?>
                            </div>
                            <br class="clear" />
                        </div>
                    <?php else: ?>
                        <div class="one_half_last tt-column">
                            <div class="message_karma_steelgreen colored_box" style="font-size:13px;">
                                <h6><?php echo $pinnedPage['Wiki']['title']; ?></h6>
                                <p>
                                    <?php echo substr(strip_tags($pinnedPage['Wiki']['definition']), 0, 170)."..."; ?><br />
                                </p>
                                <?php echo $this->Html->link('Click to read more', array('controller' => 'wikis', 'action' => 'view', $pinnedPage['Wiki']['id'], 'admin' => false), array('class' => 'pull-right')); ?>
                            </div>
                            <br class="clear" />
                        </div>
                        <br class="clear" />
                    <?php endif;
                    $pinnedCounter++;
                endforeach; ?>
                <br class="clear" />
            <?php endif; ?>
            <?php if (isset($topViewPages) && count($topViewPages) > 0): ?>
                <!-- ***************** - Top Viewed Pages Start Here - ***************** -->
                <h4 class="heading-horizontal" style="margin:20px 0;"><span>Top viewed pages</span></h4>
                <?php $topViewCounter = ($pinnedCounter%2 == 0)?0:1;
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
                <br class="clear" id="wiki-index-top-viewed-more-anchor" />
                <div style="text-align: center;">
                    <a class="ka_button small_button small_skyblue" href="#" id="loadMoreTopViewPagesBtn">Click here to show more</a>
                    <div id="loadMoreTopViewPagesIndicator" style="display:none"><?php echo $this->Html->image('loading.gif'); ?></div>
                    <div id="noMorePageIndicator" style="display:none">No more page</div>
                </div>
            <?php endif; ?>
        </main><!-- END main #content -->
    </div><!-- END main-area -->
</div><!-- END main -->
<script>
    var ajaxMoreTopURL = "<?php echo $this->Html->url(array('controller' => 'wikis', 'action' => 'getMoreWiki')) ?>";
    var topViewedCount = 0;
    jQuery(document).ready(function(){
        //Bind ajax function to load more button
        jQuery('#loadMoreTopViewPagesBtn').on('click', ajaxGetMoreTopViewPages);
        //Recount number of pages
        countTopViewPages();
        //Hide load more button when definitely nothing to load
        if (topViewedCount < 4) noMoreLoad();
    });
</script>