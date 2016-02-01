<?php
/**
 * @var View $this
 * @var array $wikis
 * @var int $currentStatus
 */

$this->Html->script('jquery.dataTables.min', array('inline' => false));
$this->Html->script('dataTables.bootstrap.min', array('inline' => false));
$this->Html->css('dataTables.bootstrap.min', array('inline' => false));
$this->Html->css('responsive.dataTables.min', array('inline' => false));
?>

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            Wiki Pages
            <?php echo $this->Html->link('<i class="fa fa-plus fa-fw"></i> Add new wiki page', array('action' => 'add', 'admin' => true), array('class' => 'btn btn-primary btn-xs visible-xs-inline', 'escape' => false)); ?>
        </h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<?php echo $this->Flash->render('flash') ?>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
            <?php switch ($currentStatus) {
                case 0:
                    echo "Unpublished wiki pages";
                    break;
                case 2:
                    echo "Pinned wiki pages";
                    break;
                default:
                    echo "All wiki pages";
            } ?>
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <div class="dataTable_wrapper">
                    <table class="table table-striped table-bordered table-hover" id="Users-dataTables">
                        <thead>
                        <tr>
                            <th>Title</th>
                            <th>Linked to</th>
                            <th>Status</th>
                            <th>View count</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($wikis as $wiki): ?>
                            <tr>
                                <td><?php echo $this->Html->link($wiki['Wiki']['title'], array('action' => 'edit', $wiki['Wiki']['id'])); ?>&nbsp;</td>
                                <td><?php echo (is_null($wiki['Wiki']['vhiss_disease_id']))?'Not linked':$wiki['VhissDisease']['value']; ?>&nbsp;</td>
                                <td><?php switch ($wiki['Wiki']['status']){
                                        case 0:
                                            echo "Unpublished";
                                            break;
                                        case 1:
                                            echo "Published";
                                            break;
                                        case 2:
                                            echo "Pinned";
                                            break;
                                        default:
                                            echo "Unknown";
                                    } ?>&nbsp;
                                </td>
                                <td><?php echo $wiki['Wiki']['counter']; ?></td>
                                <td class="actions">
                                    <?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $wiki['Wiki']['id']), array('class' => 'btn btn-success btn-xs')); ?>
                                    <?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $wiki['Wiki']['id']), array('class' => 'btn btn-danger btn-xs', 'confirm' => __('Are you sure you want to delete %s?', $wiki['Wiki']['title']))); ?>
                                    <?php if($wiki['Wiki']['status'] == 0) echo $this->Form->postLink(__('Publish'), array('action' => 'updateStatus', $wiki['Wiki']['id'], 1), array('class' => 'btn btn-outline btn-success btn-xs', 'confirm' => __('Are you sure you want to publish %s?', $wiki['Wiki']['title']))); ?>
                                    <?php if($wiki['Wiki']['status'] != 0) echo $this->Form->postLink(__('Unpublish'), array('action' => 'updateStatus', $wiki['Wiki']['id'], 0), array('class' => 'btn btn-outline btn-danger btn-xs', 'confirm' => __('Are you sure you want to unpublish %s?', $wiki['Wiki']['title']))); ?>
                                    <?php if($wiki['Wiki']['status'] != 2) echo $this->Form->postLink(__('Pin'), array('action' => 'updateStatus', $wiki['Wiki']['id'], 2), array('class' => 'btn btn-outline btn-primary btn-xs', 'confirm' => __('Are you sure you want to pin %s?', $wiki['Wiki']['title']))); ?>
                                    <?php if($wiki['Wiki']['status'] == 2) echo $this->Form->postLink(__('Unpin'), array('action' => 'updateStatus', $wiki['Wiki']['id'], 1), array('class' => 'btn btn-outline btn-warning btn-xs', 'confirm' => __('Are you sure you want to unpin %s?', $wiki['Wiki']['title']))); ?>
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
                { 'bSortable': false, 'aTargets': [ 4 ] }
            ],
        });
    });
</script>
