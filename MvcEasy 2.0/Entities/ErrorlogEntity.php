<?php
class ErrorlogEntity extends Entities_BaseEntity implements Entities_IEntity 
{
	
	private $_datetime;
	
	private $_error;
	
	private $_gebruikerId;
	
	private $_stacktrace;
	
	public $abonnementen;
	
    function __construct()
	{
        Utils_SessionHelper::initSession();
        $this->_tablename = ELG_TABLE;
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
    	$ent = new ErrorlogEntity();
		$ent->id = $obj->ELG_ID;
    	$ent->datetime = $obj->DATETIME;
		$ent->error = $obj->ERROR;
		$ent->gebruikerId = $obj->GBR_ID;
		$ent->stacktrace = $obj->STACKTRACE;
		return $ent;
    } 
	
	function prefetch($prefetchChilren = false)
	{
		return $this;
	}
}

?>
