<?php

require_once("Model/Login.php");
require_once("View/LoginView.php");

class LoginController
{
	private $view; 
	private $login;
	
	
	public function __construct()
	{
		$this->login = new Login();
		$this->view = new LoginView($this->login);
	}
	
	
	public function control()
	{
	    
	    $retString = "";
		$feedback = "";
		$userFieldValue = "";
	 
	 	if($this->view->userIsLoggedIn())
		{
			//om användaren vill logga ut
			if($this->view->userWantsToLogOut())
			{
				$this->view->logOutUser();
				
			}
			else
			{
				if($this->view->isFirstLoadAfterLogin())
				{
					$feedback = "Inloggningen lyckades";
					
					if($this->view->loginCookieExists())
					{
						$feedback .= " och vi kommer ihåg dig nästa gång.";
					}

				}
				
				$retString .= $this->view->showLoggedIn($feedback);
			}	
		}
	    
		else
		{
		    //om användaren försöker logga in 
		    if($this->view->userWantsToLogin())
		    {
		        //kollar så användaren har skrivit ett användarnamn
		        if($this->view->getFormUser() === "")
		        {
		            $feedback = "Användarnamn saknas.";
		        }
		        
		        //kollar så användaren har skrivit ett lösenord
		        else if($this->view->getFormPassword() === "")
		        {
		            $feedback = "Lösenord saknas.";
					
					$userFieldValue = $this->view->getFormUser();
		        }
		        
		        //kollar så användarnamnet stämmer
		        else if($this->login->authenticateUser($this->view->getFormUser(), $this->view->getFormPassword()))
		        {
					//nu blir användaren inloggad
		            $this->view->logInUser();
		        }
		        else 
		        {
		           $feedback = "Felaktigt användarnamn och/eller lösenord"; 
				   
				   $userFieldValue = $this->view->getFormUser();
		        }
		    }
			
			//om användaren precis har loggat ut
			if($this->view->isFirstLoadAfterLogout())
			{
				$feedback = "Du har nu loggat ut.";
			}
		
			$retString .= $this->view->showLoginForm($feedback, $userFieldValue);
		}
		
		
		//datum ska alltid visas
		$retString .= $this->view->showdatetime();
    
		return $retString;
	}
	
}
