<?php
	class MenuLoader
	{
		private static function loadConfiguration()
		{
			return simplexml_load_file(dirname(__FILE__)."/../Config/menu.config.xml");
		}
		
		static function loadMenu()
		{
			$menu = self::loadConfiguration();
			
			$html = "";
			
			$menuitems = $menu->menuitem;
			$resources = Loaders_ResourceLoader::instance();
			
			foreach($menuitems as $item)
				$html .= self::loadMenuItem($item, $resources);
			
			echo $html;
		}
		
		private static function loadMenuItem($menuitem, $resources){
			$controller = (string)$menuitem["controller"];
			
			$view = (string)$menuitem["view"];
			$title = (string)$menuitem["title"];
			$iconclass = (string)$menuitem["iconclass"];
			$r = (string)$menuitem["roles"];
			$roles = (explode(",",$r));
			
			$requiresadmin = in_array("AM", $roles);
			$requiresauth = sizeof($roles) > 0 && !in_array("", $roles);
			
			$html = "";
			
			if($requiresauth && !Model_GebruikerModel::isLoggedIn())
				return $html;
			
			if($requiresadmin && !Model_GebruikerModel::IsAdmin(Utils_SessionHelper::getUser()->id))
				return $html;
			
			if(sizeof($menuitem->menuitem) > 0) {
				$html .= "<li class='nav-item nav-dropdown'>";
				$html .= "<a class='nav-link nav-dropdown-toggle' href='#'>";
			}
				
			else {
				$html .= "<li class='nav-item'>";
				$html .= "<a class='nav-link' href='/" . $controller . "/" . $view . "'>";
			}
			//var_dump($resources->instance);
			$html .= "<i class='" . $iconclass . "'></i> " . $resources->$title . "</a>";
			
			if(sizeof($menuitem->menuitem) > 0) {
				$html .= "<ul class='nav-dropdown-items'>";
                
				
				foreach($menuitem->menuitem as $subitem) {
					$html .= self::loadMenuItem($subitem, $resources);
				}
				$html .= "</ul>";
			}
			
			
            $html .= "</li>";
			return $html;
		}
	}
?>