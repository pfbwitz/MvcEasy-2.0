<?php
class GebruikerrolEntity extends Entities_BaseEntity implements Entities_IEntity 
{
	private $_userId;
	
	private $_roleId;
	
	public $role;
	
	public $user;
	
    function __construct()
	{
        Utils_SessionHelper::initSession();
        $this->_tablename = URE_TABLE;
	}
	
   public function __get($name)
	{
		$property = '_' . $name;
		if(!property_exists($this, $property))
			throw new InvalidArgumentException(
			"Het veld '$name' is invalid"		
		);
		return $this->$property;
	}
    
    static function map($obj)
	{
    	$ent = new GebruikerrolEntity();
		
		$ent->id = $obj->URE_ID;
    	$ent->userId = $obj->USR_ID;
		$ent->roleId = $obj->ROL_ID;
		
		return $ent;
    } 
	
	function getRole()
	{
		return Model_RolModel::getOneById($this->roleId);
	}
	
	function getGebruiker()
	{
		return Model_GebruikerModel::getOneById($this->userId);
	}
	
	function prefetch($prefetchChilren = false)
	{
		$this->role = $this->getRole();
		$this->user = $this->getGebruiker();
		$this->user->removeSensitiveData();
		
		if($prefetchChilren) {
			$this->role->prefetch();
			$this->user->prefetch();
		}
	
		return $this;
	}
}

?>
