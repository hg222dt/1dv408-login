<?php

require_once("Model/Login.php");
require_once("View/LoginView.php");

class LoginController
{
	public function __construct()
	{
		$this->login = new \model\Login();
		$this->view = new LoginView($this->login);
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
				return $this->view->showLoginForm($feedback);
			}
			else
			{
				return $this->view->showLoggedInPage($feedback);	
			}	
			
		}
		
		//användaren är inte inloggad
		else
		{
			//användaren vill logga in
			if($this->view->userLogsIn())
			{
				$formUser = $this->view->getFormUser();
				$formPassword = $this->view->getFormPassword();
				
				$feedback = $this->login->authenticateUser($formUser, $formPassword);
				
				//om användaren har rätt lösenord
				if($this->login->userIsLoggedIn())
				{
					return $this->view->showLoggedInPage($feedback);
				}
				
			}	
			return $this->view->showLoginForm($feedback);	
		}
	}
}
