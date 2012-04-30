<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	const ERROR_NOT_VERIFIED = 3;
	/**
   *
   * @var int Id of the User
   */
  private $_id;
  
  /**
   * This function check the user Authentication 
   * 
   * @return int 
   */
  public function authenticate()
  {
    $username = strtolower($this->username);
    
    $user = User::model()->find('LOWER(email)=?', array( $username ));

    if ($user === null) {
      $this->errorCode = self::ERROR_USERNAME_INVALID;
    } else if (!$user->validatePassword($this->password)) {
      $this->errorCode = self::ERROR_PASSWORD_INVALID;
		} else if($user->status == 0) {
			$this->errorCode = self::ERROR_NOT_VERIFIED;
    } else {
      $this->_id=$user->id;
			$this->username=$user->name;
			$this->errorCode=self::ERROR_NONE;
    }
    return $this->errorCode==self::ERROR_NONE;
  }
  
  /**
   * Return the property _id of the class
   * @return bigint
   */
  public function getId()
  {
    return $this->_id;
  }
}