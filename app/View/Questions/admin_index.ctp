<?php
/**
 * @var View $this
 * @var array $questions
 */

$this->Html->script('jquery.dataTables.min', array('inline' => false));
$this->Html->script('dataTables.bootstrap.min', array('inline' => false));
$this->Html->css('dataTables.bootstrap.min', array('inline' => false));
$this->Html->css('responsive.dataTables.min', array('inline' => false));
?>

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            Quiz questions
            <?php echo $this->Html->link('<i class="fa fa-plus fa-fw"></i> Add new question', array('action' => 'add', 'admin' => true), array('class' => 'btn btn-primary btn-xs visible-xs-inline', 'escape' => false)); ?>
        </h1>
    </div><!-- /.col-lg-12 -->
</div><!-- /.row -->
<?php echo $this->Flash->render('flash') ?>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                Published questions
            </div><!-- /.panel-heading -->
            <div class="panel-body">
                <div class="dataTable_wrapper">
                    <table class="table table-striped table-bordered table-hover" id="Questions-dataTables">
                        <thead>
                        <tr>
                            <th style="white-space: nowrap">Content</th>
                            <th style="white-space: nowrap">Disease Type</th>
                            <th style="white-space: nowrap">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($questions as $question): ?>
                            <tr>
                                <td style="width: 100%"><?php echo $this->Html->link(((strlen($question['Question']['content']) > 60)?substr($question['Question']['content'], 0, 60)."...":$question['Question']['content']), array('action' => 'edit', $question['Question']['id'])); ?>&nbsp;</td>
                                <td style="width: 0; white-space: nowrap"><?php echo h($question['VhissDisease']['value']); ?>&nbsp;</td>
                                <td style="width: 0" class="actions">
                                    <?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $question['Question']['id']), array('class' => 'btn btn-success btn-xs')); ?>
                                    <?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $question['Question']['id']), array('class' => 'btn btn-danger btn-xs', 'confirm' => __('Are you sure you want to delete this question?'))); ?>
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
        $('#Questions-dataTables').DataTable({
            responsive: true,
            "aaSorting": [],
            "aoColumnDefs": [
                { 'bSortable': false, 'aTargets': [ 0, 2 ] }
            ]
        });
    });
</script>
