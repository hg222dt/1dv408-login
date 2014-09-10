<?php

class Login
{
    private $correctUser = "Admin";
    private $correctPassword = "Password";
    
	public function __contruct()
	{

	}
	
	//kollar så angiven användare finns med rätt lösenord
	public function authenticateUser($user, $password)
	{
	    if($this->correctUser === $user && $this->correctPassword === $password)
	    {
	        return true;
	    }
	    return false;
	}
	
}
