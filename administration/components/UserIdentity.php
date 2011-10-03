<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity {

	/*public function authenticate(){
		$users=array(
		// username => password
		'demo'=>'demo',
		'admin'=>'admin',
		);
		if(!isset($users[$this->username]))
		$this->errorCode=self::ERROR_USERNAME_INVALID;
		else if($users[$this->username]!==$this->password)
		$this->errorCode=self::ERROR_PASSWORD_INVALID;
		else
		$this->errorCode=self::ERROR_NONE;
		return !$this->errorCode;
		}
*/
	private $_id;
	private $_name;
	/**
	 * Authenticates a user.
	 *
	 *
	 *
	 *
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate() {

		$user = User::model()->findByAttributes(array('username' => $this->username));

		if ($user === null) {
			$this->errorCode = self::ERROR_USERNAME_INVALID;
		} else {
			if ($user->password !== $user->encrypt($this->password)) {
				$this->errorCode = self::ERROR_PASSWORD_INVALID;
			} else {
				$this->_id=$user->id;
				$this->_name=$user->username;
				$this->errorCode = self::ERROR_NONE;
			}
		}
		return!$this->errorCode;
	}

	public function getId() {
		return $this->_id;
	}

	/*public function  getName() {
	 return $this->_name;
	 }*/

}