<?php

require_once("Model/Password.php");
require_once("View/CookieStorage.php");

class LoginView
{
	public $login;
	public $cookieStorage;
	
	
	public function __construct($login)
	{
		$this->login = $login;
		$this->cookieStorage = new \view\CookieStorage();
	}
	
	public function getFormUser()
	{
		return $_POST["user"];
	}
	
	public function getFormPassword()
	{
		$FormPassword = new \Model\Password($_POST["password"]);
		return $FormPassword;
	}
	
	public function getFormStayLoggedIn()
	{
		if(isset($_POST["stayLoggedIn"]))
		{
			$this->cookieStorage->setNewLoginCookies($this->getFormUser(), $this->getFormPassword());
			return true;
		}
		return false;
	}
	
	public function userHasCookies()
	{
		return $this->cookieStorage->userHasCookies();
	}
	
	public function getCookieUser()
	{
		return $this->cookieStorage->getUser();
	}
	
	public function getCookiePassword()
	{
		return $this->cookieStorage->getPassword();
	}
	
	public function getCookieExpiration()
	{
		return $this->cookieStorage->getExpiration();
	}
	
	
	public function userLogsIn()
	{
		if(isset($_POST["user"]))
		{
			return true;
		}
		return false;
	}

	public function userLogsOut()
	{
		if(isset($_GET["logout"]))
		{
			return true;
		}
		return false;
	}

	//funtion som returnerar aktuellt datum och tid
	public function showdatetime()
	{
	    //this is sweden!
	    date_default_timezone_set("Europe/Stockholm");
        setlocale(LC_TIME, 'sv_SE'); 

        //skickar tillbaka en sträng med datum/tid
        return utf8_encode(strftime("%A, den %d %B år %Y. Klockan är [%H:%M:%S]"));
        
	}
		
	public function showLoggedInPage($feedback)
	{
		return '
		<h2>Du är inloggad!</h2>
		<p>'.$feedback.'</p>
		<p><a href="?logout">Logga ut</a></p>
		'
		.$this->showdatetime();
		;
	}
	
	
	
	public function showLoginForm($feedback)
	{		
		return '
		<h2>Du är inte inloggad!</h2>
		<p>'.$feedback.'</p>
		<form id="loginForm" method="post" action="index.php">
			
			<label>Användare:</label>
			<input type="text" placeholder="Användarnamn" name="user" value="'.$this->login->getUserName().'" />
			
			<label>Lösenord:</label>
			<input type="password" placeholder="Lösenord" name="password" />
			
			<label>Håll mig inloggad:</label>
			<input type="checkbox" name="stayLoggedIn" value="checked" />
			
			<input type="submit" value="Logga in" />
		</form>
		'
		.$this->showdatetime();
		;
	}
	
}
