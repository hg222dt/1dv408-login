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

	//returnerar en bool som svar på om användaren är inloggad eller inte.
	public function userIsLoggedIn()
	{
		session_start();
		
		if(isset($_COOKIE["user"]) && isset($_COOKIE["password"]))
		{
			if($this->login->authenticateUser($_COOKIE["user"], $_COOKIE["password"]))
			{
				$_SESSION["loggedIn"] = true;
			}
		}
		
		if(isset($_SESSION["loggedIn"]))
		{
			return true;
		}
		
		return false;
	}
	
	public function logInUser()
	{
		$_SESSION["loggedIn"] = true;
		$_SESSION["firstLoadAfterLogin"] = true;
		
		//om användaren vill spara inloggningen 
		if(isset($_POST["stayLoggedIn"]) && $_POST["stayLoggedIn"] === "checked")
		{	
			setcookie("user", $this->getFormUser(), -1);
			setcookie("password", $this->getFormPassword(), -1);
		}
		
		header("location:index.php");	
	}
	
	public function loginCookieExists()
	{
		if(isset($_COOKIE["user"]) && isset($_COOKIE["password"]))
		{
			return true;
		}
		return false;
	}
	
	public function isFirstLoadAfterLogin()
	{
		if($_SESSION["firstLoadAfterLogin"])
		{
			$_SESSION["firstLoadAfterLogin"] = false;
			return true;
		}
		return false;
	}
	
	public function logOutUser()
	{
		session_Start();
		$_SESSION["loggedIn"] = null;
		$_SESSION["firstLoadAfterLogout"] = true;
		
		header("location:index.php");	
	}
	
	public function isFirstLoadAfterLogout()
	{
		if(isset($_SESSION["firstLoadAfterLogout"]) && $_SESSION["firstLoadAfterLogout"])
		{
			$_SESSION["firstLoadAfterLogout"] = false;
			return true;
		}
		return false;
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
