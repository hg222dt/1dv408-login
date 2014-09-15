<?php

namespace model;

class Password
{
	private $password;
	
	public function __construct($password)
	{
		$this->password = $password; 
	}
	
	public function getPassword()
	{
		if($this->passwordIsEmpty())
		{
			return "";
		}
		return md5($this->password);
	}
	
	public function passwordIsEmpty()
	{
		return $this->password === "";
	}
}
