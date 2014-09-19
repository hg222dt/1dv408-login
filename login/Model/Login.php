<?php

namespace model;

require_once("Model/SessionStorage.php");

class Login
{
	private $loginSession;
	
	private $usersFile = "users.txt";
	private $cookieUsersFile = "cookieUsers.txt";
	
	public function __construct()
	{
		$this->loginSession = new \model\SessionStorage();
	}
	
	//kollar om det finns en loginsession.
	public function userIsLoggedIn()
	{	
		if($this->loginSession->loggedInSessionExists())
		{
			//check så att ingen har kapat sessionen.	
			if($this->loginSession->realSessionUser() === false)
			{
				return false;
			}
			return true;
		}
		return false;
	}
	
	//hämtar användarnamn från session
	public function getUserName()
	{
		return $this->loginSession->getSessionUser();
	}
	
	//loggar ut användaren.
	public function logOutUser()
	{
		$this->loginSession->removeLoggedInSession();
		
		return "Du har nu loggat ut";
	}
	
	//funktion som kollar ifall användare med angivet namn och lösenord finns registrerade.
	//om användaren vill spara inloggningen i en cookie så sparas även denna informationen.
	public function authenticateUser($user, $password, $stayLoggedIn, $expiration)
	{
		
		//filen där registrerade användare samlas.
		$existingUsers = file($this->usersFile);
		
		//sparar användarnamn i session
		$this->loginSession->setSessionUser($user);
		
		//användarnamn får inte vara tomt.
		if($user === "")
		{
			return "Användarnamn saknas";
		}

		//lösenord får inte vara tomt.
		else if($password->getPassword() === "")
		{
			return "Lösenord saknas";
		}
		
		//kollar varje rad i filen med användare:lösenord
        foreach($existingUsers as $existingUser)
        {
            //delar upp raderna 
            $userArr = explode(":",trim($existingUser));
            
            //returnerar true om användaren med lösenordet finns i filen
            if($userArr[0] === $user && $userArr[1] === $password->getPassword() )
            {
            	//inloggning med session
            	$this->loginSession->setSessionAsLoggedIn();		
				
				//om användaren vill fortsätta vara inloggad. Cookie-info sparas separat.
				if($stayLoggedIn)
				{
					//ta bort gammal info från samma användare (om det finns).
					$this->removeCookieUserFromFile($user, $password);
					
					$cookieUsers = fopen($this->cookieUsersFile, "a");
					fwrite($cookieUsers, $user.":".$password->getPassword().":".$expiration."\n");
					
					return "Inloggningen lyckades och vi kommer ihåg dig nästa gång";
				}
                return "Inloggningen lyckades";
            }
        }
        return "Felaktigt användarnamn och/eller lösenord.";
	}
	
	//funktion som kontrollerar användaruppgifter i en kaka, och loggar in användare.
	public function authenticateUserWithCookies($user, $password)
	{
		//filen för cookieanvändare.
		$existingUsers = file($this->cookieUsersFile);
		
		//letar efter registrerade användare med samma namn/lösenord.
		foreach($existingUsers as $existingUser)
		{
			//delar upp raderna 
            $userArr = explode(":",trim($existingUser));
            
			//namn/lösenord måste vara samma. Tiden för kakan får inte ha gått ut.
			if($userArr[0] === $user && $userArr[1] === $password && $userArr[2] > time())
			{
				//loggar in
				$this->loginSession->setSessionAsLoggedIn();
				$this->loginSession->setSessionUser($user);
				return "Inloggning lyckades via cookies";
			}
		}
		
		return "Felaktig information i cookie";
	}
	
	//tar bort en kaka från register.
	private function removeCookieUserFromFile($user, $password)
	{
		$existingUsers = file($this->cookieUsersFile);
		$newFile = fopen("newFile.txt","a");
		
		foreach($existingUsers as $existingUser)
		{
			//delar upp raderna 
            $userArr = explode(":",trim($existingUser));
			
			if($userArr[0] !== $user && $userArr[1] !== $password)
			{
				fwrite($newFile, $existingUser."\n");
			}
		}
		rename("newFile.txt", "cookieUsers.txt");
	}
}
