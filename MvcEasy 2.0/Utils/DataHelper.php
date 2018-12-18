<?php
	class DataHelper {
		static function isPost(){
			return $_SERVER['REQUEST_METHOD'] === 'POST';
		}
		
		static function get($variable){
			return $_POST[$variable];
		}
		
		static function variableIsSet($variable){
			return isset($_POST[$variable]);
		}
		
		static function parametersAsArray($p){
			return explode('/', $p);
		}
		
		static function removeApiMethodFromParameters($p){
			array_splice($p, 0, 1);
			return $p;
		}
		
		static function getUrlParameters(){
			$url = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
			$parts = parse_url($url);
			
			if(!isset($parts['query']))
				return null;
			
			parse_str($parts['query'], $query);
			return $query;
		}
		
		static function getUrlParameter($parameterName, $parameters = null){
			if($parameters != null)
				return $parameters[$parameterName];
			return self::getUrlParameters()[$parameterName];
		}
	}
?>