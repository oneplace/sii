<h3>我的提醒</h3>
<?php
$this->widget('zii.widgets.CMenu', array(
	'items'=>array(
		array('label'=>'新提醒', 'url'=>array('/notify/notify/index')),
		array('label'=>'历史提醒','url'=>array('/notify/notify/history')),
	),	
	'htmlOptions'=>array('class'=>'nav nav-pills'),
));
?>
<ul class="notifications">
<?php foreach ($notifications as $notification): ?>
	<li>
	<?php 
	$this->module->renderNotice($notification);	 
	?>
	 </li>
<?php endforeach ?>
</ul>
<script>
$(function(){
	function noticeHandled(link){
		var id = link.attr('rel').replace('notice-','');
		var url;
		if(link.hasClass('request-accept'))
			url = "<?php echo $this->createUrl('accept') ?>?notification_id="+id;
		else if(link.hasClass('request-reject'))
			url = "<?php echo $this->createUrl('reject') ?>?notification_id="+id;
		$.post(url,{},function(){
			location.reload();	
		})
	} 
	$('a.request-accept,a.request-reject').click(function(event){
		event.preventDefault();
		// console.log('ko');return false;
		var link = $(this);
		var url = link.attr('href');
		if(url){
			$.post(url,{},function(data){
				noticeHandled(link);
			});
		}else{
			noticeHandled(link);	
		}
	});
});
</script>
