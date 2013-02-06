<div class="modal-header conversation-header">
	<button type="button" class="close">×</button>
	<h4 id="myModalLabel"><?php echo CHtml::link('私信',array('/conversation')) ?>  › 与 <?php echo $user->name ?> 的对话:</h4>
</div>
<div class="modal-body conversation">
	<ul>
	<?php foreach ($messages as $messageItem): ?>
		<?php if ($messageItem->from->id==user()->id): ?> <li class="self"> <?php else: ?> <li> <?php endif ?>
		<div class="date"><?php echo date('Y-m-d h:i:s',$messageItem->created) ?></div>
		<?php echo CHtml::image($messageItem->from->getSmallAvatar(),$messageItem->from->name); ?> 
		<div class="message"><?php echo $messageItem->content ?></div></li>
	<?php endforeach ?>
	</ul>
</div>
<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
		'id'=>'conversation-message-form',
		'enableAjaxValidation'=>false,
)); ?>
<div> 
<?php echo $form->textArea($message, 'content', array('rows'=>2)); ?>
</div>
<button class="btn btn-small" type="submit">发送</button>
 
<?php $this->endWidget(); ?>

<script type="text/javascript" charset="utf-8">
$(function(){
	$('.conversation').scrollTop($('.conversation')[0].scrollHeight);
	$('button.close').click(function(){
		parent.$('#conversation-box').modal('hide');
	});
});
</script>





