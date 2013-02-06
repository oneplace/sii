<?php
class Bizrule {
	public static function IdeaUpdate()
	{
		$ideaID = Yii::app()->request->getParam('id');
		if(!$ideaID) return false;
		$idea = Idea::model()->findByPk($ideaID);
		if($idea->userID === Yii::app()->user->id)
			return true;
		return false;
	}
	
	public static function EditOwn()
	{
		return Yii::app()->user->id == Yii::app()->request->getParam('id');
	}
}
