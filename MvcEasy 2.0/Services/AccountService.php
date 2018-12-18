<?php
	class AccountService extends Services_BaseService{
			
		public $old;
		public $new;
		public $retype;
		
		public $name;
		public $email;
		public $username;
	
		function __construct($controller){
			$this->controller = $controller;
		}
		
		function clearFields(){
			$this->old = "";
			$this->new = "";
			$this->retype = "";
			$this->name = "";
			$this->username = "";
			$this->email = "";
		}
	
		function updateUser(){
			$username = DataHelper::get("username3");
			$name = DataHelper::get("name3");
			$email = DataHelper::get("email3");
			$active = DataHelper::variableIsSet("active3");
			
			if
			(
				$this->controller->gebruiker->username != $username &&
				Model_GebruikerModel::getOneByUsername($username) != null
			) {
				$this->controller->hasError = true;
				$this->controller->error = $this->controller->resources->ErrUsernameExists;  
				return;
			}
			
			if
			(
				$this->controller->gebruiker->email != $email &&
				Model_GebruikerModel::getOneByEmail($email) != null
			) {
				$this->controller->hasError = true;
				$this->controller->error = $this->controller->resources->ErrEmailExists;  
				return;
			}
			
			$this->controller->gebruiker->email = $email;
			$this->controller->gebruiker->name = $name;
			$this->controller->gebruiker->username = $username;
			$this->controller->gebruiker->actiefJn = $active ? 1 : 0;
	
			Model_GebruikerModel::update($this->controller->gebruiker);
			
			$this->controller->message = $this->controller->resources->LblAccountSaved;
			$this->controller->hasMessage = true;
		}
		
		function login() {
			if($this->controller->isLoggedIn()) {
				Redirect("/Home");
			} else if (Utils_DataHelper::variableIsSet('username') && 
				Utils_DataHelper::variableIsSet('password')) {
				$username = Utils_DataHelper::get('username');
				$password = Utils_DataHelper::get('password');
			
				if(isNullOrEmpty($username) || isNullOrEmpty($password)) {
					$this->controller->hasError = true;
					$this->controller->error = $this->controller->resources->LblEnterCredentials;  
				}
				else {
					
					$userId = Model_GebruikerModel::getUserId($username, $password);
					
					if($userId !== false && $userId !== null) {
						Model_GebruikerModel::getOneById($userId)->login();
						Redirect("/Home");
					} else {
						$this->controller->hasError = true;
						$this->controller->error = $this->controller->resources->ErrLogin;  
					}
				}
			}
		}
		
		function logout(){
			if($this->controller->isLoggedIn()) {
				$this->controller->gebruiker->logout();
			}
			Redirect("/Account/Login/");
		}
		
		function changePassword(){
			$this->old = DataHelper::get("password1");
			$this->new = DataHelper::get("password2");
			$this->retype = DataHelper::get("password3");
		
			if($this->controller->gebruiker->password !== utils_securityhelper::hashpasswordformatch($this->controller->gebruiker->id, $this->old)) {
				$this->controller->hasError = true;
				$this->controller->error = $this->controller->resources->LblOldPasswordIncorrect;  
				return;
			}
		
			if($this->new !== $this->retype) {
				$this->controller->hasError = true;
				$this->controller->error = $this->controller->resources->LblErrPasswordMismatch;  
				return;
			}
	
			Model_GebruikerModel::changePassword($this->controller->gebruiker, $this->new);
			
			$this->controller->hasMessage = true;
			$this->controller->message = $this->controller->resources->LblPasswordChanged;
		}
		
		function resetPassword(){
			if(Utils_DataHelper::isPost())
			{
				$username = DataHelper::get("username");
				$gebruikerEntity = Model_GebruikerModel::getOneByUsername($username);
				
				if($gebruikerEntity == null){
					$this->controller->hasError = true;
					$this->controller->error = $this->controller->resources->LblUserNotFound;  
					return;
				}
				$password = Utils_SecurityHelper::generateHash(10);
				$gebruikerEntity->password = Utils_SecurityHelper::hashPasswordForNewUser(
					$gebruikerEntity->iterations, 
					$gebruikerEntity->hash, 
					$gebruikerEntity->salt, 
					$password
				);
				Model_GebruikerModel::update($gebruikerEntity);
				
				$emailer = new Utils_Emailer();
				
				$emailer->to = $gebruikerEntity->email;
				$emailer->subject = "New PfbEasy Quickstart password";
				$emailer->message = $gebruikerEntity->password;
				$emailer->send();
			
				$this->controller->hasMessage = true;
				$this->controller->message = $this->resources->LblNewPasswordSent;
			}
		}
		
		function register(){
			if(Utils_DataHelper::isPost())
			{
				$this->name = DataHelper::get("name");
				$this->username = DataHelper::get("username");
				$this->email = DataHelper::get("email");
				$this->new = DataHelper::get("password");
				$this->retype = DataHelper::get("passwordrepeat");
			
				if(Model_GebruikerModel::getOneByUsername($this->username) != null) {
					$this->controller->hasError = true;
					$this->controller->error = $this->controller->resources->ErrUsernameExists;  
					return;
				}
				
				if(Model_GebruikerModel::getOneByEmail($this->email) != null) {
					$this->controller->hasError = true;
					$this->controller->error = $this->controller->resources->ErrEmailExists;  
					return;
				}
			
				if($this->new !== $this->retype) {
					$this->controller->hasError = true;
					$this->controller->error = $this->controller->resources->LblErrPasswordMismatch;  
					return;
				}
				
				$gebruikerEntity = new Entities_GebruikerEntity();
				$gebruikerEntity->email = $this->email;
				$gebruikerEntity->active = 0;
				$gebruikerEntity->name = $this->name;
				$gebruikerEntity->username = $this->username;
				$gebruikerEntity->hash = Utils_SecurityHelper::generateHash();
				$gebruikerEntity->iterations = 6381;
				$gebruikerEntity->salt = Utils_SecurityHelper::generateHash();;
				$gebruikerEntity->password = Utils_SecurityHelper::hashPasswordForNewUser(
					$gebruikerEntity->iterations, 
					$gebruikerEntity->hash, 
					$gebruikerEntity->salt, 
					$this->new
				);
		
				Model_GebruikerModel::insert($gebruikerEntity);
				
				$this->clearFields();
				$this->controller->hasMessage = true;
				$this->controller->message = $this->controller->resources->LblAccountCreated;
			}
		}
	}
?>