<?php

	
class HTMLView {
	
	private $HTMLBody ="";
	
	public function __construct() {
		
	}
	
	public function echoHTML($HTMLBody) 
	{
		
		echo '
		<!doctype html>
		<html>
			<head>
				<meta charset="UTF-8">
				<title>Inloggning</title>
			</head>
			
			<body>
				<h1>Laborationskod hg222aa</h1>
				'.$HTMLBody.'
				
			</body>
		</html>
		';		
	}
	
}
