<?php
/**
 * @var View $this
 * @var array $thisUser
 */
?>
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            Administrator details
            <?php echo $this->Html->link('<i class="fa fa-chevron-left fa-fw"></i> Back to administrators list', array('action' => 'index', 'admin' => true), array('class' => 'btn btn-primary btn-xs', 'escape' => false)); ?>
        </h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<?php echo $this->Flash->render('flash') ?>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-green">
            <div class="panel-heading">Administrator information</div>
            <div class="panel-body">
                <table class="table">
                    <tr>
                        <th>ID</th>
                        <td><?php echo $thisUser['User']['id']; ?></td>
                        <th>Username</th>
                        <td><?php echo $thisUser['User']['username']; ?></td>
                    </tr>
                    <tr>
                        <th>Created at</th>
                        <td><?php echo $thisUser['User']['created']; ?></td>
                        <th>Last modified at</th>
                        <td><?php echo $thisUser['User']['modified']; ?></td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td colspan="3"><?php echo ($thisUser['User']['status'] == 1)?"Active":"Deleted"; ?></td>
                    </tr>

                </table>
            </div>
        </div>
        <div class="panel panel-primary">
            <div class="panel-heading">Update administrator's information</div>
            <div class="panel-body">

                <?php echo $this->Flash->render('form') ?>
                <?php echo $this->Form->create('User', array('role' => 'form')); ?>
                <?php //All these attributes added to controls are to match bootstrap style perfectly ?>
                <div class="row">
                    <div class="col-md-6">
                        <?php echo $this->Form->input('password_update', array(
                            'div' => array(
                                'class' => 'form-group'
                            ),
                            'class' => 'form-control',
                            'type' => 'password',
                            'data-toggle' => 'tooltip',
                            'data-placement' => 'top',
                            'title' => 'Please use a secure password, at least 8 characters long. ',
                            'placeholder' => 'sEcur3 P@ssw0rd',
                            'label' => array('text' => 'New password', 'class' => 'control-label'),
                            'error' => array(
                                'attributes' => array(
                                    'class' => 'help-block'
                                )
                            )
                        )); ?>
                    </div>
                    <div class="col-md-6">
                        <?php echo $this->Form->input('password_confirm_update', array(
                            'label' => array('text' => 'Confirm new password', 'class' => 'control-label'),
                            'div' => array(
                                'class' => 'form-group'
                            ),
                            'class' => 'form-control',
                            'type' => 'password',
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
                        <?php echo $this->Form->submit('Update', array('div' => false, 'class' => 'btn btn-primary')); ?>
                        <?php echo $this->Html->link('Reset form', '/' . $this->request->url, array('class' => 'btn btn-default pull-right')); ?>
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
    jQuery(document).ready(function() {
        //Add error color to controls with error
        jQuery('.help-block').parent().addClass("has-error");
        //Activate all tooltips
        jQuery(function () {
            jQuery('[data-toggle="tooltip"]').tooltip()
        });
    });
</script>