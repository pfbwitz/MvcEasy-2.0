<?php
class SQLException extends RuntimeException{
}

abstract class BaseEntity 
{
	protected $_id;
    protected $_tablename;
}
?>
