<?php
/**
 * RecruitmentUserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 * 
 * @author Putra Sudaryanto <putra.sudaryanto@gmail.com>
 * @copyright Copyright (c) 2012 Ommu Platform (ommu.co)
 * @link https://github.com/oMMu/Ommu-Core
 * @contect (+62)856-299-4114
 *
 */
class RecruitmentUserIdentity extends CUserIdentity
{
	public $email;
	private $_id;

	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate()
	{
		if(preg_match('/@/',$this->username)) //$this->username can filled by username or email
			$record = RecruitmentUsers::model()->findByAttributes(array('email' => $this->username));
		else 
			$record = RecruitmentUsers::model()->findByAttributes(array('username' => $this->username));
			
		if($record === null) {
			$this->errorCode = self::ERROR_USERNAME_INVALID;
		} else if($record->password !== RecruitmentUsers::hashPassword($record->salt,$this->password)) {
			$this->errorCode = self::ERROR_PASSWORD_INVALID;
		} else {
			//$this->_id = 0;
			$this->setState('user_id', $record->user_id);
			$this->email = $record->email != '' ? $record->email : 0;
			$this->setState('username', $record->username);
			$this->setState('password', $record->password);
			$this->setState('displayname', $record->displayname);
			$this->setState('photos', $record->photos != '' ? $record->photos : 0);
			$this->setState('creation_date', $record->creation_date);
			$this->setState('lastlogin_date', $record->lastlogin_date);
			$this->errorCode = self::ERROR_NONE;
		}
		return !$this->errorCode;

	}

	public function getId() {
		return $this->_id;
	}

}