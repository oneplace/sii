<?php

class NotifyModule extends CWebModule
{
	public $defaultController = 'notify';
	
	public $notices = array();
	
	public function init()
	{
		$this->setImport(array(
			'notify.components.*',
		));
	}

	public function getNewCount()
	{
		return Notification::model()->count(
			"userID=:userID AND status=0",
			array(':userID'=>Yii::app()->user->id)
		);
	}

	public function renderNotice($notification)
	{
		$properties = array();
		if(isset($this->notices)){
			$properties = $this->notices[$notification->type];
		}
		$properties['model'] = $notification;
		Yii::app()->controller->widget('Notice',$properties);
	}
}
