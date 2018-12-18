<?php 
	function __autoload($classname) {
		$path = (strpos(strtoupper($classname), "CONTROLLER") !== false) ? 
			"Controllers/" . $classname : 
				str_replace("_", "/", $classname);
	
		$file = $_SERVER["DOCUMENT_ROOT"] . "/" . str_replace("_", "/", $path) . ".php";
		if(file_exists($file))
			include_once($file);
		else
			return;
		
		if(strpos($classname, "_") !== false)
			class_alias(explode ("_", $classname)[sizeof(explode ("_", $classname)) - 1], $classname);
	}
	
	function using($file){
		include_once($file);
	}
	
	class AutoLoader{
		static function load(){
			self::loadPhp();	
			self::loadLibraries();
			//self::loadStyles();
			//self::loadScripts();
		}	

		static function loadLibraries(){
			foreach (glob("lib/*.php") as $filename) {
				using($filename);
			}
		}

		static function loadStyles(){
			foreach (glob("css/*.css") as $filename) {
				echo "\n<link rel='stylesheet' href='/" . $filename . "'>";
			}
		}

		static function loadScripts(){
			foreach (glob("js/*.js") as $filename)	
				echo "\n<script type='text/javascript' src='/" . $filename . "'></script>";
			
			foreach(glob('js/*', GLOB_ONLYDIR)as $r) {
				foreach (glob($r."/*.js") as $filename)	
					echo "\n<script type='text/javascript' src='/" . $filename . "'></script>";
			}
		}

		static function loadPhp(){
			foreach(glob('*', GLOB_ONLYDIR) as $dir){
				if(
					$dir != 'script' && 
					$dir != 'Views' && 
					$dir != 'Config' &&
					$dir != 'Controllers' &&
					$dir != 'Entities' &&
					$dir != 'Loaders' &&
					$dir != 'Model' &&
					$dir != 'Utils'
				)
					self::loadDir($dir);	
			}
		}

		private static function loadDir($dir = null){
			foreach (glob("$dir/*.php") as $filename)
				if($filename != "AutoLoader.php")
					using($filename);

			foreach(glob("$dir/".'*', GLOB_ONLYDIR) as $dir){
				if($dir != 'script' && $dir != 'Views' && $dir != 'Config')
					self::loadDir($dir);		
			}
		}

		static function LoadMenu(){
			using('Menu.php');
		}
	}
	
?>