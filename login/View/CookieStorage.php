<?php

namespace view;

class CookieStorage
{
	private $expiration;
	
	private $cookieUser = "user";
	private $cookiePassword = "password";
	
	public function __construct()
	{
		//en månad f.r.o.m nu.
		$this->expiration = time()+(60*60*24*30);
	}
	
	public function setNewLoginCookies($user, $password)
	{
		setcookie($this->cookieUser, $user, $this->expiration);
		setcookie($this->cookiePassword,$password->getPassword(), $this->expiration);
	}
	
	public function userHasCookies()
	{
		if(isset($_COOKIE[$this->cookieUser]) && isset($_COOKIE[$this->cookiePassword]))
		{
			return true;
		}
		return false;
	}
	
	public function getUser()
	{
		return $_COOKIE[$this->cookieUser];
	}
	public function getPassword()
	{
		return $_COOKIE[$this->cookiePassword];
	}
	public function getExpiration()
	{
		return $this->expiration;
	}
	
	//funktion som sätter expiration-tiden till en sekund sedan, för att förstöra kakan.
	public function removeCookies()
	{
		setcookie($this->cookieUser,null,-1);	
		setcookie($this->cookiePassword,null,-1);	
	}
}
