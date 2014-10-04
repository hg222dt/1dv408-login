<?php

namespace view;

require_once("View/CookieStorage.php");
require_once("View/HTMLView.php");

class LoginView
{
	private $login;
	private $cookieStorage;
	private $html; 
	private $userRegistration;
	
	public function __construct($login, $cookieStorage, $userRegistration)
	{
		$this->login = $login;
		$this->userRegistration = $userRegistration;
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

		else if($this->userRegistration->userCreatedAccount) {
			$this->userRegistration->userCreatedAccount = false;
			return "Registrering av ny användare lyckades.";
		}
		return "";
	}
	
	public function getRegistrationFeedback() {
		return $this->userRegistration->getFeedbackMsg();
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

	public function getFormRepeatedPassword() {
		return $_POST["repeatedPassword"];
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

	public function didUserPressRegistrate() {
		if(isset($_POST["userPressedRegistrate"])) {
			return true;
		}
		return false;
	}

	public function didUserSendRegistration() {
		if(isset($_POST['registrationFormPosted'])) {
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

	public function showRegistrationForm() {
		$body = ' 
		<h2>Registrera ny användare</h2>
		<a href="index.php">Tillbaka</a>
		<br>
		'.$this->getRegistrationFeedback().'
		<form id="registrationForm" method="post" action="index.php">
			<label>Namm:</label>
			<input type="text" name="user" value="'.$this->userRegistration->getTempUserName().'" />
			<br>
			<label>Lösenord:</label>
			<input type="password" name="password" />
			<br>
			<label>Repetera lösenord:</label>
			<input type="password" name="repeatedPassword" />
			<br>
			<label>Skicka:</label>
			<input type="submit" value="Registrera" name="registrationFormPosted" />
		</form>
			
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
		<form method="post" action="">
			<input type="submit" value="Registrera ny användare" name="userPressedRegistrate">
		</form>
		<form id="loginForm" method="post" action="index.php?login">
			<label>Användare:</label>
			<input type="text" name="user" value="'.$this->login->getUserName().'" />
			
			<label>Lösenord:</label>
			<input type="password" name="password" />
			
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
