<?php
	class GebruikerRolModel extends Model_BaseModel
	{
		static function insert($entity)
		{
			return self::database()->table(URE_TABLE)->insert(
				'USR_ID', $entity->userId,
				'ROL_ID', $entity->roleId
			)->execute();
		}
		
		static function update($entity)
		{
			self::database()->table(URE_TABLE)->update(
				$entity->id, 
				'USR_ID', $entity->userId,
				'ROL_ID', $entity->roleId
				)->execute();
		}
		
		static function delete($id)
		{
			self::database()->table(URE_TABLE)->delete($id)->execute();
		}
		
		static function getOneById($id)
		{
			if($obj = self::database()->table(URE_TABLE)->select()->where("URE_ID = " . $id)->fetch()->single()){ 
				return Entities_GebruikerRolEntity::map($obj);
			} 
		}
	
		static function getByUserId($gebruikerId)
		{
				if($obj = self::database()->table(URE_TABLE)->select()->where("USR_ID = '" . $gebruikerId . "'")
					->fetch()->all()){ 
				
					$a = array();
					foreach($obj as $o){
						$entity = Entities_GebruikerrolEntity::map($o);
						
						array_push($a, $entity);
					}
					return $a;
				} 
		}
		
		static function deleteByUserId($userId){
			$entities = self::getByUserId($userId);
			if($entities != null)
				foreach($entities as $entity)
					self::delete($entity->id);
		}
		
		static function getByRolId($rolId)
		{
			if($obj = self::database()->table(URE_TABLE)->select()->where("ROL_ID = '" . $rolId . "'")
					->fetch()->all()){ 
				
					$a = array();
					foreach($obj as $o){
						
						$entity = Entities_GebruikerrolEntity::map($o);
						
						array_push($a, $entity);
					}
					return $a;
				} 
		}
	}