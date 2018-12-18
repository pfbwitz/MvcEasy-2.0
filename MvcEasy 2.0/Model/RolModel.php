<?php
	class RolModel extends Model_BaseModel
	{
		static function insert($entity)
		{
			return self::database()->table(ROL_TABLE)->insert(
				'NAAM', $entity->naam,
				'CODE', $entity->code
			)->execute();
		}
		
		static function update($entity)
		{
			self::database()->table(ROL_TABLE)->update(
				$entity->id, 
				'NAAM', $entity->naam,
				'CODE', $entity->code
				)->execute();
		}
		
		static function delete($id)
		{
			self::database()->table(ROL_TABLE)->delete($id)->execute();
		}
		
		static function getAll()
		{
			if($obj = self::database()->table(ROL_TABLE)->select()->fetch()->all()){ 
				$a = array();
				foreach($obj as $o){
					array_push($a, Entities_RolEntity::map($o));
				}
				
				return $a;
			} 
		}
		
		static function getOneById($id)
		{
			if($obj = self::database()->table(ROL_TABLE)->select()->where("ROL_ID = " . $id)->fetch()->single()){ 
					return Entities_RolEntity::map($obj);
				} 
		}
		
		static function getOneByCode($code)
		{
			if($obj = self::database()->table(ROL_TABLE)->select()->where("CODE = " . $code)->fetch()->single()) { 
				return Entities_RolEntity::map($obj);
			} 
		}
	}