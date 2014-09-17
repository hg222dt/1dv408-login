<?php

namespace model;

class SessionStorage
{
	public function __construct()
	{
		session_start();
	}
	
	public function getSessionUser()
	{
		if(isset($_SESSION["user"]))
		{
			return $_SESSION["user"];
		}
		return "";
	}
	
	public function setSessionUser($user)
	{
		$_SESSION["user"] = $user;
	}
	
	public function loggedInSessionExists()
	{
		return isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] === true;
	}
	
	public function setSessionAsLoggedIn()
	{
		$_SESSION["loggedIn"] = true;
		
		//hämta lite användaruppgifter från klienten för att vara säker på att det är samma klient som använder sessionen hela tiden.
		$_SESSION["userIP"] = $_SERVER["REMOTE_ADDR"];
		$_SESSION["userAgent"] = $_SERVER["HTTP_USER_AGENT"];
		
	}	
	
	public function removeLoggedInSession()
	{
		session_destroy();
	}
	
	public function realSessionUser()
	{		
		if($_SESSION["userIP"] === $_SERVER["REMOTE_ADDR"] && $_SESSION["userAgent"] === $_SERVER["HTTP_USER_AGENT"])
		{
			return true;
		}
		return false;
	}
	
	
}
