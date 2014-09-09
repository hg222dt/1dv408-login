<?php

class LoginView
{
	private $login;
	 
	public function __construct($login)
	{
		$this->login = $login;		
	}	
	
	
	//funktion som returnerar ett html-form där användaren kan logga in 
	public function showLoginForm()
	{
		$form = 
		'
		<h2>Du är inte inloggad!</h2>
		<form id="loginForm">
			
			<label>Användare:</label>
			<input type="text" id="userId" placeholder="Användarnamn" />
			
			<label>Lösenord:</label>
			<input type="password" id="password" placeholder="Lösenord" />
			
			<label>Håll mig inloggad:</label>
			<input type="checkbox" id="stayLoggedIn" />
			
			<input type="submit" value="Logga in" />
		</form>
		';
		
		return $form;
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
