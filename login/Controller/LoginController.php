<?php

namespace controller;

require_once("Model/Login.php");
require_once("View/LoginView.php");
require_once("View/CookieStorage.php");
require_once("model/userRegistration.php");

class LoginController
{
	public function __construct()
	{
		$this->login = new \model\Login();
		$this->cookieStorage = new \view\CookieStorage;
		$this->userRegistration = new \model\userRegistration();
		$this->view = new \view\LoginView($this->login, $this->cookieStorage, $this->userRegistration);

	}
	
	public function control()
	{

		//användaren är inloggad
		if($this->login->userIsLoggedIn())
		{
			//användaren vill logga ut
			if($this->view->userLogsOut())
			{
				//logga ut användare 
				$this->login->logOutUser();		
				$this->view->showLoginForm();
			}
			else
			{
				$this->view->showLoggedInPage();	
			}	
		}
		
		//användaren är inte inloggad
		else
		{
			//kollar om användaren har sparat sin inloggning
			if($this->cookieStorage->userHasCookies())
			{
				//autentiserar medd cookies
				$loggedin = $this->login->authenticateUserWithCookies($this->cookieStorage->getUser(), $this->cookieStorage->getPassword());
				
				//om det gick att logga in...
				if($loggedin)
				{
					$this->view->showLoggedInPage();
				}
				//om det var nåt fel på kakorna så tas de bort.
				else
				{
					$this->cookieStorage->removeCookies();
					$this->view->showLoginForm();
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
				$loggedin = $this->login->authenticateUser($formUser, $formPassword, $formStayLoggedIn, $cookieExpiration);
				
				//om användaren har rätt lösenord
				if($loggedin)
				{
					//cookies sparas om användaren har önskat det.
					if($formStayLoggedIn)
					{
						$this->cookieStorage->setNewLoginCookies($this->login->getUserName(),$this->login->getPassword());
					}
					$this->view->showLoggedInPage();
				} else
				{
					$this->view->showLoginForm();
				}	
			}
			else if($this->view->didUserPressRegistrate()) {

				$this->view->showRegistrationForm();
			
			} else if($this->view->didUserSendRegistration()) {
				
				// Check if user has input correct credentials.
				// If correct, send credentials to registration.
				// Forward the user to confirmation page or get faulty message

				//hämtar info från formuläret
				$formUsername = $this->view->getFormUser();
				$formPassword = $this->view->getFormPassword();
				$formRepeatedPassword = $this->view->getFormRepeatedPassword();
								
				//autentiserar användaren 
				$userRegistrated = $this->userRegistration->confirmUserRegistration($formUsername, $formPassword, $formRepeatedPassword);

				if($userRegistrated) {
					$this->view->showLoginForm();
				} else {
					$this->view->showRegistrationForm();
				}


			} else {
				$this->view->showLoginForm();
			}	
		}
	}
}
