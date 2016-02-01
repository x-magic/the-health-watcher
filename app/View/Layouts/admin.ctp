<?php
/**
 * @var View $this
 */
$productName = Configure::read('productName'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php echo $this->Html->charset(); ?>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?php echo $this->fetch('title'); ?> - <?php echo $productName; ?> Administration Panel</title>

    <?php
    echo $this->Html->meta('icon');
    echo $this->fetch('meta');
    echo $this->Html->script('jquery.min');
    echo $this->Html->script('bootstrap.min');
    echo $this->Html->script('metisMenu.min');
    echo $this->Html->script('sb-admin-2');
    echo $this->fetch('script');
    echo $this->Html->css('bootstrap.min');
    echo $this->Html->css('metisMenu.min');
    echo $this->Html->css('font-awesome.min');
    echo $this->Html->css('sb-admin-2');
    echo $this->fetch('css');
    ?>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <?php
    echo $this->Html->script('html5shiv');
    echo $this->Html->script('respond.min');
    ?>
    <![endif]-->
</head>
<body>
<div id="wrapper">
    <!-- Navigation -->
    <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <?php echo $this->Html->link($productName . ' Admin Panel', array('controller' => 'users', 'action' => 'dashboard', 'admin' => true), array('class' => 'navbar-brand')); ?>
        </div><!-- /.navbar-header -->

        <ul class="nav navbar-top-links navbar-right">
            <li><?php echo $this->Html->link('<i class="fa fa-external-link fa-fw"></i> Homepage', '/', array('escape' => false)); ?></li>
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <i class="fa fa-tasks fa-fw"></i> Tasks <i class="fa fa-caret-down"></i>
                </a>
                <ul class="dropdown-menu dropdown-tasks">
                    <?php /*
                    <li>
                        <a href="#">
                            <div>
                                <p>
                                    <strong>Task 1</strong>
                                    <span class="pull-right text-muted">40% Complete</span>
                                </p>
                                <div class="progress progress-striped active">
                                    <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
                                        <span class="sr-only">40% Complete (success)</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li class="divider"></li>
                    */ ?>
                    <li><div class="text-center">No background task is running</div></li>
                </ul><!-- /.dropdown-tasks -->
            </li><!-- /.dropdown -->
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <i class="fa fa-user fa-fw"></i> You <i class="fa fa-caret-down"></i>
                </a>
                <ul class="dropdown-menu dropdown-user">
                    <li><?php echo $this->Html->link('<i class="fa fa-user fa-fw"></i> ' . $this->Session->read('Auth.User.username'), array('controller' => 'users', 'action' => 'edit', $this->Session->read('Auth.User.id'), 'admin' => true), array('escape' => false)); ?></li>
                    <li class="divider"></li>
                    <li><?php echo $this->Html->link('<i class="fa fa-sign-out fa-fw"></i> Logout', array('controller' => 'users', 'action' => 'logout'), array('escape' => false)); ?></li>
                </ul><!-- /.dropdown-user -->
            </li><!-- /.dropdown -->
        </ul><!-- /.navbar-top-links -->

        <div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav navbar-collapse">
                <ul class="nav" id="side-menu">
                    <li><?php echo $this->Html->link('<i class="fa fa-dashboard fa-fw"></i> Dashboard', array('controller' => 'users', 'action' => 'dashboard', 'admin' => true), array('escape' => false)); ?></li>
                    <li>
                        <a href="#"><i class="fa fa-users fa-fw"></i> Administrators<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <?php echo $this->Html->link('<i class="fa fa-list-ul fa-fw"></i> List all administrators', array('controller' => 'users', 'action' => 'index', 'admin' => true), array('escape' => false)); ?>
                            </li>
                            <li>
                                <?php echo $this->Html->link('<i class="fa fa-plus fa-fw"></i> Add new administrator', array('controller' => 'users', 'action' => 'add', 'admin' => true), array('escape' => false)); ?>
                            </li>
                        </ul><!-- /.nav-second-level -->
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-pencil-square-o fa-fw"></i> Feedback<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <?php echo $this->Html->link('<i class="fa fa-list-ul fa-fw"></i> List new feedback', array('controller' => 'feedback', 'action' => 'index', 'admin' => true), array('escape' => false)); ?>
                            </li>
                            <li>
                                <?php echo $this->Html->link('<i class="fa fa-reply-all fa-fw"></i> List replied feedback', array('controller' => 'feedback', 'action' => 'index', true, 'admin' => true), array('escape' => false)); ?>
                            </li>
                            <li>
                                <?php echo $this->Html->link('<i class="fa fa-plus fa-fw"></i> Add feedback in frontend', array('controller' => 'feedback', 'action' => 'add', 'admin' => false), array('escape' => false)); ?>
                            </li>
                        </ul><!-- /.nav-second-level -->
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-file-text fa-fw"></i> Wiki<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <?php echo $this->Html->link('<i class="fa fa-list-ul fa-fw"></i> List all wiki pages', array('controller' => 'wikis', 'action' => 'index', 'admin' => true), array('escape' => false)); ?>
                            </li>
                            <li>
                                <?php echo $this->Html->link('<i class="fa fa-thumb-tack fa-fw"></i> List pinned wiki pages', array('controller' => 'wikis', 'action' => 'index', 2, 'admin' => true), array('escape' => false)); ?>
                            </li>
                            <li>
                                <?php echo $this->Html->link('<i class="fa fa-eye-slash fa-fw"></i> List unpublished wiki pages', array('controller' => 'wikis', 'action' => 'index', 0, 'admin' => true), array('escape' => false)); ?>
                            </li>
                            <li>
                                <?php echo $this->Html->link('<i class="fa fa-plus fa-fw"></i> Add new wiki page', array('controller' => 'wikis', 'action' => 'add', 'admin' => true), array('escape' => false)); ?>
                            </li>
                        </ul><!-- /.nav-second-level -->
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-bullhorn fa-fw"></i> Announcements<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <?php echo $this->Html->link('<i class="fa fa-list-ul fa-fw"></i> List all announcements', array('controller' => 'announcements', 'action' => 'index', 'admin' => true), array('escape' => false)); ?>
                            </li>
                            <li>
                                <?php echo $this->Html->link('<i class="fa fa-plus fa-fw"></i> Add new announcement', array('controller' => 'announcements', 'action' => 'add', 'admin' => true), array('escape' => false)); ?>
                            </li>
                        </ul><!-- /.nav-second-level -->
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-question-circle fa-fw"></i> Quiz Questions<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <?php echo $this->Html->link('<i class="fa fa-list-ul fa-fw"></i> List all questions', array('controller' => 'questions', 'action' => 'index', 'admin' => true), array('escape' => false)); ?>
                            </li>
                            <li>
                                <?php echo $this->Html->link('<i class="fa fa-plus fa-fw"></i> Add new question', array('controller' => 'questions', 'action' => 'add', 'admin' => true), array('escape' => false)); ?>
                            </li>
                        </ul><!-- /.nav-second-level -->
                    </li>
                    <?php /* disabled for future use
                    <li>
                        <a href="#"><i class="fa fa-sitemap fa-fw"></i> Multi-Level Dropdown<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="#">Second Level Item</a>
                            </li>
                            <li>
                                <a href="#">Second Level Item</a>
                            </li>
                            <li>
                                <a href="#">Third Level <span class="fa arrow"></span></a>
                                <ul class="nav nav-third-level">
                                    <li>
                                        <a href="#">Third Level Item</a>
                                    </li>
                                    <li>
                                        <a href="#">Third Level Item</a>
                                    </li>
                                    <li>
                                        <a href="#">Third Level Item</a>
                                    </li>
                                    <li>
                                        <a href="#">Third Level Item</a>
                                    </li>
                                </ul>
                                <!-- /.nav-third-level -->
                            </li>
                        </ul>
                        <!-- /.nav-second-level -->
                    </li>
                    */ ?>
                </ul>
            </div><!-- /.sidebar-collapse -->
        </div><!-- /.navbar-static-side -->
    </nav>

    <div id="page-wrapper">
        <?php echo $this->fetch('content'); ?>
    </div><!-- /#page-wrapper -->
</div><!-- /#wrapper -->
</body>
</html>





