<?php

class UserController extends Controller
{
	public function filters()
	{
		return array('rights');
	}

	public function allowedActions()
	{
		return 'view';
	}
	
	public function actionView($id)
	{
		$user = getOr404('User',$id);
		$this->render('view',compact('user'));
	}

	public function actionUpdate($id)
	{
		$user = getOr404('User',$id);
		if(isset($_POST['User'])){
			$user->attributes = $_POST['User'];
			if($user->save()){
				Yii::app()->user->setFlash('info', '个人信息已经更新。');
				$this->refresh();
			}
		}
		$this->render('update',compact('user'));
	}
	
}

