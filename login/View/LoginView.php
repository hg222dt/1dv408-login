<?php

namespace view;

require_once("View/CookieStorage.php");
require_once("View/HTMLView.php");

class LoginView
{
	private $login;
	private $cookieStorage;
	private $html; 
	
	public function __construct($login, $cookieStorage)
	{
		$this->login = $login;
		$this->cookieStorage = $cookieStorage;
		$this->html = new \view\HTMLView();
	}
	
	//funktion som generar feedback.
	public function getFeedback()
	{
		//om användaren har loggat ut
		if($this->login->userLoggedOut)
		{
			return "Du har nu loggat ut";
		}
		
		//om användaren har försökt logga in(med formulär)
		else if($this->login->userAttemptsLogin)
		{
			if($this->login->getUserName() === "")
			{
				return "Användarnamn saknas";
			}
			
			if($this->login->getPassword()->getPassword() === "")
			{
				return "Lösenord saknas";
			}
			
			//om inloggning lyckades
			else if($this->login->userIsLoggedIn())
			{		
				if($this->getFormStayLoggedIn())
				{
					return "Inloggningen lyckades och vi kommer ihåg dig nästa gång";
				}
				
				else if($this->cookieStorage->userHasCookies() === false)
				{
					return "Inloggningen lyckades";
				}				
			}
			return "Felaktigt användarnamn och/eller lösenord.";			
		}
		
		//om användaren har försökt logga in(med Cookies)
		else if($this->login->userAttemptsCookieLogin)
		{
			//om inloggning lyckades
			if($this->login->userIsLoggedIn())
			{
				return "Inloggning lyckades via cookies";	
			}
			return "Felaktig information i cookie";	
		}
		return "";
	}
	
	//hämtar användare från formulär
	public function getFormUser()
	{
		return $_POST["user"];
	}
	
	//hämtar lösenord från formulär
	public function getFormPassword()
	{
		return $_POST["password"];
	}
	
	//hämtar om användaren vill spara sin inloggning i en cookie
	public function getFormStayLoggedIn()
	{
		if(isset($_POST["stayLoggedIn"]))
		{
			//$this->cookieStorage->setNewLoginCookies($this->getFormUser(), $this->getFormPassword());
			return true;
		}
		return false;
	}

	//om användaren vill logga in(har postat formulär)
	public function userLogsIn()
	{
		if(isset($_GET["login"]))
		{
			return true;
		}
		return false;
	}

	//om användaren har klickat på logga ut.
	public function userLogsOut()
	{
		if(isset($_GET["logout"]))
		{
			$this->cookieStorage->removeCookies(); //tar bort eventuella cookies
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
		
		//fixa utf-8-problem vid åäö, och stor första bokstav.
		$weekday = ucfirst(utf8_encode(strftime("%A")));
		$month = ucfirst(utf8_encode(strftime("%B")));
		
        //skickar tillbaka en sträng med datum/tid        
        return strftime($weekday.", den %d ".$month." år %Y. Klockan är [%H:%M:%S]");
        
	}
		
	//skapar html-koden för kroppen till den inloggade sidan och skickar det till htmlview för utskrift.
	//feedback-parametern är för meddelanden 
	public function showLoggedInPage()
	{
		$body = '
		<h2>'.$this->login->getUserName().' är inloggad</h2>
		<p>'.$this->getFeedback().'</p>
		<p><a href="?logout">Logga ut</a></p>
		'
		.$this->showdatetime();
		;
		
		$this->html->showHTML($body);
		
	}
	
	//skapar html-koden för kroppen till inloggingsformuläret och skickar det till htmlview för utskrift.
	//feedback-parametern är för meddelanden 
	public function showLoginForm()
	{		
		$body = ' 
		<h2>Du är inte inloggad</h2>
		<p>'.$this->getFeedback().'</p>
		<form id="loginForm" method="post" action="index.php?login">
			
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
		
		$this->html->showHTML($body);
	}
	
}
