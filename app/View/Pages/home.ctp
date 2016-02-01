<?php
/**
 * @var View $this
 */
$productName = Configure::read('productName');
?>

<!-- ***************** - Main Content Area - ***************** -->
<div id="main" class="tt-slider-">
    <section id="tt-parallax-banner" data-type="background" data-speed="5" style="padding:130px 0; background-color:#2b2b2b; background-image:url('<?php echo $this->Html->url('/img/resources/homepage-hero.jpg'); ?>');">
        <div class="tt-parallax-text" style="display:none; color: black;">
            <h2>Welcome to <?php echo $productName; ?></h2>
            <p>Start your healthy life from here</p>
        </div>
    </section>
    <div class="main-area">
        <main role="main" id="content" class="content_full_width">
            <div class="video-wrap video_left">
                <div class="video-main">
                    <div class="video-frame">
                        <?php if (Configure::read('debug') <= 0): ?><iframe src="//www.youtube.com/embed/4TvGqkRcosA?autoplay=0&cc_load_policy=1&color=white&controls=0&rel=0&showinfo=0" title="Health Watcher Introduction" width="572" height="312"></iframe><?php endif; ?>
                    </div><!-- END video-frame -->
                </div><!-- END video-main -->

                <div class="video-sub">
                    <p style="font-size: 16px;"><?php echo $productName; ?> is a comprehensive website targeted at aged people in the community, that provide healthcare information including case statistics, conditions information, prevention tips and more to help people in our community know themselves better and live a healthier life.</p>
                    <p><?php echo $this->Html->link('About ' . $productName, '/aboutus', array('class' => 'ka_button medium_button medium_coolblue', 'target' => '_self')); ?></p>
                </div><!-- END video-sub -->
                <br class="clear" />
            </div><!-- END video-wrap -->
            <br class="clear" />
            <h4 class="heading-horizontal" style="margin:20px 0 40px 0;"><span>You can find these on <?php echo $productName; ?></span></h4>
            <div class="one_third tt-column">
                <div class="modern_img_frame modern_three_col_large">
                    <div class="img-preload lightbox-img">
                        <a href="<?php echo $this->Html->url(array('controller' => 'statistics', 'action'=> 'index')); ?>" class="attachment-fadeIn" title="" target="_self">
                            <div class="lightbox-zoom zoom-3 zoom-link" style="position:absolute; display: none;">&nbsp;</div>
                            <?php echo $this->Html->image('resources/homepage-trends.jpg', array('class' => 'attachment-fadeIn')) ?>
                        </a>
                    </div>
                </div>
                <h4>Case statistics</h4>
                <p>Case statistics shows an interactive data graph with data from community to help you find out which condition you may need to pay attention to. </p>
            </div>
            <div class="one_third tt-column">
                <div class="modern_img_frame modern_three_col_large">
                    <div class="img-preload lightbox-img">
                        <a href="<?php echo $this->Html->url(array('controller' => 'wikis', 'action'=> 'index')); ?>" class="attachment-fadeIn" title="" target="_self">
                            <div class="lightbox-zoom zoom-3 zoom-link" style="position:absolute; display: none;">&nbsp;</div>
                            <?php echo $this->Html->image('resources/homepage-wiki.jpg', array('class' => 'attachment-fadeIn')) ?>
                        </a>
                    </div>
                </div>
                <h4>Health Wiki</h4>
                <p>Health Wiki is an knowledge base about conditions and its prevention tips, along with useful health care information. </p>
            </div>
            <div class="one_third_last tt-column">
                <div class="modern_img_frame modern_three_col_large">
                    <div class="img-preload lightbox-img">
                        <a href="<?php echo $this->Html->url(array('controller' => 'pages', 'action'=> 'display', 'wipQuiz')); ?>" class="attachment-fadeIn" title="" target="_self">
                            <div class="lightbox-zoom zoom-3 zoom-link" style="position:absolute; display: none;">&nbsp;</div>
                            <?php echo $this->Html->image('resources/homepage-quiz.jpg', array('class' => 'attachment-fadeIn')) ?>
                        </a>
                    </div>
                </div>
                <h4>Quiz</h4>
                <p>Quiz contains simple questions that come from health wiki to help you get a deeper understanding on knowledge you just read. </p>
            </div>
        </main><!-- END main #content -->
    </div><!-- END main-area -->
    <div id="footer-top">&nbsp;</div>
</div><!-- END main -->