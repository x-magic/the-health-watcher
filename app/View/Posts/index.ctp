<?php
/**
 * @var View $this
 * @var array $diseaseList
 * @var array $countList
 */
?>
<div id="main">
    <div class="main-area">
        <?php echo $this->Flash->render('flash') ?>
        <!-- ***************** - Breadcrumbs Start Here - ***************** -->
        <div class="tools">
            <span class="tools-top"></span>
            <div class="frame">
                <h1>Discussion Forums</h1>
                <p class="breadcrumb"><?php echo $this->Html->link('Home', '/'); ?><span class='current_crumb'>Discussion</span></p>
            </div><!-- END frame -->
            <span class="tools-bottom"></span>
        </div><!-- END tools -->
        <main role="main" id="content" class="content_full_width">
            <h4 class="heading-horizontal" style="margin:0 0 30px 0;"><span>Please choose one of follwing forums</span></h4>
            <?php foreach($diseaseList as $diseaseID => $diseaseName): ?>
            <div class="tab-box ui-tabs-panel ui-widget-content ui-corner-bottom forum-index-item">
                <h2 class="pull-left"><i class="fa fa-chevron-right"></i>
                    <?php echo $this->Html->link($diseaseName, array('action' => 'category', $diseaseID)); ?>
                </h2>
                <h4 class="pull-right">
                    <?php echo (isset($countList[$diseaseID]))?$countList[$diseaseID]:"0"; ?>
                    &nbsp;Threads
                </h4>
            </div>
            <?php endforeach; ?>
        </main><!-- END main #content -->
    </div><!-- END main-area -->
</div><!-- END main -->