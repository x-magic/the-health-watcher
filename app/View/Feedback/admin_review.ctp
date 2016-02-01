<?php
/**
 * @var View $this
 * @var array $thisFeedback
 */
$productName = Configure::read('productName');
?>
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            Review feedback
            <?php echo $this->Html->link('<i class="fa fa-chevron-left fa-fw"></i> Back to feedback list', array('action' => 'index', ($thisFeedback['Feedback']['status'] == 0), 'admin' => true), array('class' => 'btn btn-primary btn-xs', 'escape' => false)); ?>
            <?php if ($thisFeedback['Feedback']['status'] == 1) echo $this->Form->postLink('<i class="fa fa-check fa-fw"></i> Mark as replied', array('action' => 'mark', $thisFeedback['Feedback']['id']), array('class' => 'btn btn-danger btn-xs', 'escape' => false, 'confirm' => __('Are you sure you want to mark %s\'s feedback as replied?', $thisFeedback['Feedback']['name']))); ?>
        </h1>
    </div><!-- /.col-lg-12 -->
</div><!-- /.row -->
<?php echo $this->Flash->render('flash') ?>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-<?php echo ($thisFeedback['Feedback']['status'] == 0)?'success':'info'; ?>">
            <div class="panel-heading"><?php echo ($thisFeedback['Feedback']['status'] == 0)?'This feed has been marked as replied':'This feedback have not been reviewed yet'; ?></div>
            <div class="panel-body">
                <table class="table">
                    <tr>
                        <th>Name</th>
                        <td><?php echo $thisFeedback['Feedback']['name']; ?></td>
                        <th>Email</th>
                        <td><?php echo $this->Html->link($thisFeedback['Feedback']['email'], 'mailto:'.$thisFeedback['Feedback']['email'].'?subject=Reply to your feedback on '.$productName.'&body=Dear '.$thisFeedback['Feedback']['name'].', ', array('target' => '_blank')); ?></td>
                    </tr>
                    <tr>
                        <th>Created at</th>
                        <td><?php echo $thisFeedback['Feedback']['created']; ?></td>
                        <th>Replied at</th>
                        <td><?php echo ($thisFeedback['Feedback']['status'] == 0)?$thisFeedback['Feedback']['replied']:"Not yet replied"; ?></td>
                    </tr>
                    <tr>
                        <th>Content</th>
                        <td colspan="3"><?php echo $thisFeedback['Feedback']['content']; ?></td>
                    </tr>
                </table>
            </div>
        </div><!-- /.panel -->
    </div><!-- /.col-lg-12 -->
</div><!-- /.row -->
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