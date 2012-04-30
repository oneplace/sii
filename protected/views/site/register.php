<div class="span7">
	<h2>Register</h2>
<?php /** @var BootActiveForm $form */
$form = $this->beginWidget('bootstrap.widgets.BootActiveForm', array(
    'id'=>'registerForm',
    'htmlOptions'=>array('class'=>'well'),
)); ?>
 
<?php echo $form->textFieldRow($model, 'name', array('class'=>'span3')); ?>
<?php echo $form->textFieldRow($model, 'email', array('class'=>'span3')); ?>
<?php echo $form->passwordFieldRow($model, 'password', array('class'=>'span3')); ?>
<?php echo $form->passwordFieldRow($model, 'repeatPassword', array('class'=>'span3')); ?>
<?php //echo $form->checkboxRow($model, 'checkbox'); ?>
<div class="form-actions">
<?php echo CHtml::htmlButton('Submit', array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
</div>

<?php $this->endWidget(); ?>
</div>