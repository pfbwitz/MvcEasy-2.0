<?php
	class ApiService extends Services_BaseService {
		
		function __construct($controller){
			$this->controller = $controller;
		}
		
		function usersOnNeedDataSource()
		{
			$sorting = "";
			$searchUsername = "";
			$searchName = "";
			$pagesize = 10;
			$pagenumber = 1;
			
			if(Utils_DataHelper::variableIsSet("searchusername"))
				$searchUsername = Utils_DataHelper::get("searchusername");
			
			if(Utils_DataHelper::variableIsSet("searchname"))
				$searchName = Utils_DataHelper::get("searchname");
			
			
			if(Utils_DataHelper::variableIsSet("sorting") && !isNullOrEmpty(Utils_DataHelper::get("sorting")))
			{
				$components = explode(" ", Utils_DataHelper::get("sorting"));
				$column = "";
				$direction = $components[1];
				switch($components[0])
				{
					case "1":
						$column = "USERNAME ";
						break;
					case "2":
						$column = "NAME ";
						break;
					case "3":
						$column = "EMAIL ";
						break;
					case "4":
						$column = "ACTIVE ";
						break;
				}
				$sorting = $column . $direction;
			}
			
			if(Utils_DataHelper::variableIsSet("pagesize"))
				$pagesize = (int)Utils_DataHelper::get("pagesize");
			if(Utils_DataHelper::variableIsSet("pagenumber"))
				$pagenumber = (int)Utils_DataHelper::get("pagenumber");
			
			$count = 0;
			$users = Model_GebruikerModel::search($searchUsername, $searchName, $pagesize, $pagenumber, $sorting, $count);
			
			$numberOfPages = ceil($count / $pagesize);
			
			foreach($users as $user) {
				$user->prefetch();
				$user->removeSensitiveData();
			}
			
			$datasource = new ViewModel_DataSourceViewModel();
			$datasource->items = $users;
			$datasource->total = sizeof($users);
			$datasource->pagesize = $pagesize;
			$datasource->pagenumber = $pagenumber;
			$datasource->numberOfPages = $numberOfPages;
			
			return json_encode($datasource);
		}
		
		function getOneUserById()
		{
			$id = (int)Utils_DataHelper::get("id");
			$user = Model_GebruikerModel::getOneById($id);
			return json_encode($user);
		}
		
		function saveUser()
		{
			$username = Utils_DataHelper::get("username");
			
			//Check for whitespaces in the username
			if(preg_match('/\s/',$username)) {
				return $this->controller->resources->ErrUsernameSpaces;  
			}
			
			$name = Utils_DataHelper::get("name");
			$email = Utils_DataHelper::get("email");
			$id = Utils_DataHelper::get("id");
			$active = Utils_DataHelper::get("active");
			
			$gebruikerEntity = new Entities_GebruikerEntity();
			$gebruikerEntity->email = $email;
			$gebruikerEntity->active = $active == "true" ? 1 : 0;
			$gebruikerEntity->name = $name;
			$gebruikerEntity->username = $username;
			
			//new
			if(isNullOrEmpty($id)){
				if(Model_GebruikerModel::getOneByUsername($username) != null) {
					return $this->controller->resources->ErrUsernameExists;  
				}
				
				if(Model_GebruikerModel::getOneByEmail($email) != null) {
					return $this->controller->resources->ErrEmailExists;  
				}
				
				$password = Utils_DataHelper::get("password");
				
				$gebruikerEntity->hash = Utils_SecurityHelper::generateHash();
				$gebruikerEntity->iterations = 6381;
				$gebruikerEntity->salt = Utils_SecurityHelper::generateHash();;
				$gebruikerEntity->password = Utils_SecurityHelper::hashPasswordForNewUser(
					$gebruikerEntity->iterations, 
					$gebruikerEntity->hash, 
					$gebruikerEntity->salt, 
					$password
				);
				
				$id = Model_GebruikerModel::insert($gebruikerEntity);
				
			} else {
				$gebruikerEntity = Model_GebruikerModel::getOneById($id);
				
				if(Model_GebruikerModel::getOneByUsername($username) != null && strtolower($username) != strtolower($gebruikerEntity->username)) {
					return $this->controller->resources->ErrUsernameExists;  
				}
				
				if(Model_GebruikerModel::getOneByEmail($email) != null && strtolower($email) != strtolower($gebruikerEntity->email)) {
					return $this->controller->resources->ErrEmailExists;  
				}
				
				$gebruikerEntity->email = $email;
				$gebruikerEntity->active = $active == "true" ? 1 : 0;
				$gebruikerEntity->name = $name;
				$gebruikerEntity->username = $username;
				
				$roleIds = json_decode(Utils_DataHelper::get("roleIds"));
				Model_GebruikerrolModel::deleteByUserId($gebruikerEntity->id);
				foreach($roleIds as $roleId) {
					$roleEntity = new Entities_GebruikerrolEntity();
					$roleEntity->userId = $gebruikerEntity->id;
					$roleEntity->roleId = $roleId->roleId;
					
					Model_GebruikerrolModel::insert($roleEntity);
				}
				Model_GebruikerModel::update($gebruikerEntity);
			}
			$retval = Model_GebruikerModel::getOneById($id);
			$retval->prefetch();
			$retval->removeSensitiveData();
			return json_encode($retval);
		}
		
		function generateRandomPassword() {
			$alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
			$pass = array(); //remember to declare $pass as an array
			$alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
			for ($i = 0; $i < 8; $i++) {
				$n = rand(0, $alphaLength);
				$pass[] = $alphabet[$n];
			}
			return implode($pass); //turn the array into a string
		}
	}
?>