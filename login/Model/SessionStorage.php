<?php

namespace model;

class SessionStorage
{
	//sessionsvariablernas namn
	private $sessionUser = "user";
	private $sessionLoggedIn = "loggedIn";
	private $sessionIP = "userIP";
	private $sessionUserAgent = "userAgent";
	
	public function __construct()
	{
		session_start();
	}
	
	//hämta namnet på användaren
	public function getSessionUser()
	{
		if(isset($_SESSION[$this->sessionUser]))
		{
			return $_SESSION[$this->sessionUser];
		}
		return "";
	}
	
	//sätt ett namn på användaren
	public function setSessionUser($user)
	{
		$_SESSION[$this->sessionUser] = $user;
	}
	
	//kollar om det finns en inloggningssession (att användaren är inloggad)
	public function loggedInSessionExists()
	{
		return isset($_SESSION[$this->sessionLoggedIn]) && $_SESSION[$this->sessionLoggedIn] === true;
	}
	
	//sätter en inloggningssession som inloggad.
	public function setSessionAsLoggedIn()
	{
		$_SESSION[$this->sessionLoggedIn] = true;
		
		//hämta lite användaruppgifter från klienten för att vara säker på att det är samma klient som använder sessionen hela tiden.
		$_SESSION[$this->sessionIP] = $_SERVER["REMOTE_ADDR"];
		$_SESSION[$this->sessionUserAgent] = $_SERVER["HTTP_USER_AGENT"];
	}	
	
	//tar bort sessioner.
	public function removeLoggedInSession()
	{
		session_destroy();
	}
	
	//kollar så innehavaren av sessionen är samma som loggade in (jämför ip och webbläsare)
	public function realSessionUser()
	{		
		if($_SESSION[$this->sessionIP] === $_SERVER["REMOTE_ADDR"] && $_SESSION[$this->sessionUserAgent] === $_SERVER["HTTP_USER_AGENT"])
		{
			return true;
		}
		return false;
	}
	
	
}
