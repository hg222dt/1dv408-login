<?php

namespace model;

require_once("Model/SessionStorage.php");
require_once("Model/Password.php");
require_once("Model/FileHandler.php");

class Login
{
	private $loginSession;
	private $fileHandler;
	
	private $usersFile = "users.txt";
	private $cookieUsersFile = "cookieUsers.txt";
	
	public function __construct()
	{
		$this->loginSession = new \model\SessionStorage();
		$this->fileHandler = new \model\FileHandler();
	}
	
	//kollar ifall det finns en session som visar att användaren har loggat in.
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
	
	public function getPassword()
	{
		return $this->loginSession->getSessionPassword();
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
		//lägg lösenordet i ett password-objekt.
		$password = new \Model\Password($password);
		
		//sparar användarnamn i session
		$this->loginSession->setSessionUser($user);
		$this->loginSession->setSessionPassword($password);
		
		//användarnamn får inte vara tomt.
		if($user === "")
		{
			return "Användarnamn saknas";
		}

		//lösenord får inte vara tomt.
		else if($password->passwordIsEmpty())
		{
			return "Lösenord saknas";
		}
		
		//letar igenom fil efter användare.
		if ($this->fileHandler->userIsInFile($user, $password->getPassword(), $this->usersFile))
		{
            	//inloggning med session
            	$this->loginSession->setSessionAsLoggedIn();		
				
				//om användaren vill fortsätta vara inloggad. Cookie-info sparas separat.
				if($stayLoggedIn)
				{
					//ta bort gammal info från samma användare (om det finns).
					$this->fileHandler->removeUserFromFile($user, $password->getPassword(), $this->cookieUsersFile);
					
					//lägger in cookie-data i fil.
					$this->fileHandler->addUserWithExpiration($user, $password->getPassword(), $expiration, $this->cookieUsersFile);					
					
					return "Inloggningen lyckades och vi kommer ihåg dig nästa gång";
				}
                return "Inloggningen lyckades";			
		}		
		return "Felaktigt användarnamn och/eller lösenord.";
        
	}
	
	//funktion som kontrollerar användaruppgifter i en kaka, och loggar in användare.
	public function authenticateUserWithCookies($user, $password)
	{
		//filen för cookieanvändare.
		$existingUsers = file($this->cookieUsersFile);
		
		//om användaren finns i filen och expiration inte gått ut.
		if($this->fileHandler->userIsInFile($user, $password, $this->cookieUsersFile))
		{
			//loggar in
			$this->loginSession->setSessionAsLoggedIn();
			$this->loginSession->setSessionUser($user);
			$this->loginSession->setSessionPassword($password);
			
			return "Inloggning lyckades via cookies";			
		}

		return "Felaktig information i cookie";
	}
}
