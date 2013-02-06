<?php

class NotifyController extends Controller
{
	public function actionIndex()
	{
		$criteria = new CDbCriteria(array(
			'condition'=>"userID=:userID AND status=0",	
			'params'=>array(':userID'=>Yii::app()->user->id),
			'order'=>'id desc'
		));
		$notifications = Notification::model()->findAll($criteria);
		foreach ($notifications as $notification) {
			if($notification->mode=='normal'){
				$notification->status = 1;
				$notification->save();	
			}
		}
		$this->render('index',compact('notifications'));
	}

	public function actionHistory()
	{
		$criteria = new CDbCriteria(array(
			'condition'=>"userID=:userID AND status!=0",	
			'params'=>array(':userID'=>Yii::app()->user->id),
			'order'=>'id desc'
		));
		$notifications = Notification::model()->findAll($criteria);		// foreach ($this->notifications as $notification) {
		// 	$notification->read = 1;
		// 	$notification->save();
		// }
		$this->render('index',compact('notifications'));
	}

	public function actionAccept()
	{
		$notification = getOr404('Notification',getParam('notification_id'));
		if($notification->mode=='request'){
			$notification->status = 1;
			$notification->save();
		}
		// $handler = getParam('handler');
		// if($handler) echo $this->postToHandler($handler);
		// $this->redirect(Yii::app()->request->urlReferrer);
	}

	public function actionReject()
	{
		$notification = getOr404('Notification',getParam('notification_id'));
		if($notification->mode=='request'){
			$notification->status = 2;
			$notification->save();
		}
		// $handler = getParam('handler');
		// if($handler) echo $this->postToHandler($handler);
		// $this->redirect(Yii::app()->request->urlReferrer);
	}

	public function acceptLink($notification,$route,$params=array())
	{
		$handler = $this->createUrl($route,$params);
		return $this->createUrl('notify/accept').'?handler='.urlencode($handler).'&notification_id='.$notification->id;
	}

	public function rejectLink($notification,$route=null,$params=array())
	{
		$url = $this->createUrl('notify/reject').'?notification_id='.$notification->id;
		if($route) $url.='&handler='.urlencode($this->createUrl($route,$params));
		return $url;
	}

	protected function postToHandler($url)
	{
		$url = $this->createAbsoluteUrl($url);
		// echo $url;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch,CURLOPT_POST, 1);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
		$result = curl_exec($ch);
		curl_close($ch);
		return $result;
	}
}
