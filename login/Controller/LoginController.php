<?php

namespace controller;

require_once("Model/Login.php");
require_once("View/LoginView.php");
require_once("View/CookieStorage.php");

class LoginController
{
	public function __construct()
	{
		$this->login = new \model\Login();
		$this->cookieStorage = new \view\CookieStorage;
		$this->view = new \view\LoginView($this->login, $this->cookieStorage);
	}
	
	public function control()
	{
		$feedback = ""; 
		
		//användaren är inloggad
		if($this->login->userIsLoggedIn())
		{
			//användaren vill logga ut
			if($this->view->userLogsOut())
			{
				$feedback = $this->login->logOutUser();
				$this->cookieStorage->removeCookies(); //tar bort eventuella cookies
				
				$this->view->showLoginForm($feedback);
			}
			else
			{
				$this->view->showLoggedInPage($feedback);	
			}	
		}
		
		//användaren är inte inloggad
		else
		{
			//kollar om användaren har sparat sin inloggning
			if($this->cookieStorage->userHasCookies())
			{
				//autentiserar medd cookies
				$feedback = $this->login->authenticateUserWithCookies($this->cookieStorage->getUser(), $this->cookieStorage->getPassword());
				
				//om det gick att logga in...
				if($this->login->userIsLoggedIn())
				{
					$this->view->showLoggedInPage($feedback);
				}
				//om det var nåt fel på kakorna så tas de bort.
				else
				{
					$this->cookieStorage->removeCookies();
					$this->view->showLoginForm($feedback);
				}
			}
						
			//användaren vill logga in
			else if($this->view->userLogsIn())
			{
				//hämtar info från formuläret
				$formUser = $this->view->getFormUser();
				$formPassword = $this->view->getFormPassword();
				$formStayLoggedIn = $this->view->getFormStayLoggedIn();
				$cookieExpiration = $this->cookieStorage->getExpiration();
								
				//autentiserar användaren 
				$feedback = $this->login->authenticateUser($formUser, $formPassword, $formStayLoggedIn, $cookieExpiration);
				
				//om användaren har rätt lösenord
				if($this->login->userIsLoggedIn())
				{
					//cookies sparas om användaren har önskat det.
					if($formStayLoggedIn)
					{
						$this->cookieStorage->setNewLoginCookies($this->login->getUserName(),$this->login->getPassword());
					}
					$this->view->showLoggedInPage($feedback);
				}
				
				else
				{
					$this->view->showLoginForm($feedback);
				}	
			}
			
			else
			{
				$this->view->showLoginForm($feedback);
			}	
		}
	}
}
