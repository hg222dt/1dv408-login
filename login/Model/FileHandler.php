<?php

namespace model;

class FileHandler
{
	
	//funktion som tar bort en användare från en fil.
 	public function removeUserFromFile($user, $password, $filename)
	{
		//filen med användare
		$existingUsers = file($filename);
		
		//en ny fil som ska ersätta den gamla.
		$newFile = fopen("newFile.txt","a");
		
		//loop som lägger över alla medlemmar (utom den som ska bort) i den nya filen.
		foreach($existingUsers as $existingUser)
		{
			//delar upp raderna 
            $userArr = explode(":",trim($existingUser));
			
			if($userArr[0] !== $user && $userArr[1] !== $password)
			{
				fwrite($newFile, $existingUser."\n");
			}
		}
		//döper om den nya filen. den gamla user-filen försvinner.
		rename("newFile.txt", "cookieUsers.txt");
	}
	
	
	//kollar varje rad i filen med användare:lösenord. returnerar true om användaren hittas.
    public function UserIsInFile($user, $password, $filename)
    {
		$existingUsers = file($filename);
		
	    foreach($existingUsers as $existingUser)
	    {
	        //delar upp raderna 
	        $userArr = explode(":",trim($existingUser));

	        //returnerar true om användaren med lösenordet finns i filen
	        if($userArr[0] === $user && $userArr[1] === $password)
	        {
	        	if(array_key_exists(2, $userArr))
	        	{
	        		//om tiden inte gått ut än: true, annars false;
					return $userArr[2] > time();	
				}
				// om det finns ett expiration-date i filen
				else
				{
					return true;
				}
	        }

	    }
		return false;
	}
	
	//lägger till användare med ett utgångsdatum
	public function addUserWithExpiration($user, $password, $expiration, $filename)
	{
		$cookieUsers = fopen($filename, "a");
		fwrite($cookieUsers, $user.":".$password.":".$expiration."\n");
	}					
					
}
