<?php
class Message extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'message';
	}

	public function rules()
	{
		return array(
			array('fromID,toID', 'required'),
			array('fromID,toID,created', 'numerical', 'integerOnly'=>true),
			array('content', 'length', 'max'=>4000),
		);
	}

	public function relations()
	{
		return array(
			'from'=>array(self::BELONGS_TO,'User','fromID'),
			'to'=>array(self::BELONGS_TO,'User','toID')
		);
	}

	public static function between($user1ID,$user2ID)
	{
		$criteria = new CDbCriteria(array(
			'condition'=>'fromID=:user1ID AND toID=:user2ID OR fromID=:user2ID AND toID=:user1ID',
			'params'=>array(':user1ID'=>$user1ID,':user2ID'=>$user2ID),
			'with'=>array('from','to'),
			'order'=>'t.id asc',
		));
		return Message::model()->findAll($criteria);
	}

	public static function latestBetween($user1ID,$user2ID)
	{
		$criteria = new CDbCriteria(array(
			'condition'=>'fromID=:user1ID AND toID=:user2ID OR fromID=:user2ID AND toID=:user1ID',
			'params'=>array(':user1ID'=>$user1ID,':user2ID'=>$user2ID),
			'order'=>'t.id desc',
			'limit'=>1,
		));
		return Message::model()->find($criteria);
	}

	public static function markAsRead($fromID,$toID)
	{
		Message::model()->updateAll(array('read'=>1),
			'`read`=0 AND (fromID=:fromID AND toID=:toID)',
			array(':fromID'=>$fromID,':toID'=>$toID)
		);
	}

	public static function newCount($fromID,$toID)
	{
		return Message::model()->count(
			'`read`=0 AND (fromID=:fromID AND toID=:toID)',
			array(':fromID'=>$fromID,':toID'=>$toID)
		);
	}

	public static function allNewCount($toID)
	{
		return Message::model()->count('`read`=0 AND toID=:toID',array(':toID'=>$toID));
	}

	public static function allNew($toID)
	{
		$sql = "SELECT fromID,count(*) as count FROM `message` WHERE toID=:toID AND `read`=0 GROUP BY fromID";
		$command=Yii::app()->db->createCommand($sql);
		$command->bindParam(":toID",$toID,PDO::PARAM_INT);
		return $command->queryAll();
	}

	public function beforeSave() {
		if($this->isNewRecord) $this->created = time();
		return parent::beforeSave();
	}
}
