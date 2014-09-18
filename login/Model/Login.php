<?php

namespace model;

require_once("Model/SessionStorage.php");

class Login
{
	private $loginSession;
	
	public function __construct()
	{
		$this->loginSession = new \model\SessionStorage();
	}
	
	public function userIsLoggedIn()
	{	
		if($this->loginSession->loggedInSessionExists())
		{
			if($this->loginSession->realSessionUser() === false)
			{
				return false;
			}
			return true;
		}
		return false;
	}
	
	public function getUserName()
	{
		return $this->loginSession->getSessionUser();
	}
	
	public function logOutUser()
	{
		$this->loginSession->removeLoggedInSession();
		
		return "Du har nu loggat ut";
	}
	
	public function authenticateUser($user, $password, $stayLoggedIn, $expiration)
	{
		$existingUsers = file("users.txt");
		
		$this->loginSession->setSessionUser($user);
		
		if($user === "")
		{
			return "Användarnamn saknas";
		}

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
            	$this->loginSession->setSessionAsLoggedIn();		
				
				if($stayLoggedIn)
				{
					$this->removeCookieUserFromFile($user, $password);
					
					$cookieUsers = fopen("cookieUsers.txt", "a");
					fwrite($cookieUsers, $user.":".$password->getPassword().":".$expiration."\n");
					
					return "Inloggningen lyckades och vi kommer ihåg dig nästa gång";
				}
                return "Inloggningen lyckades";
            }
        }
        return "Felaktigt användarnamn och/eller lösenord.";
	}
	
	public function authenticateUserWithCookies($user, $password)
	{
		$existingUsers = file("cookieUsers.txt");
		
		foreach($existingUsers as $existingUser)
		{
			//delar upp raderna 
            $userArr = explode(":",trim($existingUser));
            
			if($userArr[0] === $user && $userArr[1] === $password && $userArr[2] > time())
			{
				$this->loginSession->setSessionAsLoggedIn();
				return "Inloggning lyckades via cookies";
			}
		}
		
		return "Felaktig information i cookie";
	}
	
	public function removeCookieUserFromFile($user, $password)
	{
		$existingUsers = file("cookieUsers.txt");
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
