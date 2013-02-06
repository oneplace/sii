<?php
class Conversation extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'conversation';
	}

	public function rules()
	{
		return array(
			array('user1ID,user2ID', 'required'),
			array('user1ID,user2ID', 'numerical', 'integerOnly'=>true),
		);
	}

	public function relations()
	{
		return array(
			'user1'=>array(self::BELONGS_TO,'User','user1ID'),
			'user2'=>array(self::BELONGS_TO,'User','user2ID')
		);
	}

	public function attributeLabels()
	{
		return array(
		);
	}

	public static function record($user1ID,$user2ID)
	{
		$exist = Conversation::model()->exists('user1ID=:user1ID AND user2ID=:user2ID OR user1ID=:user2ID AND user2ID=:user1ID',
			array(':user1ID'=>$user1ID,':user2ID'=>$user2ID));
		if($exist) return;
		$conversation = new Conversation;
		$conversation->user1ID = $user1ID;
		$conversation->user2ID = $user2ID;
		$conversation->save();
	}

	public static function contactWith($userID)
	{
		$users = array();
		$conversations1 = Conversation::model()->findAll(array(
			'condition'=>'user1ID=:userID',	
			'params'=>array(':userID'=>$userID),
			'with'=>array('user2')
		));
		foreach ($conversations1 as $conversation) {
			$users[]=$conversation->user2;
		}
		$conversations2 = Conversation::model()->findAll(array(
			'condition'=>'user2ID=:userID',	
			'params'=>array(':userID'=>$userID),
			'with'=>array('user1')
		));
		foreach ($conversations2 as $conversation) {
			$users[]=$conversation->user1;
		}
		return $users;
	}
}
