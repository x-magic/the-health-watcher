<?php
/**
 * @var View $this
 * @var array $listDiseases
 */
$this->Html->script('chosen.jquery.min', array('inline' => false));
$this->Html->script('question-admin', array('inline' => false));
$this->Html->css('chosen.admin.min', array('inline' => false));
?>

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            Add new question
            <?php echo $this->Html->link('<i class="fa fa-chevron-left fa-fw"></i> Back to question list', array('action' => 'index', 'admin' => true), array('class' => 'btn btn-primary btn-xs', 'escape' => false)); ?>
        </h1>
    </div><!-- /.col-lg-12 -->
</div><!-- /.row -->
<?php echo $this->Flash->render('flash') ?>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-primary">
            <div class="panel-heading">* marks field that is required</div>
            <div class="panel-body">
                <?php echo $this->Flash->render('form') ?>
                <?php echo $this->Form->create('Question', array('role' => 'form')); ?>
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
                            'label' => array('text' => 'Disease Type*', 'class' => 'control-label'),
                            'error' => array(
                                'attributes' => array(
                                    'class' => 'help-block'
                                )
                            ),
                            'required' => true
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
                            'label' => array('text' => 'Content of question*', 'class' => 'control-label'),
                            'placeholder' => 'Please put content of question here. ',
                            'error' => array(
                                'attributes' => array(
                                    'class' => 'help-block'
                                )
                            ),
                            'required' => true
                        )); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <?php echo $this->Form->input('answer_a', array(
                            'div' => array(
                                'class' => 'form-group'
                            ),
                            'class' => 'form-control',
                            'placeholder' => 'Put content of option A here',
                            'label' => array('text' => 'Option A content*', 'class' => 'control-label'),
                            'error' => array(
                                'attributes' => array(
                                    'class' => 'help-block'
                                )
                            ),
                            'required' => true
                        )); ?>
                    </div>
                    <div class="col-md-6">
                        <?php echo $this->Form->input('answer_b', array(
                            'div' => array(
                                'class' => 'form-group'
                            ),
                            'class' => 'form-control',
                            'placeholder' => 'Put content of option B here',
                            'label' => array('text' => 'Option B content*', 'class' => 'control-label'),
                            'error' => array(
                                'attributes' => array(
                                    'class' => 'help-block'
                                )
                            ),
                            'required' => true
                        )); ?>
                    </div>
                </div>
                <div class="well">If you want to make a true/false question, please leave option C and D empty. If the question does not have fourth option, leave option D empty. </div>
                <div class="row">
                    <div class="col-md-6">
                        <?php echo $this->Form->input('answer_c', array(
                            'div' => array(
                                'class' => 'form-group'
                            ),
                            'class' => 'form-control',
                            'placeholder' => 'Put content of option C here',
                            'label' => array('text' => 'Option C content', 'class' => 'control-label'),
                            'error' => array(
                                'attributes' => array(
                                    'class' => 'help-block'
                                )
                            ),
                            'required' => false
                        )); ?>
                    </div>
                    <div class="col-md-6">
                        <?php echo $this->Form->input('answer_d', array(
                            'div' => array(
                                'class' => 'form-group'
                            ),
                            'class' => 'form-control',
                            'placeholder' => 'Put content of option D here',
                            'label' => array('text' => 'Option D content', 'class' => 'control-label'),
                            'error' => array(
                                'attributes' => array(
                                    'class' => 'help-block'
                                )
                            ),
                            'required' => false
                        )); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <?php echo $this->Form->input('answer', array(
                            'div' => array(
                                'class' => 'form-group'
                            ),
                            'options' => array('a' => 'Option A', 'b' => 'Option B', 'c' => 'Option C', 'd' => 'Option D'),
                            'empty' => '',
                            'data-placeholder' => 'Choose an answer to question',
                            'data-no_results_text' => 'Nothing found with ',
                            'class' => 'form-control chosen-select',
                            'label' => array('text' => 'Answer of question*', 'class' => 'control-label'),
                            'error' => array(
                                'attributes' => array(
                                    'class' => 'help-block'
                                )
                            ),
                            'required' => true
                        )); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <?php echo $this->Form->submit('Add question', array('div' => false, 'class' => 'btn btn-primary')); ?>
                        <?php echo $this->Html->link('Clear form', '/' . $this->request->url, array('class' => 'btn btn-default pull-right')); ?>
                    </div>
                </div>
                <?php echo $this->Form->end(); ?>
            </div><!-- /.panel-body -->
        </div><!-- /.panel -->
    </div><!-- /.col-lg-12 -->
</div><!-- /.row -->