<?php
/**
 * @var View $this
 */
$this->Html->script('chosen.jquery.min', array('inline' => false));
$this->Html->script('bootstrap-datepicker.min', array('inline' => false));
$this->Html->script('announcement-admin', array('inline' => false));
$this->Html->css('chosen.admin.min', array('inline' => false));
$this->Html->css('bootstrap-datepicker3.standalone.min', array('inline' => false));
?>

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            Update announcement
            <?php echo $this->Html->link('<i class="fa fa-chevron-left fa-fw"></i> Back to announcement list', array('action' => 'index', 'admin' => true), array('class' => 'btn btn-primary btn-xs', 'escape' => false)); ?>
        </h1>
    </div><!-- /.col-lg-12 -->
</div><!-- /.row -->
<?php echo $this->Flash->render('flash') ?>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-primary">
            <div class="panel-heading">All fields are required</div>
            <div class="panel-body">
                <?php echo $this->Flash->render('form') ?>
                <?php echo $this->Form->create('Announcement', array('role' => 'form')); ?>
                <?php //All these attributes added to controls are to match bootstrap style perfectly ?>
                <div class="row">
                    <div class="col-md-6">
                        <?php echo $this->Form->input('disease_id', array(
                            'div' => array(
                                'class' => 'form-group'
                            ),
                            'options' => $listDiseases,
                            'empty' => '',
                            'data-placeholder' => 'Choose a disease type',
                            'data-no_results_text' => 'Nothing found with ',
                            'class' => 'form-control chosen-select',
                            'label' => array('text' => 'Disease Type', 'class' => 'control-label'),
                            'error' => array(
                                'attributes' => array(
                                    'class' => 'help-block'
                                )
                            )
                        )); ?>
                    </div>
                    <div class="col-md-6">
                        <?php echo $this->Form->input('date', array(
                            'div' => array(
                                'class' => 'form-group'
                            ),
                            'type' => 'text',
                            'class' => 'form-control datepicker-object',
                            'placeholder' => 'Please choose the date of announce',
                            'label' => array('class' => 'control-label'),
                            'error' => array(
                                'attributes' => array(
                                    'class' => 'help-block'
                                )
                            )
                        )); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <?php echo $this->Form->input('content', array(
                            'div' => array(
                                'class' => 'form-group'
                            ),
                            'type' => 'textarea',
                            'class' => 'form-control',
                            'placeholder' => 'Please put content of public service announcement here. ',
                            'error' => array(
                                'attributes' => array(
                                    'class' => 'help-block'
                                )
                            )
                        )); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <?php echo $this->Form->submit('Update announcement', array('div' => false, 'class' => 'btn btn-primary')); ?>
                        <?php echo $this->Html->link('Reset form', '/' . $this->request->url, array('class' => 'btn btn-default pull-right')); ?>
                    </div>
                </div>
                <?php echo $this->Form->end(); ?>
            </div><!-- /.panel-body -->
        </div><!-- /.panel -->
    </div><!-- /.col-lg-12 -->
</div><!-- /.row -->