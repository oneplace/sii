<?php
class User extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'user';
	}
	
	public function rules()
	{
		return array(
			array('email, name, password', 'required'),
			array('email', 'email'),
			array('email','unique'),
		);
	}
	
	public function beforeSave()
	{
		$this->email=strtolower($this->email);
		$this->name=strtolower($this->name);
		if($this->isNewRecord)
		{				
			$this->password = self::hashPassword($this->password);
			$this->verifyKey = self::RandomString(10);
		}
		return parent::beforeSave();
	}
	
	public static function hashPassword($password)
	{
		return md5($password.USER_SALT);
	}
	
	public function validatePassword($password)
	{
		return self::hashPassword($password) === $this->password;
	}
	
	public static function RandomString($Length, $Characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789') {
     $CharLen = strlen($Characters) - 1;
     $String = '' ;
     for ($i = 0; $i < $Length; ++$i) {
       $Offset = mt_rand() % $CharLen;
       $String .= substr($Characters, $Offset, 1);
     }
     return $String;
  }
}