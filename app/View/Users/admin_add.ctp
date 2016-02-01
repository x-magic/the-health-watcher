<?php
/**
 * @var View $this
 */
?>

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            Add new administrator
            <?php echo $this->Html->link('<i class="fa fa-chevron-left fa-fw"></i> Back to administrators list', array('action' => 'index', 'admin' => true), array('class' => 'btn btn-primary btn-xs', 'escape' => false)); ?>
        </h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<?php echo $this->Flash->render('flash') ?>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-primary">
            <div class="panel-heading">All fields are required</div>
            <div class="panel-body">
                <?php echo $this->Flash->render('form') ?>
                <?php echo $this->Form->create('User', array('role' => 'form')); ?>
                <?php //All these attributes added to controls are to match bootstrap style perfectly ?>
                <div class="row">
                    <div class="col-md-6">
                        <?php echo $this->Form->input('username', array(
                            'div' => array(
                                'class' => 'form-group'
                            ),
                            'class' => 'form-control',
                            'data-toggle' => 'tooltip',
                            'data-placement' => 'top',
                            'title' => 'Accept letters, numbers, dash and underscore only. Maximum length is 127 characters.',
                            'placeholder' => 'johndoe',
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
                    <div class="col-md-6">
                        <?php echo $this->Form->input('password', array(
                            'div' => array(
                                'class' => 'form-group'
                            ),
                            'class' => 'form-control',
                            'data-toggle' => 'tooltip',
                            'data-placement' => 'top',
                            'title' => 'Please use a secure password, at least 8 characters long. ',
                            'placeholder' => 'sEcur3 P@ssw0rd',
                            'label' => array('class' => 'control-label'),
                            'error' => array(
                                'attributes' => array(
                                    'class' => 'help-block'
                                )
                            )
                        )); ?>
                    </div>
                    <div class="col-md-6">
                        <?php echo $this->Form->input('password_confirm', array(
                            'label' => array('text' => 'Confirm password', 'class' => 'control-label'),
                            'div' => array(
                                'class' => 'form-group'
                            ),
                            'type' => 'password',
                            'class' => 'form-control',
                            'data-toggle' => 'tooltip',
                            'data-placement' => 'top',
                            'title' => 'Please repeat your chosen password',
                            'placeholder' => 'sEcur3 P@ssw0rd',
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
                        <?php echo $this->Form->submit('Add administrator', array('div' => false, 'class' => 'btn btn-primary')); ?>
                        <?php echo $this->Html->link('Clear form', '/' . $this->request->url, array('class' => 'btn btn-default pull-right')); ?>
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
<script type="text/javascript">
    jQuery(document).ready(function () {
        //Add error color to controls with error
        jQuery('.help-block').parent().addClass("has-error");
        //Activate all tooltips
        jQuery(function () {
            jQuery('[data-toggle="tooltip"]').tooltip()
        });
    });
</script>