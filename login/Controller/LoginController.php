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
	 
	 	if($this->view->userIsLoggedIn())
		{
			$retString .= $this->view->showLoggedIn();
		}
	    
		else
		{
			$retString .= $this->view->showLoginForm();
			
		    //om användaren försöker logga in 
		    if($this->view->userWantsToLogin())
		    {
		        //kollar så användaren har skrivit ett användarnamn
		        if($this->view->getFormUser() === "")
		        {
		            $retString .= "Användarnamn saknas.";
		        }
		        
		        //kollar så användaren har skrivit ett lösenord
		        else if($this->view->getFormPassword() === "")
		        {
		            $retString .= "Lösenord saknas.";
		        }
		        
		        //kollar så användarnamnet stämmer
		        else if($this->login->authenticateUser($this->view->getFormUser(), $this->view->getFormPassword()))
		        {
		        	$retString .= $this->view->showLoggedIn();
		        	
		        	//nu blir användaren inloggad
		            session_start();
					$_SESSION["loggedin"] = true;
		        }
		        else 
		        {
		           $retString .= "Felaktigt användarnamn och/eller lösenord"; 
		        }
		        
		    }
		}
		
		
		//datum ska alltid visas
		$retString .= $this->view->showdatetime();
    
		return $retString;
	}
	
}
