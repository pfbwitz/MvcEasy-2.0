<?php 
	class ConnectionHelper 
	{
		static function getConnection()
		{
			$mysqli = new mysqli(
				Utils_ConfigHelper::getDatabaseServer(),
				Utils_ConfigHelper::getDatabaseUser(),
				Utils_ConfigHelper::getDatabasePassword(),
				Utils_ConfigHelper::getDatabaseName()
			);
			
			if ($mysqli->connect_errno) {
				printf("Connect failed: %s\n", $mysqli->connect_error);
				exit();
			}
			return $mysqli;
		}
	}
?>