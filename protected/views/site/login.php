<div class="span7">
<h2>Login</h2>
<?php /** @var BootActiveForm $form */
$form = $this->beginWidget('bootstrap.widgets.BootActiveForm', array(
    'id'=>'loginForm',
    'htmlOptions'=>array('class'=>'well'),
)); ?>
 
<?php echo $form->textFieldRow($model, 'email', array('class'=>'span3')); ?>
<?php echo $form->passwordFieldRow($model, 'password', array('class'=>'span3')); ?>
<?php echo $form->checkboxRow($model, 'rememberMe'); ?>
<div class="form-actions">
<?php echo CHtml::htmlButton('Login', array('class'=>'btn btn-primary', 'type'=>'Submit')); ?>
</div>

<?php $this->endWidget(); ?>
</div>
