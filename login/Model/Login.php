<?php

class Login
{
    private $correctUser = "Admin";
    private $correctPassword = "Password";
    
	public function __contruct()
	{

	}
	
	public function authenticateUser($user, $password)
	{
	    if($this->correctUser === $user && $this->correctPassword === $password)
	    {
	        return true;
	    }
	    return false;
	}
	
}
