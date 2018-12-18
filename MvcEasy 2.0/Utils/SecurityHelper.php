<?php
	class SecurityHelper {
		static function authenticate(){
			if(!Model_GebruikerModel::isLoggedIn()) {
				if(isset($_SERVER["REQUEST_URI"]))
					Redirect('/Security/Index' . $_SERVER["REQUEST_URI"]);
				else
					Redirect('/Security/');
			}
		}
		
		static function hashPasswordForMatch($gebruikerIdFromDatabase, $passwordFromForm){
			$gebruiker = Model_GebruikerModel::getOneById($gebruikerIdFromDatabase);
			$pass = $passwordFromForm;
			for($i=0;$i<$gebruiker->iterations;$i++){
				$pass = $gebruiker->hash . $pass . $gebruiker->hash;
				$pass = md5($pass);
			}
			$pass .= $gebruiker->salt;
			$pass = md5($pass);
			
			return $pass;
		}
		
		static function hashPasswordForNewUser($iterations, $hash, $salt, $passwordFromForm){
			$pass = $passwordFromForm;
			for($i=0;$i<$iterations;$i++){
				$pass = $hash . $pass . $hash;
				$pass = md5($pass);
			}
			$pass .= $salt;
			$pass = md5($pass);
			
			return $pass;
		}
		
		static function validatePassword($gebruikerIdFromDatabase, $passwordFromForm){
			$hash = self::hashPasswordForMatch($gebruikerIdFromDatabase, $passwordFromForm);
			$gebruiker = Model_GebruikerModel::getOneById($gebruikerIdFromDatabase);
			
			return $hash == $gebruiker->password;
		}
		
		static function generateHash($numberOfCharacters = 21){
			$hash = self::generateRandomString($numberOfCharacters);
			for($i = 0;$i < $numberOfCharacters ; $i++){
				$hash = md5($hash);
			}
			while(strlen($hash) < $numberOfCharacters){
				$hash .= md5($hash);
			}
			return strlen($hash) == $numberOfCharacters ? $hash : substr($hash, 0, $numberOfCharacters);
		}
		
		static function generateRandomString($length = 10) {
			$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
			$charactersLength = strlen($characters);
			$randomString = '';
			for ($i = 0; $i < $length; $i++) {
				$randomString .= $characters[rand(0, $charactersLength - 1)];
			}
			return $randomString;
		}
		
		static function authorizeController($controller)
		{
			$controllerFound = false;
			foreach(Loaders_ConfigLoader::loadSecurityConfiguration()->controller as $c){
				$controllerFound = true;
				if($c["name"] == get_class($controller)) {
					if(sizeof(explode(",", (string)$c["roles"])) == 0)
						return true;
					
					if(!Model_GebruikerModel::isLoggedIn())
						return false;
					
					foreach(Utils_SessionHelper::getUser()->getUserRoles() as $role) {
						
						if(in_array($role->getRole()->code, explode(",", (string)$c["roles"])))
							return true;
					}
				}
			}
			return $controllerFound;
		}
	}
?>