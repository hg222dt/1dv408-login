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
		
		$retString .= $this->view->showLoginForm();
		$retString .= $this->view->showdatetime();
		
		return $retString;
	}
	
}
