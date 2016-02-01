<?php
/**
 * @var View $this
 */
$this->Html->script('chosen.jquery.min', array('inline' => false));
$this->Html->css('chosen.admin.min', array('inline' => false));
$this->Html->script('tiny_mce/tiny_mce', array('inline' => false));
$this->Html->script('tiny_mce/jquery.tinymce', array('inline' => false));
$this->Html->script('wiki-admin', array('inline' => false));
?>

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            Add new wiki page
            <?php echo $this->Html->link('<i class="fa fa-chevron-left fa-fw"></i> Back to wiki pages list', array('action' => 'index', 'admin' => true), array('class' => 'btn btn-primary btn-xs', 'escape' => false)); ?>
        </h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<?php echo $this->Flash->render('flash') ?>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-primary">
            <div class="panel-heading">Required fields are starred</div>
            <div class="panel-body">
                <?php echo $this->Flash->render('form') ?>
                <?php echo $this->Form->create('Wiki', array('role' => 'form', 'novalidate' => true)); ?>
                <?php //All these attributes added to controls are to match bootstrap style perfectly ?>
                <div class="row">
                    <div class="col-md-6">
                        <?php echo $this->Form->input('title', array(
                            'div' => array(
                                'class' => 'form-group'
                            ),
                            'class' => 'form-control',
                            'data-toggle' => 'tooltip',
                            'data-placement' => 'top',
                            'title' => 'Please enter title of wiki page',
                            'label' => array('text' => 'Page title*', 'class' => 'control-label'),
                            'error' => array(
                                'attributes' => array(
                                    'class' => 'help-block'
                                )
                            )
                        )); ?>
                    </div>
                    <div class="col-md-6">
                        <?php echo $this->Form->input('vhiss_disease_id', array(
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
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <?php echo $this->Form->input('source', array(
                            'div' => array(
                                'class' => 'form-group'
                            ),
                            'class' => 'form-control',
                            'data-toggle' => 'tooltip',
                            'data-placement' => 'top',
                            'title' => 'Origin of page content',
                            'placeholder' => 'e.g. Mayo Clinic Diseases and Conditions',
                            'label' => array('text' => 'Source name', 'class' => 'control-label'),
                            'error' => array(
                                'attributes' => array(
                                    'class' => 'help-block'
                                )
                            )
                        )); ?>
                    </div>
                    <div class="col-md-6">
                        <?php echo $this->Form->input('url', array(
                            'div' => array(
                                'class' => 'form-group'
                            ),
                            'class' => 'form-control',
                            'data-toggle' => 'tooltip',
                            'data-placement' => 'top',
                            'title' => 'URL of origin of page content',
                            'placeholder' => 'e.g. http://www.mayoclinic.org/diseases-conditions',
                            'label' => array('text' => 'Source URL', 'class' => 'control-label'),
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
                        <?php echo $this->Form->input('definition', array(
                            'div' => array(
                                'class' => 'form-group'
                            ),
                            'class' => 'form-control visualeditor',
                            'label' => array('text' => 'Definition*', 'class' => 'control-label'),
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
                        <?php echo $this->Form->input('symptoms', array(
                            'div' => array(
                                'class' => 'form-group'
                            ),
                            'class' => 'form-control visualeditor',
                            'label' => array('text' => 'Symptoms', 'class' => 'control-label'),
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
                        <?php echo $this->Form->input('cause', array(
                            'div' => array(
                                'class' => 'form-group'
                            ),
                            'class' => 'form-control visualeditor',
                            'label' => array('text' => 'Cause', 'class' => 'control-label'),
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
                        <?php echo $this->Form->input('complications', array(
                            'div' => array(
                                'class' => 'form-group'
                            ),
                            'class' => 'form-control visualeditor',
                            'label' => array('text' => 'Complications', 'class' => 'control-label'),
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
                        <?php echo $this->Form->input('prevention', array(
                            'div' => array(
                                'class' => 'form-group'
                            ),
                            'class' => 'form-control visualeditor',
                            'label' => array('text' => 'Prevention', 'class' => 'control-label'),
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
                        <?php echo $this->Form->input('other', array(
                            'div' => array(
                                'class' => 'form-group'
                            ),
                            'class' => 'form-control visualeditor',
                            'label' => array('text' => 'Other', 'class' => 'control-label'),
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
                        <?php echo $this->Form->submit('Add wiki page', array('div' => false, 'class' => 'btn btn-primary')); ?>
                        <?php echo $this->Html->link('Clear page', '/' . $this->request->url, array('class' => 'btn btn-default pull-right')); ?>
                    </div>
                </div>
                <?php echo $this->Form->end(); ?>
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->