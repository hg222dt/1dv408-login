<?php

namespace view;

//En klass som skapar html-kroppen  	
class HTMLView {

	//Funktion som ritar ut html på sidan. Tar emot innehållet som parameter. 
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
