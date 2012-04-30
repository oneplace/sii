<?php

class RegisterForm extends CFormModel
{
	public $name;
	public $email;
	public $password;
	public $repeatPassword;
	
	public function rules()
	{
		return array(
			array('name,email,password,repeatPassword','required'),
			array('repeatPassword', 'compare', 'compareAttribute'=>'password'),
			array('email','unique', 'className' => 'User'),
			array('email', 'email'),
		);
	}
}