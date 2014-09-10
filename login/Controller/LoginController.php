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
	        
	    }
    
		$retString .= $this->view->showLoginForm();
		$retString .= $this->view->showdatetime();
    
		return $retString;
	}
	
}
