<?php
/**
 * @var View $this
 * @var array $plotData
 * @var array $filterListYear
 * @var array $filterListAgeGroup
 * @var array $filterListGender
 */
$productName = Configure::read('productName');

$this->Html->script('d3.min', array('inline' => false));
$this->Html->script('c3.min', array('inline' => false));
$this->Html->script('statistics.plot', array('inline' => false));
$this->Html->css('c3.min', array('inline' => false));
$this->Html->css('karma-form-standard', array('inline' => false));
$this->Html->script('chosen.jquery.min', array('inline' => false));
$this->Html->css('chosen.min', array('inline' => false));
?>
<!-- ***************** - Main Content Area - ***************** -->
<div id="main" class="tt-slider-karma-custom-jquery-3">
    <div class="main-area">
        <!-- ***************** - Breadcrumbs Start Here - ***************** -->
        <div class="tools">
            <span class="tools-top"></span>
            <div class="frame">
                <h1>Case statistics</h1>
                <p class="breadcrumb"><?php echo $this->Html->link('Home', '/') ?><span class='current_crumb'>Case statistics</span></p>
            </div><!-- END frame -->
            <span class="tools-bottom"></span>
        </div><!-- END tools -->
        <main role="main" id="content" class="content_full_width">
            <div class="callout2" style="margin-top:-40px">
                <span>
                    This page shows all individual Ambulatory Care Sensitive Conditions for selected year in Victoria State.

                </span>
            </div><!-- END callout2 -->
            <div class="callout2" id="statistics-filter">
                Please use following option to filter the graph:<br>
                <div class="one_third tt-column statistics-filter">
                    <?php echo $this->Form->select('formGender', $filterListGender, array('empty' => 'All genders', 'class' => 'chosen-select')) ?>
                </div>
                <div class="one_third tt-column statistics-filter">
                    <?php echo $this->Form->select('formAgeGroup', $filterListAgeGroup, array('empty' => 'All age groups', 'class' => 'chosen-select')) ?>
                </div>
                <div class="one_third_last tt-column statistics-filter">
                    <?php echo $this->Form->select('formYear', $filterListYear, array('empty' => 'Latest report year', 'class' => 'chosen-select')) ?>
                </div>
            </div><!-- END callout2 -->
            <br class="clear"/>
            <h3 class="heading-horizontal" style="margin:30px 0 30px 0;"><span id="plotTitle">Graph is loading</span></h3>
            <div class="callout2">
                <span>
                    <div id="chart"></div>
                    <div id="barDescription" style="text-align: center;">This graph shows top 5 mostly happened conditions among population group<br>Click any bar to reveal trend of condition by report years</div>
                    <div id="splineDescription" style="text-align: center;display: none;">This graph shows trend of selected condition in different genders among recent years<br>Click any data point to go back to previous graph</div>
                </span>
            </div><!-- END callout2 -->
            <br class="clear"/>
            <p style="text-align: center;">
                <?php echo $this->Html->link('Read wiki pages about those conditions', array('controller' => 'wikis', 'action' => 'index', 'admin' => false), array('class' => 'ka_button small_button small_skyblue')); ?>
            </p>
            <div class="pull-right">Data source: <?php echo $this->Html->link('Victorian Health Information Surveillance System', 'https://hns.dhs.vic.gov.au/3netapps/vhisspublicsite/ReportParameter.aspx?ReportID=23&TopicID=1&SubtopicID=15'); ?></div>
        </main><!-- END main #content -->
    </div><!-- END main-area -->
    <div id="footer-top">&nbsp;</div>
</div><!-- END main -->
<script>
    //Declare variables
    var plotAnchor, currentBarChart;
    var objSelectGender = jQuery('#formGender');
    var objSelectAgeGroup = jQuery('#formAgeGroup');
    var objSelectYear = jQuery('#formYear');
    var objPlotTitle = jQuery('#plotTitle');
    //Following declrations are PHP-dependent
    var barData = ['<?php echo implode("','", $plotData['data']); ?>'];
    var barCategory = ['<?php echo implode("','", $plotData['categories']); ?>'];
    var barCategoryID = ['<?php echo implode("','", $plotData['id']); ?>'];
    var ajaxBarURL = "<?php echo $this->Html->url(array('controller' => 'statistics', 'action' => 'getFilteredGraphData')) ?>";
    var ajaxSplineURL = "<?php echo $this->Html->url(array('controller' => 'statistics', 'action' => 'getSplineGraphData')) ?>";

    //Trigger plotting
    jQuery(document).ready(statisticsInit);
</script>