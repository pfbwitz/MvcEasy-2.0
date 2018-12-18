<?php
	class DiagnosticsModel extends Model_BaseModel
	{
		static function performRawSelect($statement)
		{
			return self::database()->rawSelect($statement);
			
			if($obj = self::database()->rawSelect()) { 
				return $obj;
			} 
			return null;
		}
		
		
	}