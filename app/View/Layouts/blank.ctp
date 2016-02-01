<?php
//Blank layout to allow page to be customized
$productName = Configure::read('productName');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php echo $this->Html->charset(); ?>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?php echo $this->fetch('title'); ?> - <?php echo $productName; ?></title>

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
<div class="container">
    <?php //echo $this->Session->flash(); //Remember to put flash constructor in ctp ?>
    <?php echo $this->fetch('content'); ?>
</div>
</body>
</html>
