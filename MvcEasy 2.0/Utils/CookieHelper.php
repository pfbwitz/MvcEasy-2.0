<?php
	class CookieHelper {
		static function acceptCookies(){
			if(Loaders_ConfigLoader::getCurrentEnvironment() == ENV_DEV)
				setcookie("cookiesaccepted", "cookiesaccepted", false, "/", false);
			else
				setcookie("cookiesaccepted", "cookiesaccepted");
		}
		
		static function cookiesAccepted(){
			return isset($_COOKIE["cookiesaccepted"]);
		}
		
		static function RemovecookiesAccepted(){
			
			if (self::cookiesAccepted()) {
				unset($_COOKIE["cookiesaccepted"]);
				setcookie("cookiesaccepted", '', time() - 3600, '/');
			}
		}
	}
?>