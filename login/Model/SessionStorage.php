<?php

namespace model;

class SessionStorage
{
	
	private $sessionUser = "user";
	private $sessionLoggedIn = "loggedIn";
	private $sessionIP = "userIP";
	private $sessionUserAgent = "userAgent";
	
	public function __construct()
	{
		session_start();
	}
	
	public function getSessionUser()
	{
		if(isset($_SESSION[$this->sessionUser]))
		{
			return $_SESSION[$this->sessionUser];
		}
		return "";
	}
	
	public function setSessionUser($user)
	{
		$_SESSION[$this->sessionUser] = $user;
	}
	
	public function loggedInSessionExists()
	{
		return isset($_SESSION[$this->sessionLoggedIn]) && $_SESSION[$this->sessionLoggedIn] === true;
	}
	
	public function setSessionAsLoggedIn()
	{
		$_SESSION[$this->sessionLoggedIn] = true;
		
		//hämta lite användaruppgifter från klienten för att vara säker på att det är samma klient som använder sessionen hela tiden.
		$_SESSION[$this->sessionIP] = $_SERVER["REMOTE_ADDR"];
		$_SESSION[$this->sessionUserAgent] = $_SERVER["HTTP_USER_AGENT"];
	}	
	
	public function removeLoggedInSession()
	{
		session_destroy();
	}
	
	public function realSessionUser()
	{		
		if($_SESSION[$this->sessionIP] === $_SERVER["REMOTE_ADDR"] && $_SESSION[$this->sessionUserAgent] === $_SERVER["HTTP_USER_AGENT"])
		{
			return true;
		}
		return false;
	}
	
	
}
