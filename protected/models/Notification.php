<?php

/**
 * This is the model class for table "notification".
 *
 * The followings are the available columns in table 'notification':
 * @property string $id
 * @property integer $userID
 * @property string $type
 * @property integer $data
 */

class Notification extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'notification';
	}

	public function rules()
	{
		return array(
			array('userID,type', 'required'),
		);
	}

	public static function add($userID,$type,$data,$mode='normal')
	{
		$notification = new Notification;
		$notification->userID = $userID;
		$notification->type = $type;
		$notification->data = CJSON::encode($data);
		$notification->mode = $mode;
		return $notification->save();
	}

}
