<?php

class LoginView
{
	private $login;
	 
	public function __construct($login)
	{
		$this->login = $login;		
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
	
	//egenskap som hämtar användarens svar på om han/hon vill fortsätta vara inloggad
	public function getFormStayLoggedIn()
	{
	    return $_POST["stayLoggedIn"];
	}
	
	//returnerar en bool som svar på om användaren är inloggad eller inte.
	public function userIsLoggedIn()
	{
		if(isset($_SESSION["loggedin"]))
		{
			return true;
		}
		return false;
	}
	
	//funktion som returnerar ett html-form där användaren kan logga in 
	public function showLoginForm()
	{		
		return '
		<h2>Du är inte inloggad!</h2>
		<form id="loginForm" method="post">
			
			<label>Användare:</label>
			<input type="text" placeholder="Användarnamn" name="user" />
			
			<label>Lösenord:</label>
			<input type="password" placeholder="Lösenord" name="password" />
			
			<label>Håll mig inloggad:</label>
			<input type="checkbox" name="stayLoggedIn" />
			
			<input type="submit" value="Logga in" />
		</form>
		';
	}
	
	public function showLoggedIn()
	{
		return '
		<h2>Du är inloggad!</h2>
		<p>Inloggningen lyckades</p>
		<p><a href="?logout">Logga ut</a></p>
		';
	}
	
	//funtion som returnerar aktuellt datum och tid
	public function showdatetime()
	{
	    //this is sweden!
	    date_default_timezone_set("Europe/Stockholm");
        setlocale(LC_ALL, "Swedish_Sweden.1252");

        //skickar tillbaka en sträng med datum/tid
        return strftime("%A, den %d %B år %Y. Klockan är [%H:%M:%S]");
        
	}
	
}
