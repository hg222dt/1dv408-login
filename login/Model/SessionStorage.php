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
}
