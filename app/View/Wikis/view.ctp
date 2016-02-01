<?php
/**
 * @var View $this
 * @var array $wiki
 * @var array $psa
 */
?>
<!-- ***************** - Main Content Area - ***************** -->
<div id="main" class="tt-slider-karma-custom-jquery-3">
    <div class="main-area">
        <!-- ***************** - Breadcrumbs Start Here - ***************** -->
        <?php if (isset($wikiPreview) && $wikiPreview == true): ?>
        <div class="karma_notify message_yellow">
            <p>This page is unpublished. <br />To allow public to view this page, <?php echo $this->Html->link('click here', array('controller' => 'wikis', 'action' => 'index', 0, 'admin' => true)); ?></p>
        </div>
        <?php endif; ?>
        <div class="tools">
            <span class="tools-top"></span>
            <div class="frame">
                <h1><?php echo $wiki['Wiki']['title']; ?></h1>
                <p class="breadcrumb">
                    <?php echo $this->Html->link('Home', '/') ?>
                    <?php echo $this->Html->link('Health Wiki', array('controller' => 'wikis', 'action' => 'index')) ?>
                    <span class='current_crumb'>Wiki Article</span>
                </p>
            </div><!-- END frame -->
        </div><!-- END tools -->

        <?php if (!empty($wiki['Wiki']['source'])):
            if (!empty($wiki['Wiki']['url'])): ?>
                <p class="wiki-source">Source: <?php echo $this->Html->link($wiki['Wiki']['source'], $wiki['Wiki']['url']); ?></p>
            <?php else: ?>
                <p class="wiki-source">Source: <?php echo $wiki['Wiki']['source']; ?></p>
            <?php endif; ?>
        <?php endif; ?>

        <nav role="navigation" id="sub_nav">
            <ul class="sub-menu">
                <li><a href="#section-definition" class="sidebar-scroll" data-id="section-definition" >Definition</a></li>
                <?php if (!empty($wiki['Wiki']['symptoms'])): ?><li><a href="#section-symptoms" class="sidebar-scroll" data-id="section-symptoms" >Symptoms</a></li><?php endif; ?>
                <?php if (!empty($wiki['Wiki']['cause'])): ?><li><a href="#section-cause" class="sidebar-scroll" data-id="section-cause" >Cause</a></li><?php endif; ?>
                <?php if (!empty($wiki['Wiki']['complications'])): ?><li><a href="#section-complications" class="sidebar-scroll" data-id="section-complications" >Complications</a></li><?php endif; ?>
                <?php if (!empty($wiki['Wiki']['prevention'])): ?><li><a href="#section-prevention" class="sidebar-scroll" data-id="section-prevention" >Prevention</a></li><?php endif; ?>
                <?php if (!empty($wiki['Wiki']['other'])): ?><li><a href="#section-other" class="sidebar-scroll" data-id="section-other" >Other</a></li><?php endif; ?>
                <li><div style="height: 15px;"></div></li>
                <li><a href="https://www.google.com.au/search?q=<?php echo urlencode($wiki['Wiki']['title']); ?>" class="sidebar-scroll" target="_blank">Search in Google</a></li>
                <li><a href="https://en.wikipedia.org/w/index.php?search=<?php echo urlencode($wiki['Wiki']['title']); ?>" class="sidebar-scroll" target="_blank">Search in Wikipedia</a></li>
                <li><a href="http://agencysearch.australia.gov.au/search/search.cgi?collection=agencies&client=445556fb&query=<?php echo urlencode($wiki['Wiki']['title']); ?>" class="sidebar-scroll" target="_blank">Search in Department of Health</a></li>
            </ul>
        </nav><!-- END sub_nav -->

        <main role="main" id="content" class="content_sidebar content_right_sidebar">
            <h3 class="heading-horizontal" style="margin:0 0 15px 0;" id="section-definition"><span>Definition</span></h3>
            <div class="callout2 callout-wiki-content">
                <?php echo $wiki['Wiki']['definition']; ?>
            </div>
            <br class="clear" />
            <?php if (!empty($wiki['Wiki']['symptoms'])): ?>
                <h3 class="heading-horizontal" style="margin:0 0 15px 0;" id="section-symptoms"><span>Symptoms</span></h3>
                <div class="callout2 callout-wiki-content">
                    <?php echo $wiki['Wiki']['symptoms']; ?>
                </div>
                <br class="clear" />
            <?php endif; ?>
            <?php if (!empty($wiki['Wiki']['cause'])): ?>
                <h3 class="heading-horizontal" style="margin:0 0 15px 0;" id="section-cause"><span>Cause</span></h3>
                <div class="callout2 callout-wiki-content">
                    <?php echo $wiki['Wiki']['cause']; ?>
                </div>
                <br class="clear" />
            <?php endif; ?>
            <?php if (!empty($wiki['Wiki']['complications'])): ?>
                <h3 class="heading-horizontal" style="margin:0 0 15px 0;" id="section-complications"><span>Complications</span></h3>
                <div class="callout2 callout-wiki-content">
                    <?php echo $wiki['Wiki']['complications']; ?>
                </div>
                <br class="clear" />
            <?php endif; ?>
            <?php if (!empty($wiki['Wiki']['prevention'])): ?>
                <h3 class="heading-horizontal" style="margin:0 0 15px 0;" id="section-prevention"><span>Prevention</span></h3>
                <div class="callout2 callout-wiki-content">
                    <?php echo $wiki['Wiki']['prevention']; ?>
                </div>
                <br class="clear" />
            <?php endif; ?>
            <?php if (!empty($wiki['Wiki']['other'])): ?>
                <h3 class="heading-horizontal" style="margin:0 0 15px 0;" id="section-other"><span>Other</span></h3>
                <div class="callout2 callout-wiki-content">
                    <?php echo $wiki['Wiki']['other']; ?>
                </div>
                <br class="clear" />
            <?php endif; ?>
        </main><!-- END main #content -->
        <aside role="complementary" id="sidebar">
            <div class="sidebar-widget">
                <h4>Nearby Health Service Providers</h4>
                <div class="textwidget">
                    <p>Finding nearest health service providers on an interactive map</p>
                    <p><?php echo $this->Html->link('Go to map', '/servicemap', array('class' => 'ka_button small_button small_skyblue')); ?></p>
                </div>
            </div>
            <?php if (count($psa) > 0): ?>
            <div class="sidebar-widget">
                <h4>Public Service Announcements</h4>
                <ul class="accordion accordionPSA">
                    <?php foreach($psa as $announcement): ?>
                    <li>
                        <a href="#" class="accordion-title"><strong><?php echo $this->Time->format($announcement['Announcement']['date'], '%e %B, %Y'); ?></strong></a>
                        <div class="slide-holder">
                            <p><?php echo $announcement['Announcement']['content']; ?></p>
                        </div>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php endif; ?>
            <div class="sidebar-widget">
                <h4>Discussion Forum</h4>
                <div class="textwidget">
                    <p>Share your experience with others online in forum of <?php echo $wiki['VhissDisease']['value']; ?> </p>
                    <p><?php echo $this->Html->link('Go to forum', array('controller' => 'posts', 'action' => 'category', $wiki['VhissDisease']['id']), array('class' => 'ka_button small_button small_skyblue')); ?></p>
                </div>
            </div>
        </aside><!-- END sidebar -->
    </div>
    <!-- END main-area -->
    <div id="footer-top">&nbsp;</div>
</div><!-- END main -->
<script>
    jQuery(document).ready(function () {
        //Bind sidebar links to
        jQuery('.sidebar-scroll').on('click', scrollToWikiSection);
        <?php if (count($psa) > 0): ?>
        //Kickstart accordion
        jQuery( ".accordionPSA" ).accordion(
            {
                active: 0,
                autoHeight: false,
                heightStyle: "content",
                header: ".accordion-title",
                collapsible: false,
                event: "click"
            }
        );
        <?php endif; ?>
    });
    function scrollToWikiSection() {
        var currentID = '#'+jQuery(this).attr('data-id');
        $('html,body').animate({
            scrollTop: $(currentID).offset().top - 120
        }, 750);
    }
</script>
