<?php
class RegisterForm extends CFormModel
{
	public $username;
	public $email;
	public $password;
	public $verifyPassword;

	public $loginOnRegistered = true;

	public function rules()
	{
		return array(
			array('username, email, password,verifyPassword', 'required'),
			// email has to be a valid email address
			array('email', 'email'),
			array('verifyPassword', 'compare',
						'compareAttribute'=>'password',
						'message' => "Retype password is incorrect."),
			// verifyCode needs to be entered correctly
		);
	}
	
	public function attributeLabels()
	{
		return array(
			'email'=>'邮箱',
			'username'=>'用户名',
			'password'=>'密码',
			'verifyPassword'=>'确认密码',
		);
	}
	
	public function register()
	{
		$user = new User;
		$user->name = $this->username;
		$user->email = $this->email;
		$user->password = $this->password;
		if($user->save() && $this->loginOnRegistered){
			$this->firstLogin();
		}
	}

	public function firstLogin()
	{
		$identity=new UserIdentity($this->username,$this->password);
		$identity->authenticate();
		Yii::app()->user->login($identity);
	}

	// public function attributeLabels()
	// {
	// 	return array(
	// 		'verifyCode'=>'Verification Code',
	// 	);
	// }
}
