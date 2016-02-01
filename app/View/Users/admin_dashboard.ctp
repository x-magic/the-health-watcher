<?php
/**
 * @var View $this
 * @var int $numberOfNewFeedback
 * @var int $numberOfWiki
 */
?>

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Dashboard</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<?php echo $this->Flash->render('flash') ?>
<!-- /.row -->
<div class="row">
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-pencil-square-o fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge"><?php echo $numberOfNewFeedback; ?></div>
                        <div>New Feedbacks</div>
                    </div>
                </div>
            </div>
            <a href="<?php echo $this->Html->url(array('controller' => 'feedback', 'action' => 'index', 'admin' => true)); ?>">
                <div class="panel-footer">
                    <span class="pull-left">View new feedback</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>

                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-green">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-file-text fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge"><?php echo $numberOfWiki; ?></div>
                        <div>Wiki Pages</div>
                    </div>
                </div>
            </div>
            <a href="<?php echo $this->Html->url(array('controller' => 'wikis', 'action' => 'index', 'admin' => true)); ?>">
                <div class="panel-footer">
                    <span class="pull-left">View wiki pages</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-yellow">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-bullhorn fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge"><?php echo $numberOfAnnouncement; ?></div>
                        <div>Announcements</div>
                    </div>
                </div>
            </div>
            <a href="<?php echo $this->Html->url(array('controller' => 'announcements', 'action' => 'index', 'admin' => true)); ?>">
                <div class="panel-footer">
                    <span class="pull-left">View annoucements</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-red">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-question-circle fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge"><?php echo $numberOfQuestion; ?></div>
                        <div>Quiz Questions</div>
                    </div>
                </div>
            </div>
            <a href="<?php echo $this->Html->url(array('controller' => 'questions', 'action' => 'index', 'admin' => true)); ?>">
                <div class="panel-footer">
                    <span class="pull-left">View quiz questions</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
</div><!-- /.row -->
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-info">
            <div class="panel-heading">
                Add new items
            </div><!-- /.panel-heading -->
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <?php echo $this->Html->link(
                            '<i class="fa fa-users fa-fw"></i> Add new administrator',
                            array(
                                'controller' => 'users',
                                'action' => 'add',
                                'admin' => true,
                            ),
                            array(
                                'class' => 'btn btn-primary btn-outline btn-block',
                                'escape' => false,
                            )
                        ); ?>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <?php echo $this->Html->link(
                            '<i class="fa fa-file-text fa-fw"></i> Add new wiki page',
                            array(
                                'controller' => 'users',
                                'action' => 'add',
                                'admin' => true,
                            ),
                            array(
                                'class' => 'btn btn-primary btn-outline btn-block',
                                'escape' => false,
                            )
                        ); ?>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <?php echo $this->Html->link(
                            '<i class="fa fa-bullhorn fa-fw"></i> Add new announcement',
                            array(
                                'controller' => 'users',
                                'action' => 'add',
                                'admin' => true,
                            ),
                            array(
                                'class' => 'btn btn-primary btn-outline btn-block',
                                'escape' => false,
                            )
                        ); ?>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <?php echo $this->Html->link(
                            '<i class="fa fa-question-circle fa-fw"></i> Add new quiz question',
                            array(
                                'controller' => 'users',
                                'action' => 'add',
                                'admin' => true,
                            ),
                            array(
                                'class' => 'btn btn-primary btn-outline btn-block',
                                'escape' => false,
                            )
                        ); ?>
                    </div>
                </div>
            </div><!-- /.panel-body -->
        </div><!-- /.panel -->
    </div><!-- /.col-lg-6 -->
</div><!-- /.row -->