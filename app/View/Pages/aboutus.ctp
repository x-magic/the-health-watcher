<?php
/**
 * @var View $this
 */
$productName = Configure::read('productName');
?>
<!-- ***************** - Main Content Area - ***************** -->
<div id="main" class="tt-slider-karma-custom-jquery-3">
    <div class="main-area">
        <!-- ***************** - Breadcrumbs Start Here - ***************** -->
        <main role="main" id="content" class="content_full_width">
            <h1 class="heading-horizontal" style="margin:0 0 30px 0;"><span>About us</span></h1>

            <div class="callout2">
                <span>
                    Nowadays, the aging population is increasing in Australia has become a major issue for the society. In order to create awareness among elderly people about ponderance of diseases and provide useful information, we want to develop a website to resolve these requirements together.
                </span>
            </div><!-- END callout2 -->
            <div class="hr_gap" style="height:30px;"></div>
            <div class="callout2">
                <span>
                    <?php echo $productName; ?> uses the Internet power to spread the knowledge of elder's conditions. By analyzing the various data sets, listing the most influential diseases and providing related information, old people could pay more attention to potential symptoms and obtain prevention method and knowledge as well.
                </span>
            </div><!-- END callout2 -->
            <div class="hr_gap" style="height:30px;"></div>
            <div class="callout2">
                <span>
                    We wish your health and happiness.

                </span>
            </div><!-- END callout2 -->

            <br class="clear"/>

            <div class="hr_gap" style="height:30px;"></div>
            <h1 class="heading-horizontal" style="margin:0 0 30px 0;"><span>Our team</span></h1>

            <div class="grid-row">
                <div class="one_fourth tt-column">
                    <div class="item">
                        <div class="pic">
                            <?php echo $this->Html->image('resources/aboutus-bu.jpg', array('alt' => 'Bu', 'width' => 200, 'height' => 200)) ?>
                        </div>
                        <h3>Qingchen Bu</h3>

                        <p>Communication coordinator<br/>Master of IT</p>
                    </div>
                </div>

                <div class="one_fourth tt-column">
                    <div class="item">
                        <div class="pic">
                            <?php echo $this->Html->image('resources/aboutus-bill.jpg', array('alt' => 'Bu', 'width' => 200, 'height' => 200)) ?>
                        </div>
                        <h3>Haofei Gong</h3>

                        <p>Team leader<br/>Master of IT Professional</p>
                    </div>
                </div>
                <div class="one_fourth tt-column">
                    <div class="item">
                        <div class="pic">
                            <?php echo $this->Html->image('resources/aboutus-anchit.jpg', array('alt' => 'Bu', 'width' => 200, 'height' => 200)) ?>
                        </div>
                        <h3>Anchit Ishpunhani</h3>

                        <p>Developer<br/>Master of Business Info System</p>
                    </div>
                </div>
                <div class="one_fourth_last tt-column">
                    <div class="item">
                        <div class="pic">
                            <?php echo $this->Html->image('resources/aboutus-phoebe.jpg', array('alt' => 'Bu', 'width' => 200, 'height' => 200)) ?>
                        </div>
                        <h3>Xuefei Wang</h3>

                        <p>Developer<br/>Master of IT</p>
                    </div>
                </div>
            </div>
        </main><!-- END main #content -->
    </div><!-- END main-area -->
    <div id="footer-top">&nbsp;</div>
</div><!-- END main -->