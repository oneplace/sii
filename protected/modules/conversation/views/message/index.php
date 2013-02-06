<div class="modal-header conversation-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
	<h4 id="myModalLabel">私信</h4>
</div>
<div class="modal-body contact-list">
	<ul>
		<?php foreach ($contacts as $contact): ?>
		<li>
			<a href="<?php echo $this->createUrl('/conversation/message/send',array('id'=>$contact->id)); ?>">
			<?php echo CHtml::image($contact->getSmallAvatar(),$contact->name); ?>
			<i class="icon-chevron-right pull-right"></i>
			<div class="contact-name"><?php echo $contact->name ?></div>
			<?php if($newCount = Message::newCount($contact->id,user()->id)) echo ' ('.$newCount.')'; ?>
			<div class="latest-message"><?php $message=Message::latestBetween($contact->id,user()->id); echo mb_substr($message->content,0,100) ?></div>
			</a>
		</li>
		<?php endforeach ?>
</ul>
</div>
<script type="text/javascript" charset="utf-8">
$(function(){
	$('button.close').click(function(){
		parent.$('#conversation-box').modal('hide');
	});
});
</script>
