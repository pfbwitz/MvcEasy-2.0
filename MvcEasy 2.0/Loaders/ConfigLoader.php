<?php
	define("ENV_DEV", "dev");
	define("ENV_TST", "tst");
	define("ENV_PRD", "prd");
	
	class ConfigLoader
	{
		static function loadConfiguration()
		{
			return simplexml_load_file(dirname(__FILE__)."/../Config/" . self::getCurrentEnvironment(). ".config.xml");
		}
		
		static function loadSecurityConfiguration(){
			return simplexml_load_file(dirname(__FILE__)."/../Config/security.config.xml");
		}
		
		static function getCurrentEnvironment()
		{
			if(self::isServer(ENV_DEV))
				return ENV_DEV;
			else if((self::isServer(ENV_TST))) 
				return ENV_TST;
			else 
				return ENV_PRD;
		}
		
		private static function isServer($s)
		{
			
			$server = $_SERVER['HTTP_HOST'];
			if($server == 'localhost' || contains($server, 'localhost') || contains($server, '192.168'))
				return 'dev';
			$pos = substr($server, 0, 3) == $s;
			$result = $pos == 1;
			
			return $result;
		}
	}
?>