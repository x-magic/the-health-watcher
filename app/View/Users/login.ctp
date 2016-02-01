<div class="row">
    <div class="col-md-4 col-md-offset-4">
        <div class="login-panel panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?php echo Configure::read('productName'); ?> Administration Panel Login</h3>
            </div>
            <div class="panel-body">
                <?php echo $this->Flash->render('auth') ?>
                <?php echo $this->Flash->render('form') ?>
                <?php echo $this->Flash->render('flash') ?>
                <?php echo $this->Form->create('User', array('role' => 'form')); ?>
                <fieldset>
                    <div class="form-group">
                        <?php echo $this->Form->text('username', array('class' => 'form-control', 'div' => false, 'placeholder' => 'Username', 'autofocus' => true)); ?>
                    </div>
                    <div class="form-group">
                        <?php echo $this->Form->password('password', array('class' => 'form-control', 'div' => false, 'placeholder' => 'Password', 'value' => '')); ?>
                    </div>
                    <?php echo $this->Form->submit('Login', array('div' => false, 'class' => 'btn btn-lg btn-success btn-block')); ?>
                </fieldset>
                <?php echo $this->Form->end(); ?>
            </div>
        </div>
        <?php echo $this->Html->link('Back to homepage', '/', array('class' => 'btn btn-lg btn-info btn-block')); ?>
    </div>
</div>
