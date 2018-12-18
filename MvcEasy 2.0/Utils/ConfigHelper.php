<?php
	class ConfigHelper {
		static function getDatabaseServer(){
			return (string)Loaders_ConfigLoader::LoadConfiguration()
				->database->server;
		}
		
		static function getDatabaseUser(){
			return (string)Loaders_ConfigLoader::LoadConfiguration()
				->database->user;
		}
		
		static function getDatabaseName(){
			return (string)Loaders_ConfigLoader::LoadConfiguration()
				->database->db;
		}
		
		static function getDatabasePassword(){
			return (string)Loaders_ConfigLoader::LoadConfiguration()
				->database->password;
		}
	}
?>