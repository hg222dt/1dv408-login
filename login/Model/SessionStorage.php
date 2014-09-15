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
	}	
	
	public function removeLoggedInSession()
	{
		$_SESSION["user"] = "";
		$_SESSION["loggedIn"] = false;
	}
	
}
