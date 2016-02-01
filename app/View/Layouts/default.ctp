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
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 *
 * @var View $this
 */

$productName = Configure::read('productName');
$logoFilename = (Configure::read('debug') <= 0)?'resources/hw_logo_header.png':'resources/hw_logo_header_debug.png';
?>
<!DOCTYPE html>
<!--[if IE 7 ]><html class="ie ie7" lang="en"><![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="en"><![endif]-->
<!--[if IE 9 ]><html class="ie ie9" lang="en"><![endif]-->
<!--[if !IE]><!-->
<html lang="en-US">
<!--<![endif]-->
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <?php echo $this->Html->charset(); ?>
    <title><?php echo $this->fetch('title'); ?> - <?php echo $productName; ?></title>
    <?php echo $this->Html->meta('icon');
    echo $this->fetch('meta');

    //Load javascripts
    echo $this->Html->script('jquery.min');
    echo $this->Html->script('custom-main');
    echo $this->Html->script('superfish');
    echo $this->Html->script('jquery.flexslider');
    echo $this->Html->script('jquery.fitvids');
    echo $this->Html->script('scrollWatch');
    echo $this->Html->script('jquery.isotope');
    echo $this->Html->script('jquery.ui.core.min');
    echo $this->Html->script('jquery.ui.widget.min');
    echo $this->Html->script('jquery.ui.tabs.min');
    echo $this->Html->script('jquery.ui.accordion.min');
    echo $this->Html->script('jquery.prettyPhoto'); ?>
    <script type="text/javascript" >
        jQuery(document).ready(function() {
            jQuery('.tt-parallax-text').fadeIn(1000);
            var $window = jQuery(window);
            jQuery('section[data-type="background"]').each(function () {
                var $bgobj = jQuery(this);
                jQuery(window).scroll(function () {
                    var yPos = -($window.scrollTop() / $bgobj.data('speed'));
                    var coords = '50% ' + yPos + 'px';
                    $bgobj.css({ backgroundPosition: coords });
                });
            });
        });
    </script>
    <?php echo $this->fetch('script'); //Load scripts in views in header ?>

    <?php
    //Load stylesheets
    echo $this->Html->css('karma-googlefonts');
    echo $this->Html->css('karma-style');
    echo $this->Html->css('karma-mobile');
    echo $this->Html->css('karma-sky-blue');
    echo $this->Html->css('karma-secondary-sky-blue');
    echo $this->Html->css('font-awesome.min');
    //Load stylesheets in views in header
    echo $this->fetch('css'); ?>

    <!-- Browser-specific scripts -->
    <!--[if !IE]><!--><script>if (/*@cc_on!@*/false) { document.documentElement.className+=' ie10'; }</script><!--<![endif]-->
    <!--[if IE 9]><style media="screen">#footer, .header-holder { behavior: url('<?php echo $this->Html->url('/js/PIE/PIE.htc'); ?>'); }</style><![endif]-->
    <!--[if lte IE 8]>
    <?php echo $this->Html->script('html5shiv'); ?>
    <style media="screen">#footer, .header-holder, #horizontal_nav ul li, #horizontal_nav ul a, #tt-gallery-nav li, #tt-gallery-nav a, ul.tabset li, ul.tabset a, .karma-pages a, .karma-pages span, .wp-pagenavi a, .wp-pagenavi span, .post_date, .post_comments, .ka_button, .flex-control-paging li a, .colored_box, .tools, .karma_notify .opener, .callout_button, .testimonials { behavior: url('<?php echo $this->Html->url('/js/PIE/PIE.htc'); ?>'); }</style>
    <![endif]-->
    <!--[if IE]><?php echo $this->Html->css('karma-ie'); ?><![endif]-->

    <?php if (Configure::read('debug') <= 0): //Only activate google analytics in production mode ?>
    <!-- Google analytics -->
    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-0', 'auto');
        ga('send', 'pageview');

    </script>
    <!-- AddThis -->
    <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=0" async="async"></script>
    <?php endif; ?>
</head>
<body>

<div id="tt-wide-layout" class="content-style-default">
    <div id="wrapper">
        <header role="banner" id="header">
            <div class="top-block">
                <div class="top-holder">
                    <!-- ***************** - Top Toolbar Left Side - ***************** -->
                    <div class="toolbar-left">
                        <ul>
                            <li><?php echo $this->Html->link('Home', '/', array('style' => 'text-decoration:none!important')) ?></li>
                            <li><?php echo $this->Html->link('About us', '/aboutus', array('style' => 'text-decoration:none!important')) ?></li>
                            <li><?php echo $this->Html->link('Leave feedback', array('controller' => 'feedback', 'action' => 'add'), array('style' => 'text-decoration:none!important')) ?></li>
                        </ul>
                    </div><!-- END toolbar-left -->
                </div><!-- END top-holder -->
            </div><!-- END top-block -->

            <div class="header-holder">
                <div class="header-overlay">
                    <div class="header-area">
                        <a href="<?php echo $this->Html->url('/'); ?>" class="logo"><?php echo $this->Html->image($logoFilename, array('alt' => $productName . ' Homepage', 'class' => 'tt-retina-logo', 'width'=> 195, 'height' => 70)); ?></a>
                        <!-- ***************** - Main Menu - ***************** -->
                        <nav role="navigation">
                            <ul id="menu-main-nav">
                                <li class="<?php echo ($this->params['controller'] === "statistics")?'current_page_parent':''; ?>"><a href="<?php echo $this->Html->url(array('controller' => 'statistics', 'action' => 'index', 'admin' => false)); ?>"><span><strong>Case Statistics</strong><span class="navi-description">trends in community</span></span></a></li>
                                <li class="<?php echo ($this->params['controller'] === "wikis")?'current_page_parent':''; ?>"><a href="<?php echo $this->Html->url(array('controller' => 'wikis', 'action' => 'index', 'admin' => false)); ?>"><span><strong>Health Wiki</strong><span class="navi-description">know more about you</span></span></a></li>
                                <li class="<?php echo ($this->params['controller'] === "questions")?'current_page_parent':''; ?>"><a href="<?php echo $this->Html->url(array('controller' => 'questions', 'action' => 'index', 'admin' => false)); ?>"><span><strong>Quiz</strong><span class="navi-description">learn more about you</span></span></a></li>
                                <li class="<?php echo ($this->params['controller'] === "posts")?'current_page_parent':''; ?>"><a href="<?php echo $this->Html->url(array('controller' => 'posts', 'action' => 'index', 'admin' => false)); ?>"><span><strong>Discussion</strong><span class="navi-description">share your experience</span></span></a></li>
                            </ul>
                        </nav>
                    </div><!-- END header-area -->
                </div><!-- END header-overlay -->
            </div><!-- END header-holder -->
        </header><!-- END header -->
        <?php // echo $this->Session->flash(); //Display flash on individual page basis ?>
        <?php echo $this->fetch('content'); ?>
        <!-- ***************** - Footer Starts Here - ***************** -->
        <footer role="contentinfo" id="footer">
            <!-- ***************** - Footer Bottom Starts Here - ***************** -->
            <div id="footer_bottom">
                <div class="info">
                    <div id="foot_left">Monash University Postgraduate IE Project. Made by <a href="http://two-o-two.tk/" >team TWO-O-TWO</a>. </div><!-- END foot_left -->
                    <div id="foot_right">
                        <div class="top-footer">
                            <a href="#" class="link-top">top</a>
                        </div>
                        <ul>
                            <li><?php echo $this->Html->link('Disclaimer', '/disclaimer') ?></li>
                            <li><?php echo $this->Html->link('Cookies', '/cookies') ?></li>
                            <li><?php echo $this->Html->link('Admin login', array('controller' => 'users', 'action' => 'login')) ?></li>
                        </ul>
                    </div><!-- END foot_right -->
                </div><!-- END info -->
            </div><!-- END footer_bottom -->
        </footer><!-- END footer -->
    </div><!-- END wrapper -->
</div><!-- END tt-layout -->

</body>
</html>