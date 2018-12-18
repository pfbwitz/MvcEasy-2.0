<?php
	class ErrorlogModel extends Model_BaseModel
	{
		static function getOneById($id)
		{
			if($obj = self::database()->table(ELG_TABLE)->select()->where("ELG_ID = " . $id)
				->fetch()->single()){ 
					return Entities_ErrorlogEntity::map($obj);
				} 
		}
	
		static function getAll()
		{
				if($obj = self::database()->table(ELG_TABLE)->orderBy('DATETIME', 'DESC')->select()->fetch()->all()){ 
					$a = array();
					foreach($obj as $o){
						array_push($a, Entities_ErrorlogEntity::map($o));
					}
					return $a;
				} 
		}
		
		static function insert($exception)
		{
			$message = $exception;//Utils_ErrorHelper::GetExceptionLog($exception);
			$id = "";
			if(Model_GebruikerModel::isLoggedIn())
				$id = Utils_SessionHelper::get('id');
			
			return self::database()->table(ELG_TABLE)->
				insert('ERROR', $message, 'STACKTRACE', $exception/*->getTraceAsString()*/, 'GBR_ID', $id)->execute();
		}
		
		static function delete($id)
		{
			self::database()->table(ELG_TABLE)->delete($id)->execute();
		}
	}