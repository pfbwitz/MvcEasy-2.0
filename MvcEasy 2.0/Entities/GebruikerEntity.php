<?php
class GebruikerEntity extends Entities_BaseEntity implements Entities_IEntity 
{
	
	private $_email;
	
	private $_username;
	
	private $_name;
	
	private $_password;
	
	private $_hash;
	
	private $_iterations;
	
	private $_salt;
	
	private $_active;
	
	private $_forgottenCode;
	
	private $_forgottenTimestamp;
	
	public $userroles;
	
    function __construct()
	{
        Utils_SessionHelper::initSession();
        $this->_tablename = USR_TABLE;
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
    
    function logout()
	{
        Utils_SessionHelper::endSession();
    }
    
    function login()
	{
		Utils_SessionHelper::set('id', $this->id);
    }
    
    static function map($obj)
	{
		$resources = Loaders_ResourceLoader::instance();
		
    	$ent = new GebruikerEntity();
    	$ent->email = $obj->EMAIL;
		$ent->name = $obj->NAME;
		$ent->username = $obj->USERNAME;
		$ent->password = $obj->PASSWORD;
		$ent->id = $obj->USR_ID;
		$ent->hash = $obj->HASH;
		$ent->iterations = $obj->ITERATIONS;
		$ent->forgottenCode = $obj->FORGOTTEN_CODE;
		$ent->forgottenTimestamp = $obj->FORGOTTEN_TIMESTAMP;
		$ent->salt = $obj->SALT;
		$ent->active = $obj->ACTIVE;
		$ent->activeJn = $obj->ACTIVE == 1 ? $resources->LblYes : $resources->LblNo;
		
		return $ent;
    } 
	
	function isInRole($rolcode)
	{
		foreach($this->getUserRoles() as $role) {
			if($role->getRole()->code == $rolcode)
				return true;
		}
		return false;
	}
	
	function removeSensitiveData(){
		$this->password = null;
		$this->hash = null;
		$this->salt = null;
		$this->forgottenCode = null;
		$this->forgottenTimestamp = null;
	}
	
	function getUserRoles()
	{
		return Model_GebruikerrolModel::getByUserId($this->id);
	}
	
	function prefetch($prefetchChilren = false)
	{
		$this->userroles = $this->getUserRoles();
		
		
		if($prefetchChilren) {
			if($this->userroles != null) {
				foreach($this->userroles as $u)
					$u->prefetch();
			}
		}
		
		return $this;
	}
}

?>
