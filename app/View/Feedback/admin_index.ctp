<?php
/**
 * @var View $this
 * @var array $feedbackSets
 * @var bool $repliedOnly
 */

$this->Html->script('jquery.dataTables.min', array('inline' => false));
$this->Html->script('dataTables.bootstrap.min', array('inline' => false));
$this->Html->css('dataTables.bootstrap.min', array('inline' => false));
$this->Html->css('responsive.dataTables.min', array('inline' => false));
?>

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            Feedback <?php if (isset($repliedOnly) && $repliedOnly == true) {
                echo $this->Html->link('<i class="fa fa-eye fa-fw"></i> Show new only', array('action' => 'index', 'admin' => true), array('class' => 'btn btn-primary btn-xs', 'escape' => false));
            } else {
                echo $this->Html->link('<i class="fa fa-eye-slash fa-fw"></i> Show replied only', array('action' => 'index', true, 'admin' => true), array('class' => 'btn btn-primary btn-xs', 'escape' => false));
            } ?>
        </h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<?php echo $this->Flash->render('flash') ?>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-primary">
            <div class="panel-heading"><?php echo (isset($repliedOnly) && $repliedOnly == true)?'Replied':'New' ?> feedback</div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <div class="dataTable_wrapper">
                    <table class="table table-striped table-bordered table-hover" id="Users-dataTables">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($feedbackSets as $feedback): ?>
                            <tr>
                                <td><?php echo $this->Html->link(h($feedback['Feedback']['name']), array('action' => 'review', $feedback['Feedback']['id'])); ?>&nbsp;</td>
                                <td><?php echo $this->Html->link(h($feedback['Feedback']['email']), array('action' => 'review', $feedback['Feedback']['id'])); ?>&nbsp;</td>
                                <td><?php echo $this->Time->timeAgoInWords($feedback['Feedback']['created'], array('accuracy' => array('month' => 'month'), 'format' => 'jS F, Y')); ?>&nbsp;</td>
                                <td class="actions">
                                    <?php echo $this->Html->link(__('Review'), array('action' => 'review', $feedback['Feedback']['id']), array('class' => 'btn btn-success btn-xs')); ?>
                                    <?php if($feedback['Feedback']['status'] == 1) echo $this->Form->postLink(__('Mark as replied'), array('action' => 'mark', $feedback['Feedback']['id']), array('class' => 'btn btn-danger btn-xs', 'confirm' => __('Are you sure you want to mark %s\'s feedback as replied?', $feedback['Feedback']['name']))); ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <!-- /.table-responsive -->
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->

<script>
    $(document).ready(function () {
        //Activate datatables
        $('#Users-dataTables').DataTable({
            responsive: true,
            "aaSorting": [],
            "aoColumnDefs": [
                { 'bSortable': false, 'aTargets': [ 2, 3 ] }
            ]
        });
    });
</script>
