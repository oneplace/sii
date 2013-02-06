<h3>登录</h3>
<div class="row">
<div class="span4">
<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'=>'register-form',
		'enableAjaxValidation'=>false,
)); ?>
 
<?php echo $form->textFieldRow($model, 'username', array('class'=>'span3')); ?>
<?php echo $form->passwordFieldRow($model, 'password', array('class'=>'span3')); ?>
<?php echo $form->checkboxRow($model, 'rememberMe'); ?>

<div class="form-actions">
<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'type'=>'primary', 'label'=>'login')); ?>
</div>
 
<?php $this->endWidget(); ?>
</div>
<div class="span4">
	<a href="<?php echo $this->createUrl('site/connect',array('service'=>'sina')) ?>">
	<img src="http://www.sinaimg.cn/blog/developer/wiki/32.png"/>
	</a>
	<br><br>
	<a href="<?php echo '#';//echo Yii::app()->createUrl('site/login',array('service'=>'qq')) ?>">
		<img src="http://qzonestyle.gtimg.cn/qzone/vas/opensns/res/img/Connect_logo_5.png">
	</a>
	<br><br>
	<a href="<?php echo '#';//echo Yii::app()->createUrl('site/login',array('service'=>'renren')) ?>">
		<img src="http://wiki.dev.renren.com/mediawiki/images/b/b9/234_48dark.png">
	</a>
</div>
