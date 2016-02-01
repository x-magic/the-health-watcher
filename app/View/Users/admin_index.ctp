<?php
/**
 * @var View $this
 * @var array $users
 */

$this->Html->script('jquery.dataTables.min', array('inline' => false));
$this->Html->script('dataTables.bootstrap.min', array('inline' => false));
$this->Html->css('dataTables.bootstrap.min', array('inline' => false));
$this->Html->css('responsive.dataTables.min', array('inline' => false));
?>

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            Administrators
            <?php echo $this->Html->link('<i class="fa fa-plus fa-fw"></i> Add new administrator', array('action' => 'add', 'admin' => true), array('class' => 'btn btn-primary btn-xs visible-xs-inline', 'escape' => false)); ?>
        </h1>
    </div><!-- /.col-lg-12 -->
</div><!-- /.row -->
<?php echo $this->Flash->render('flash') ?>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                Registered administrators
            </div><!-- /.panel-heading -->
            <div class="panel-body">
                <div class="dataTable_wrapper">
                    <table class="table table-striped table-bordered table-hover" id="Users-dataTables">
                        <thead>
                        <tr>
                            <th>Username</th>
                            <th>Created</th>
                            <th>Modified</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($users as $user): ?>
                            <tr>
                                <td><?php echo $this->Html->link(h($user['User']['username']), array('action' => 'edit', $user['User']['id'])); ?>&nbsp;</td>
                                <td><?php echo $this->Time->timeAgoInWords($user['User']['created'], array('accuracy' => array('month' => 'month'), 'format' => 'jS F, Y')); ?>&nbsp;</td>
                                <td><?php echo $this->Time->timeAgoInWords($user['User']['modified'], array('accuracy' => array('month' => 'month'), 'format' => 'jS F, Y')); ?>&nbsp;</td>
                                <td class="actions">
                                    <?php echo $this->Html->link(__('Details'), array('action' => 'edit', $user['User']['id']), array('class' => 'btn btn-success btn-xs')); ?>
                                    <?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $user['User']['id']), array('class' => 'btn btn-danger btn-xs', 'confirm' => __('Are you sure you want to delete %s?', $user['User']['username']))); ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div><!-- /.table-responsive -->
            </div><!-- /.panel-body -->
        </div><!-- /.panel -->
    </div><!-- /.col-lg-12 -->
</div><!-- /.row -->

<script>
    $(document).ready(function () {
        //Activate datatables
        $('#Users-dataTables').DataTable({
            responsive: true,
            "aaSorting": [],
            "aoColumnDefs": [
                { 'bSortable': false, 'aTargets': [ 1, 2, 3 ] }
            ]
        });
    });
</script>
