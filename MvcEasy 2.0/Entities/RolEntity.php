<?php
class RolEntity extends Entities_BaseEntity implements Entities_IEntity {
	
	private $_naam;
	
	private $_code;
	
	public $gebruikerRollen;
	
    function __construct()
	{
        Utils_SessionHelper::initSession();
        $this->_tablename = ROL_TABLE;
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
    	$ent = new RolEntity();
		$ent->id = $obj->ROL_ID;
    	$ent->code = $obj->CODE;
		$ent->naam = $obj->NAAM;
		return $ent;
    } 
	
	function getGebruikerrollen()
	{
		return Model_GebruikerrolModel::getByRolId($this->id);
	}
	
	function prefetch($prefetchChilren = false)
	{
		return $this;
	}
}

?>
