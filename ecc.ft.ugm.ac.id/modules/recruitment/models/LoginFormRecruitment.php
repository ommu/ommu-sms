<?php
/**
 * LoginFormRecruitment
 * @author Putra Sudaryanto <putra.sudaryanto@gmail.com>
 * @copyright Copyright (c) 2012 Ommu Platform (ommu.co)
 * @link https://github.com/oMMu/Ommu-Core
 * @contact (+62)856-299-4114
 *
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */

class LoginFormRecruitment extends CFormModel
{
	public $email;
	public $password;
	public $rememberMe;
	private $_identity;

	/**
	 * Declares the validation rules.
	 * The rules state that email and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			// email and password are required
			array('email, password', 'required'),

			//array('email', 'email'),
			// rememberMe needs to be a boolean
			array('rememberMe', 'boolean'),
            array('email', 'length', 'max'=>32),
			// password needs to be authenticated
			array('password', 'authenticate'),
			array('email, password', 'safe'),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'email' => 'Email',
			'password' => 'Password',
			'rememberMe' => 'Remember me next time',
		);
	}

	/**
	 * Authenticates the password.
	 * This is the 'authenticate' validator as declared in rules().
	 */
	public function authenticate($attribute,$params)
	{
		// we only want to authenticate when no input errors
		if(!$this->hasErrors())
		{
			$this->_identity=new RecruitmentUserIdentity($this->email,$this->password);
			$this->_identity->authenticate();

			switch($this->_identity->errorCode)
			{
				case RecruitmentUserIdentity::ERROR_NONE:
					Yii::app()->user->login($this->_identity);
					break;
				case RecruitmentUserIdentity::ERROR_USERNAME_INVALID:
					$this->addError('email','Username & Email is incorrect.');
					break;
				default: //RecruitmentUserIdentity::ERROR_PASSWORD_INVALID
					$this->addError('password','Password is incorrect.');
					break;
			}
		}
	}

	/**
	 * Logs in the user using the given email and password in the model.
	 * @return boolean whether login is successful
	 */
	public function login()
	{
		if($this->_identity===null)
		{
			$this->_identity=new RecruitmentUserIdentity($this->email,$this->password);
			$this->_identity->authenticate();
		}
		if($this->_identity->errorCode===RecruitmentUserIdentity::ERROR_NONE)
		{
			$duration=$this->rememberMe ? 3600*24*30 : 0; // 30 days
			Yii::app()->user->login($this->_identity,$duration);
			return true;
		}
		else
			return false;
	}
}
