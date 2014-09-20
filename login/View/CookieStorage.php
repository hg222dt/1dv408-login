<?php

namespace view;

class CookieStorage
{
	private $expiration;
	private $cookieUser = "user";
	private $cookiePassword = "password";
	
	//konstruktorn sätter utgångstiden som ska gälla för kakor.
	public function __construct()
	{
		//en månad f.r.o.m nu.
		$this->expiration = time()+(60*60*24*30);
	}
	//skapar en ny cookie med inloggningsdata
	public function setNewLoginCookies($user, $password)
	{
		setcookie("user", $user, $this->expiration);
		setcookie("password", $password->getPassword(), $this->expiration);
	}
	
	//kollar om användaren har några inloggningscookies
	public function userHasCookies()
	{
		if(isset($_COOKIE[$this->cookieUser]) && isset($_COOKIE[$this->cookiePassword]))
		{
			return true;
		}
		return false;
	}
	
	//hämta användarnamn från cookie
	public function getUser()
	{
		return $_COOKIE[$this->cookieUser];
	}
	
	//hämta lösenord från cookie
	public function getPassword()
	{
		return $_COOKIE[$this->cookiePassword];
	}
	
	//returnerar utgångsdatum
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
