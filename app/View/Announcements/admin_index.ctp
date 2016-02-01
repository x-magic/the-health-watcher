<?php
/**
 * @var View $this
 * @var array $announcements
 */

$this->Html->script('jquery.dataTables.min', array('inline' => false));
$this->Html->script('dataTables.bootstrap.min', array('inline' => false));
$this->Html->css('dataTables.bootstrap.min', array('inline' => false));
$this->Html->css('responsive.dataTables.min', array('inline' => false));
?>

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            Public Service Announcements
            <?php echo $this->Html->link('<i class="fa fa-plus fa-fw"></i> Add new announcement', array('action' => 'add', 'admin' => true), array('class' => 'btn btn-primary btn-xs visible-xs-inline', 'escape' => false)); ?>
        </h1>
    </div><!-- /.col-lg-12 -->
</div><!-- /.row -->
<?php echo $this->Flash->render('flash') ?>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                Published announcements
            </div><!-- /.panel-heading -->
            <div class="panel-body">
                <div class="dataTable_wrapper">
                    <table class="table table-striped table-bordered table-hover" id="Announcements-dataTables">
                        <thead>
                        <tr>
                            <th style="white-space: nowrap">Content</th>
                            <th style="white-space: nowrap">Date</th>
                            <th style="white-space: nowrap">Disease Type</th>
                            <th style="white-space: nowrap">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($announcements as $announcement): ?>
                            <tr>
                                <td><?php echo $this->Html->link(((strlen($announcement['Announcement']['content']) > 60)?substr($announcement['Announcement']['content'], 0, 60)."...":$announcement['Announcement']['content']), array('action' => 'edit', $announcement['Announcement']['id'])); ?>&nbsp;</td>
                                <td style="white-space: nowrap"><?php echo $announcement['Announcement']['date']; ?>&nbsp;</td>
                                <td style="white-space: nowrap"><?php echo h($announcement['VhissDisease']['value']); ?>&nbsp;</td>
                                <td class="actions">
                                    <?php echo $this->Html->link(__('Update'), array('action' => 'edit', $announcement['Announcement']['id']), array('class' => 'btn btn-success btn-xs')); ?>
                                    <?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $announcement['Announcement']['id']), array('class' => 'btn btn-danger btn-xs', 'confirm' => __('Are you sure you want to delete this announcement?'))); ?>
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
        $('#Announcements-dataTables').DataTable({
            responsive: true,
            "aaSorting": [],
            "aoColumnDefs": [
                { 'bSortable': false, 'aTargets': [ 0, 3 ] }
            ]
        });
    });
</script>
