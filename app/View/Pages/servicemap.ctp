<?php
/**
 * @var View $this
 */
$productName = Configure::read('productName');
$this->Html->script('servicemap', array('inline' => false));
?>
<!-- ***************** - Main Content Area - ***************** -->
<div id="main" class="tt-slider-karma-custom-jquery-3">
    <div class="main-area">
        <!-- ***************** - Breadcrumbs Start Here - ***************** -->
        <div class="tools">
            <span class="tools-top"></span>
            <div class="frame">
                <h1>Nearby Health Service Providers</h1>
                <p class="breadcrumb"><?php echo $this->Html->link('Home', '/') ?><?php echo $this->Html->link('Health Wiki', array('controller' => 'wikis', 'action' => 'index')) ?><span class='current_crumb'>Nearby Health Service Providers</span></p>
            </div><!-- END frame -->
            <span class="tools-bottom"></span>
        </div><!-- END tools -->
        <main role="main" id="content" class="content_full_width">
            <div id="service-map-wrap"></div>
            <br class="clear"/>
            <div class="pull-left">* To display your current location, you need to allow browser to access your location data. </div>
            <div class="pull-right">Data source: <?php echo $this->Html->link('Victorian Government Data Directory', 'https://www.data.vic.gov.au/data/dataset/hospital-locations'); ?></div>
        </main><!-- END main #content -->
    </div><!-- END main-area -->
    <div id="footer-top">&nbsp;</div>
</div><!-- END main -->
<!-- Designate KML file path -->
<script>var kmlPath = "<?php echo (Configure::read('debug') <= 0)?$this->Html->url('/files/hospitals.kmz', true):'http://dev.two-o-two.tk/hospitals.kmz'; ?>";</script>
<!-- Load Google Maps JS API -->
<script async defer src="https://maps.google.com/maps/api/js?sensor=true&callback=initHealthMap"></script>
