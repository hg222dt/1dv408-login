<?php

class SessionStorage
{
    public function __construct()
    {
        session_start();
    }

    //Ny session som sparar en inloggning
    public function createLoginSession()
    {
        $_SESSION["loggedIn"] = true;
		$_SESSION["firstLoadSinceLogin"] = true;
    }
    
    //användaren loggar ut.
    public function removeLoginSession()
    {
        $_SESSION["loggedIn"] = false;
        $_SESSION["firstLoadSinceLogout"] = true;
    }
    
    
    
    //kollar om det finns en login-session
    public function loginSessionExists()
    {
        return isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] === true;
    }
    
    //kollar om det är första gången en sida visas sen inloggningen
    public function firstLoadSinceLogin()
    {
        if($_SESSION["firstLoadSinceLogin"])
		{
			$_SESSION["firstLoadSinceLogin"] = false;
			return true;
		}
		return false;
    }
    
    //kollar om det är första gången en sida visas sen utloggningen
    public function firstLoadSinceLogout()
    {
        
        if($_SESSION["firstLoadSinceLogout"])
		{
			$_SESSION["firstLoadSinceLogout"] = false;
			return true;
		}
		return false;
    }
}