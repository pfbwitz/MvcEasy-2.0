<?php
	class GebruikerModel extends Model_BaseModel
	{
		static function insert($entity)
		{
			return self::database()->table(USR_TABLE)->insert(
				'EMAIL', $entity->email,
				'NAME', $entity->name,
				'USERNAME', $entity->username,
				'PASSWORD', $entity->password,
				'HASH', $entity->hash,
				'ITERATIONS', $entity->iterations,
				'SALT', $entity->salt,
				'ACTIVE', $entity->active
				
			)->execute();
		}
		
		static function update($entity)
		{
			self::database()->table(USR_TABLE)->update(
				$entity->id, 
				'EMAIL', $entity->email,
				'USERNAME', $entity->username,
				'NAME', $entity->name,
				'PASSWORD', $entity->password,
				'HASH', $entity->hash,
				'ITERATIONS', $entity->iterations,
				'SALT', $entity->salt,
				'ACTIVE', $entity->active,
				'FORGOTTEN_CODE', $entity->forgottenCode,
				'FORGOTTEN_TIMESTAMP', $entity->forgottenTimestamp
				)->execute();
		}
		
		static function delete($id)
		{
			self::database()->table(USR_TABLE)->delete($id)->execute();
		}
		
		static function getAll()
		{
			if($obj = self::database()->table(USR_TABLE)->select()->fetch()->all()) { 
				$a = array();
				foreach($obj as $o) {
					array_push($a, Entities_GebruikerEntity::map($o));
				}
				return $a;
			} 
		}
		
		static function search($username, $name, $pagesize, $pagenumber, $sorting, &$count)
		{
			$count = self::database()->table(USR_TABLE)->countTotal();
			
			$query = self::database()->table(USR_TABLE)->select();
			if(!isNullOrEmpty($username))
				$query = $query->where("LCASE(USERNAME) LIKE '" . $username . "%'");
			
			if(!isNullOrEmpty($name))
				$query = $query->where("LCASE(NAME) LIKE '" . $name . "%'");
			
			$pagenumber--;
			$limit = ($pagenumber * $pagesize) . ", " . $pagesize;
			
			$query = $query->limit($limit);
			
			if(isNullOrEmpty($sorting))
				$query = $query->orderBy("USERNAME", "ASC");
			else {
				$s = explode(" ", $sorting);
				if(sizeof($s) == 2)
					$query = $query->orderBy($s[0], $s[1]);
			}
				
			
			if($obj = $query->fetch()->all()) { 
				$a = array();
				foreach($obj as $o) {
					array_push($a, Entities_GebruikerEntity::map($o));
				}
				return $a;
			} 
		}
		
		static function getOneById($id)
		{
			if($obj = self::database()->table(USR_TABLE)->select()->where("USR_ID = " . $id)->fetch()->single()){ 
					return Entities_GebruikerEntity::map($obj);
				} 
		}
		
		static function getOneByUsername($username)
		{
			if($obj = self::database()->table(USR_TABLE)->select()->where("USERNAME = '" . $username . "'")
					->fetch()->singleOrDefault()){ 
				
					return Entities_GebruikerEntity::map($obj);
				} 
		}
		
		static function getOneByEmail($email)
		{
			if($obj = self::database()->table(USR_TABLE)->select()->where("EMAIL = '" . $email . "'")
					->fetch()->singleOrDefault()){ 
				
					return Entities_GebruikerEntity::map($obj);
				} 
		}
		
		static function getUserId($username, $password)
		{
				if($obj = self::database()->table(USR_TABLE)->select()->where("USERNAME = '" . $username . "'")
					->fetch()->singleOrDefault()){ 
				
					if(!Utils_SecurityHelper::validatePassword($obj->USR_ID, $password))
						return false;

					return $obj->USR_ID;
				} 
		}
		
		static function changePassword($userEntity, $newPassword){
			$hash = Utils_SecurityHelper::hashPasswordForMatch($userEntity->id, $newPassword);
			$userEntity->password = $hash;
			self::update($userEntity);
		}
		
		static function IsLoggedIn()
		{
			return Utils_SessionHelper::variableIsSet('id');
		} 
		
		static function IsAdmin($id)
		{
			return self::getOneById($id)->isInRole("AM");
		} 
	}