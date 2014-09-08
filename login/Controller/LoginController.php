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
	
}
