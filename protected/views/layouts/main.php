<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title><?php echo $this->pageTitle ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl.'/assets/style.css' ?>" type="text/css">
</head>
<body>
	<div class="navbar navbar-inverse navbar-static-top" id="header">
		<div class="navbar-inner">
			<div class="container">
			<a href="/index.php" class="brand">Sii - Social Network foundation on Yii</a>
			<?php
			$this->widget('zii.widgets.CMenu', array(
				'items'=>array(
					array('label'=>'权限管理','url'=>array('/rights'),'visible'=>Yii::app()->user->checkAccess('Admin')),
					// array('label'=>'关于', 'url'=>array('/site/page', 'view'=>'about')),
				),
				'htmlOptions'=>array('class'=>'nav'),
				'id'=>'main-menu'
				));
			?>
			<ul class="pull-right nav">
				<?php if(!Yii::app()->user->isGuest): ?>
				<li><?php echo CHtml::link('私信',array('/conversation'),array('id'=>'link-conversation','title'=>'私信')) ?></li>
				<li class="notification-count"><?php echo CHtml::link(Yii::app()->getModule('notify')->newCount,array('/notify'),array('title'=>'提醒')) ?></li>
				<li class="dropdown">
					<a class="dropdown-toggle" data-toggle="dropdown" href="#">
						<?php echo User::current()->name ?> <span class="caret"></span>
					</a>
					<ul class="dropdown-menu">
						<li><?php //echo CHtml::link('私信',array('/conversation')) ?></li>
						<li><?php echo CHtml::link('设置',array('user/update','id'=>User::current()->id)) ?></li>
						<li><?php echo CHtml::link('我的主页',array('user/view','id'=>User::current()->id)) ?></li>
						<li class="divider"></li>
						<li class=""><a href="/index.php/site/logout">登出</a></li>
					</ul>
				</li>
			<?php else: ?>
				<li><?php echo CHtml::link('登录',array('/site/login')) ?></li>
			<?php endif ?>
			</ul>
		</div>
		</div>
	</div>
	<?php $this->widget('bootstrap.widgets.TbAlert'); ?>
	<?php echo $content; ?>
		<!-- content -->
	<div class="modal hide" id="conversation-box" tabindex="-1" role="dialog" aria-hidden="true">
		xx
	</div>
	<script type="text/javascript" charset="utf-8">
	$(function(){
		$('#link-conversation').click(function(event){
			// if(event.which==2) return;
			$('#conversation-box').html($('<iframe scrolling="no"></iframe>').attr({src:$(this).attr('href'),width:520,height:480}));
			$('#conversation-box').modal('show');
			return false;
		});	
	});
	</script>
</body>
</html>
