<?php
	class ResourceLoader
	{
		private $_resources;
		private $_language;
		
		function __construct(){
			$this->loadResources();
		}
		
		private function loadResourceFile()
		{
			return simplexml_load_file(dirname(__FILE__)."/../Common/resources.xml");
		}
		
		private function loadResources()
		{
			$this->_resources = self::loadResourceFile();
			
			$this->_language = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
		}
		
		public static function instance(){
			return new ResourceLoader();
		}
		
		public function __get($name){
			$retval = null;
			foreach($this->_resources->resource as $resource){
				if(strtolower($resource["name"]) == strtolower($name)){
					foreach($resource->text as $text){
						$locale = (string)$text["locale"];
						$default = (string)$text["default"];
						if($locale == $this->_language)
							$retval = (string)$text;
					}
				}
			}
			
			if($retval == null){
				foreach($this->_resources->resource as $resource){
					if(strtolower($resource["name"]) == strtolower($name)){
						foreach($resource->text as $text){
							$locale = (string)$text["locale"];
							$default = (string)$text["default"];
							
							 if($default == "true")
								 $retval = (string)$text;
						}
					}
				}
			}
			
			return $retval;
		}
	}
?>