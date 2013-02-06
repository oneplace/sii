<?php

class SWebUser extends RWebUser
{
	public function login($identity,$duration=0,$connect=false)
	{
		if($connect) $this->registerUser($identity);
		return parent::login($identity,$duration);
	}

	public function registerUser($identity)
	{
		$user = User::model()->find('openid=:openid',array(':openid'=>$identity->getId()));
		if(!$user){
			$user = new User;			
			$user->openid = $identity->getId();
			$user->name = $identity->getName();
			$user->service = $identity->attributes['service'];
			foreach ($identity->attributes as $key => $value) {
				if($value) $user->$key = $value;
			}
		}
		$user->accessToken = $identity->attributes['accessToken'];
		$user->save();
		if($user->id) $identity->setLocalId($user->id);
	}
}
