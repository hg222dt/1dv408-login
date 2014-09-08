<?php

	
class HTMLView {
	
	private $HTMLBody ="";
	
	public function __construct($HTMLBody) {
		
		$this->HTMLBody = $HTMLBody;
	}
	
	public function echoHTML() 
	{
		
		echo '
		<!doctype html>
		<html>
			<head>
				<meta charset="utf-8">
				<title>Inloggning</title>
			</head>
			
			<body>
				<h1>Laborationskod hg222aa</h1>
				'.$this->HTMLBody.'
				
			</body>
		</html>
		';		
	}
	
}
