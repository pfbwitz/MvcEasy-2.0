<?php 
	class BaseModel 
	{
		protected static function database()
		{
			return new Data_DatabaseEngine();
		}

	}
?>