<?php

namespace view;

class CookieStorage
{
	private $expiration;
	public function __construct()
	{
		//en månad f.r.o.m nu.
		$this->expiration = time()+(60*60*24*30);
	}
	
	public function setNewLoginCookies($user, $password)
	{
		setcookie("user", $user, $this->expiration);
		setcookie("password",$password->getPassword(), $this->expiration);
	}
	
	public function userHasCookies()
	{
		if(isset($_COOKIE["user"]) && isset($_COOKIE["password"]))
		{
			return true;
		}
		return false;
	}
	
	public function getUser()
	{
		return $_COOKIE["user"];
	}
	public function getPassword()
	{
		return $_COOKIE["password"];
	}
	public function getExpiration()
	{
		return $this->expiration;
	}
	
	//funktion som sätter expiration-tiden till en sekund sedan, för att förstöra kakan.
	public function removeCookies()
	{
		setcookie("user",null,-1);	
		setcookie("password",null,-1);	
	}
}
