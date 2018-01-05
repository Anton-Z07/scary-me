<?php

class UserIdentity extends CUserIdentity
{
	public function authenticate()
	{
		$users=array(
			'admin'=>'757fcc88ae8e2473b2a48',
		);
		if(!isset($users[$this->username]))
			$this->errorCode=self::ERROR_USERNAME_INVALID;
		elseif($users[$this->username]!==$this->password)
			$this->errorCode=self::ERROR_USERNAME_INVALID;
		else
			$this->errorCode=self::ERROR_NONE;
		if (!$this->errorCode) {
			$this->setState('type', 'admin');
		}
		return !$this->errorCode;
	}
}