<?php

namespace view;
	
class HTMLView {
	
	private $HTMLBody ="";
	
	public function __construct() {
		
	}
	
	public function showHTML($HTMLBody) 
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
