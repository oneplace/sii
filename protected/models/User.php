<?php

/**
 * This is the model class for table "user".
 *
 * The followings are the available columns in table 'user':
 * @property integer $id
 * @property string $email
 * @property string $name
 * @property string $password
 * @property string $salt
 * @property string $avatar
 * @property string $service
 * @property string $openid
 * @property string $accessToken
 */
class User extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'user';
	}

	public function rules()
	{
		return array(
			array('name','required'),
			// array('email, password, salt, avatar, service, openid, accessToken', 'required'),
			array('email, name, password, accessToken', 'length', 'max'=>128),
			array('salt', 'length', 'max'=>32),
			array('avatar','ext.svalidator.SFileExistValidator','path'=>'upload/small_avatar/'),
			array('service', 'length', 'max'=>16),
			array('openid,accessToken','unsafe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, email, name, service, openid', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
			'ideas'=>array(self::HAS_MANY,'Idea','userID'),
			'tags'=>array(self::MANY_MANY, 'Tag','user_tag(userID,tagID)'),
		);
	}

	public function behaviors()
	{
		return array();
	}

	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'email' => 'Email',
			'name' => '名称',
			'password' => '密码',
			'salt' => 'Salt',
			'avatar' => '头像',
			'service' => 'Service',
			'openid' => 'Openid',
			'accessToken' => 'Access Token',
		);
	}

	public function beforeSave()
	{
		if($this->isNewRecord){
			$this->salt = $this->generateSalt();
			$this->password = $this->hashPassword($this->password,$this->salt);
		}
		return parent::beforeSave();
	}

	public function validatePassword($password)
	{
		return $this->hashPassword($password,$this->salt)===$this->password;
	}

	public function hashPassword($password,$salt)
	{
		return md5($salt.$password);
	}

	protected function generateSalt()
	{
		return uniqid(null,false);
	}

	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('service',$this->service,true);
		$criteria->compare('openid',$this->openid,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public static $currentUser;
	public static function current(){
		if(Yii::app()->user->isGuest) return false;
		if(!self::$currentUser)
			self::$currentUser = User::model()->findByPk(Yii::app()->user->id);
		return self::$currentUser;
	}

	public function getBigAvatar()
	{
		if(!$this->avatar) return null;
		if(strpos($this->avatar,'http://')===0)
			return str_replace('/50/','/180/',$this->avatar);
		return Yii::app()->baseUrl.'/upload/avatar/'.$this->avatar;
	}

	public function getSmallAvatar()
	{
		if(strpos($this->avatar,'http://')!==0)
			return Yii::app()->baseUrl.'/upload/small_avatar/'.$this->avatar;
		return $this->avatar;
	}
}
