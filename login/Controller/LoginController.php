<?php

namespace controller;

require_once("Model/Login.php");
require_once("View/LoginView.php");

class LoginController
{
	public function __construct()
	{
		$this->login = new \model\Login();
		$this->view = new \view\LoginView($this->login);
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
				$this->view->removeCookies();
				
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
			if($this->view->userHasCookies())
			{
				$feedback = $this->login->authenticateUserWithCookies($this->view->getCookieUser(), $this->view->getCookiePassword());
				if($this->login->userIsLoggedIn())
				{
					$this->view->showLoggedInPage($feedback);
				}
				else
				{
					$this->view->removeCookies();
				}
			}
						
			//användaren vill logga in
			else if($this->view->userLogsIn())
			{
				$formUser = $this->view->getFormUser();
				$formPassword = $this->view->getFormPassword();
				$formStayLoggedIn = $this->view->getFormStayLoggedIn();
				$cookieExpiration = $this->view->getCookieExpiration();
								
				$feedback = $this->login->authenticateUser($formUser, $formPassword, $formStayLoggedIn, $cookieExpiration);
				
				//om användaren har rätt lösenord
				if($this->login->userIsLoggedIn())
				{
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
