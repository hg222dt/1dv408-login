<?php

require_once("Model/password.php");

class LoginView
{
	public $login;
	
	public function __construct($login)
	{
		$this->login = $login;
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
	
	public function userLogsIn()
	{
		if(isset($_POST["user"]))
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
		
	public function showLoggedInPage()
	{
		return '
		<h2>Du är inloggad!</h2>
		<p></p>
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
