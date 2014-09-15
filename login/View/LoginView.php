<?php

require_once("SessionStorage.php");
require_once("CookieStorage.php");

class LoginView
{
	private $login;
	private $sessionStorage;
	 
	public function __construct($login)
	{
		$this->login = $login;	
		$this->sessionStorage = new SessionStorage();
		$this->cookieStorage = new CookieStorage();
	}	
	
	//funktion som returnerar en bool, ifall användaren har skickat ett formulär
	public function userWantsToLogin()
	{

	    if(isset($_POST["user"]))
	    {		
	        return true;
	    }
	    
	    return false;
	}
	
	public function userWantsToLogOut()
	{
		if(isset($_GET["logout"]))
		{
			return true;
		}
		return false;
	}
	
	//egenskap som hämtar inskrivet användarnamn från formuläret
	public function getFormUser()
	{
	    
	    return $_POST["user"];
	}
	
	//egenskap som hämtar inskrivet lösenord från formuläret
	public function getFormPassword()
	{
	    return $_POST["password"];
	}

    //hämta user från cookie
    public function getCookieUser()
    {
        $this->cookieStorage->getUser();
    }
    
    //hämta password från cookie
    public function getCookiePassword()
    {
        $this->cookieStorage->getPassword();
    }

	//returnerar en bool som svar på om användaren är inloggad eller inte.
	public function userIsLoggedIn()
	{
		//kollar om det finns en login-session
		return $this->sessionStorage->loginSessionExists();
	}
	
	public function logInUser()
	{
	    //skapa ny login-session
        $this->sessionStorage->createLoginSession();
        
		//om användaren vill spara inloggningen i en cookie
		if(isset($_POST["stayLoggedIn"]) && $_POST["stayLoggedIn"] === "checked")
		{	    
		    //skapa nya cookies med användaruppgifter
            $this->cookieStorage->setCookie($this->getFormUser(), $this->getFormPassword());
		}
		
		header("location:index.php");	
	}
	
	public function loginCookieExists()
	{
	    return $this->cookieStorage->loginCookieExists();
	}
	
	public function isFirstLoadSinceLogin()
	{
        return $this->sessionStorage->firstLoadSinceLogin();
	}
	
	public function logOutUser()
	{
        $this->sessionStorage->removeLoginSession();
		
		header("location:index.php");	
	}
	
	public function isFirstLoadSinceLogout()
	{
		return $this->sessionStorage->firstLoadSinceLogout();
	}

	//funktion som returnerar ett html-form där användaren kan logga in 
	public function showLoginForm($feedback, $userFieldValue)
	{		
		return '
		<h2>Du är inte inloggad!</h2>
		<p>' .$feedback. '</p>
		<form id="loginForm" method="post" action="index.php">
			
			<label>Användare:</label>
			<input type="text" placeholder="Användarnamn" name="user" value="'.$userFieldValue.'" />
			
			<label>Lösenord:</label>
			<input type="password" placeholder="Lösenord" name="password" />
			
			<label>Håll mig inloggad:</label>
			<input type="checkbox" name="stayLoggedIn" value="checked" />
			
			<input type="submit" value="Logga in" />
		</form>
		';
	}
	
	public function showLoggedIn($feedback)
	{
		return '
		<h2>Du är inloggad!</h2>
		<p>'.$feedback.'</p>
		<p><a href="?logout">Logga ut</a></p>
		';
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
}
