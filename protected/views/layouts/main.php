<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title><?php echo Yii::app()->name ?></title>
		<!-- <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap.min.css"/> -->
		<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/app.css"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  </head>

  <body>
		<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
		<?php $this->widget('bootstrap.widgets.BootNavbar', array(
		    // 'fixed'=>true,
		    'brand'=>Yii::app()->name,
		    'brandUrl'=>'#',
		    'collapse'=>false, // requires bootstrap-responsive.css
		    'items'=>array(
		        array(
		            'class'=>'bootstrap.widgets.BootMenu',
		            'items'=>array(
		                array('label'=>'Home', 'url'=>array('/')),
		                array('label'=>'Login', 'url'=>array('site/login'),'visible'=>Yii::app()->user->isGuest),
										array('label'=>'Register', 'url'=>array('site/register'),'visible'=>Yii::app()->user->isGuest),
		            ),
		        ),
		        array(
		            'class'=>'bootstrap.widgets.BootMenu',
		            'htmlOptions'=>array('class'=>'pull-right'),
		            'items'=>array(
		                array('label'=>Yii::app()->user->name, 'url'=>'#', 
											'visible'=>!Yii::app()->user->isGuest,
											'items'=>array(
		                    array('label'=>'Action', 'url'=>'#'),
		                    array('label'=>'Another action', 'url'=>'#'),
		                    array('label'=>'Something else here', 'url'=>'#'),
		                    '---',
		                    array('label'=>'Logout', 'url'=>array('site/logout')),
		                )),
		            ),
		        ),
		    ),
		)); ?>
    <div class="container">
		<?php echo $content ?>

    </div> <!-- /container -->

  </body>
</html>
