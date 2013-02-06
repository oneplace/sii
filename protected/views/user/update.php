<h3>更新个人资料</h3>

<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'user-form',
	'enableAjaxValidation'=>false,
)); ?>
<div class="row">
	<div class="span4">
		<?php echo $form->textFieldRow($user, 'name', array('class'=>'span3')); ?>

		<label>头像</label>
		<div id="user-avatar">
		<?php if($user->avatar) echo CHtml::image($user->bigAvatar) ?>
		</div>
		<?php
		$this->widget('ext.suploadify.SUploadify',array(
			'uploader'=>$this->createUrl('/fileupload/avatar'),
			'options'=>array(
				'buttonText'=>'上传头像',
				'height'=>16,
				'width'=>80,
				'onUploadSuccess'=>'js:function(file, data, response){$("#user-avatar").html(data);}',
				// 'onUploadError' => 'js:function(file, errorCode, errorMsg, errorString){console.log(errorString);}',
			),
		));
		?>
		<?php echo $form->error($user,'avatar'); ?>
	</div>
</div>

<div class="form-actions">
<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'type'=>'primary', 'label'=>'更新个人信息')); ?>
</div>

<?php $this->endWidget(); ?>

