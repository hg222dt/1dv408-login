<?php

class Login
{
	//kollar så angiven användare finns med rätt lösenord
	public function authenticateUser($user, $password)
	{		
	    //filen där alla tusentals användare och lösenord sparas
        $existingUsers = file("users.txt");

        //kollar varje rad i filen med användare:lösenord
        foreach($existingUsers as $existingUser)
        {
            //delar upp raderna 
            $userArr = explode(":",trim($existingUser));
            
            //returnerar true om användaren med lösenordet finns i filen
            if($userArr[0] === $user && $userArr[1] === $password )
            {
                return true;
            }
        }
        return false;

	}
	
}
