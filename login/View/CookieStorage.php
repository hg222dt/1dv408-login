<?php

class CookieStorage
{
    public function __construct()
    {
        
    }
    
    public function getUser()
    {
        return $_COOKIE["user"];
    }
    
    public function getPassword()
    {
        return $_COOKIE["password"];
    }
    
    public function setCookie($user, $password)
    {
		setcookie("user", $user, -1);
		setcookie("password", md5($password), -1);

    }
    
    public function loginCookieExists()
    {
		if(isset($_COOKIE["user"]) && isset($_COOKIE["password"]))
		{
			return true;
		}
		return false;
    }
}