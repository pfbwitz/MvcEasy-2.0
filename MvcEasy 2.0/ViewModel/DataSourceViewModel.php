<?php 
	class DataSourceViewModel {
		private $_items;
		private $_pagesize;
		private $_pagenumber;
		private $_total;
		private $_numberOfPages;
		
		public function __get($name)
		{
			$property = '_' . $name;
			if(!property_exists($this, $property))
				throw new InvalidArgumentException(
				"Het veld '$name' is invalid"		
			);
			return $this->$property;
		}
	}
?>