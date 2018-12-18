<?php
	class SessionHelper {
		static function initSession(){
			if(session_status() == PHP_SESSION_NONE)
				session_start();
		}
		
		static function endSession(){
			if(session_status() != PHP_SESSION_NONE){
				session_unset();
				session_destroy();
			}
		}
		
		static function get($variable){
			self::initSession();
			return $_SESSION[$variable];
		}
		
		static function set($variable, $value){
			self::initSession();
			$_SESSION[$variable] = $value;
		}
		
		static function variableIsSet($variable){
			self::initSession();
			return isset($_SESSION[$variable]);
		}

		static function getUser(){
			$user = new Entities_GebruikerEntity();
			if(Model_GebruikerModel::isLoggedIn())
				$user = Model_GebruikerModel::getOneById(self::get('id')); 
			return $user;
		}
	}
?>