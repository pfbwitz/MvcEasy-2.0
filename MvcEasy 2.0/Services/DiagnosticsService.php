<?php
	class DiagnosticsService extends Services_BaseService
	{		
		
		function __construct($controller){
			$this->controller = $controller;
		}
		
		function performSelect(){
			$statement = Utils_DataHelper::get("statement");
		
			if(!$this->endsWith($statement, ";"))
				throw new Exception("Statement must end with a semicolon");
			
			if(substr_count($statement,";") > 1)
				throw new Exception("Only one statement is allowed");
			
			$this->controller->statement = $statement;
			return Model_DiagnosticsModel::performRawSelect($statement);
		}
		
		function endsWith($haystack, $needle)
		{
			$length = strlen($needle);

			return $length === 0 || 
			(substr($haystack, -$length) === $needle);
		}
	}
?>