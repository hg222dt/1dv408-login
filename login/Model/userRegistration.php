<?php

namespace model;

require_once("Model/Password.php");
require_once("Model/FileHandler.php");

class userRegistration {

	private $fileHandler;
	private $usersFile = "users.txt";

	public function __construct() {
		$this->fileHandler = new \model\FileHandler();
	}

	public function confirmUserRegistration($username, $password, $repeatPassword) {
		//$password = new \model\Password($password); 

		//användarnamn får inte vara tomt.
		if(is_null($username))
		{
			return false;
		}

		//lösenord får inte vara tomt.
		else if(is_null($password))
		{
			return false;
		}

		//För kort användarnamn
		else if(strlen($username) < 3) {
			return false;
		}

		//För kort lösenord
		else if(strlen($password) < 6) {
			return false;
		}

		//Lösenorden matchar inte varandra
		else if(!strcmp($password, $repeatePassword)) {
			return false;
		}

		//Om användarnamnet är upptaget
		else if($this->fileHandler->doesUsernameExist($username, $this->usersFile)) {
			return false;
		}

		// Sucess! Registrera uppgifter
		else {
			$this->fileHandler->addUser($username, $password, $this->usersFile);
			return true;
		}

	}

}