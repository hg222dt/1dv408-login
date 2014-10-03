<?php

namespace model;

require_once("Model/Password.php");
require_once("Model/FileHandler.php");

class userRegistration {

	private $fileHandler;
	private $usersFile = "users.txt";
	private $feedbackMsg;
	public $userCreatedAccount;
	private $tempUsername;

	public function __construct() {
		$this->fileHandler = new \model\FileHandler();
	}

	public function getTempUsername() {
		return $this->tempUsername;
	}

	public function getFeedbackMsg() {
		return $this->feedbackMsg;
	}

	public function addToFeedbackMsg($string) {
		$this->feedbackMsg .= $string;
	}

	public function confirmUserRegistration($username, $password, $repeatPassword) {
		//$password = new \model\Password($password); 

		//användarnamn får inte vara tomt.

		if(strlen($username) < 3 && strlen($password) < 6) {
//			$this->feedbackMsg = "Användarnamnet måste bestå av minst 3 tecken.";

			$this->feedbackMsg = "Användarnamnet måste bestå av minst 3 tecken.<br>Lösenordet måste bestå av minst 6 tecken.";

			return false;
		}

		//För kort användarnamn
		else if(strlen($username) < 3) {
//			$this->feedbackMsg = "Användarnamnet måste bestå av minst 3 tecken.";

			$this->feedbackMsg = "Användarnamnet måste bestå av minst 3 tecken.";

			return false;
		}

		//För kort lösenord
		else if(strlen($password) < 6) {
//			$this->feedbackMsg = "Lösenordet måste brstå av minst 6 tecken.";

			$this->feedbackMsg = "Lösenordet måste bestå av minst 6 tecken.";
			return false;
		}

		else if(!preg_match("/^[a-zA-Z _åäö]*$/",$username)) {
			$this->feedbackMsg = "Ogiltiga tecken i användarnamnet.";

			$usernameArray = str_split($username);

			foreach ($usernameArray as $key => $value) {
				if(!preg_match("/^[a-zA-Z _åäö]*$/", $value)) {
					unset($usernameArray[$key]);
				}
			}

			$newUsername = implode($usernameArray);

			$this->tempUsername = $newUsername;

			return false;
		}

		//Om användarnamnet är upptaget
		else if($this->fileHandler->doesUsernameExist($username, $this->usersFile)) {
			$this->feedbackMsg = "Användarnamnet är tyvärr upptaget.";
			$this->tempUsername = $username;
			return false;
		}

		//Lösenorden matchar inte varandra
		else if(strcmp($password, $repeatPassword) === 1) {
			$this->feedbackMsg = "Lösenorden matchar inte.";
			return false;
		}

		// Sucess! Registrera uppgifter
		else {
			$this->fileHandler->addUser($username, $password, $this->usersFile);
			$this->userCreatedAccount = true;
			return true;
		}

	}

}