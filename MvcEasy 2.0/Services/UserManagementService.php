<?php
	class UserManagementService extends Services_BaseService {
		
		public $roles;
		
		function __construct($controller){
			$this->controller = $controller;
		}
		
		function setupRoles(){
			$this->roles = Model_RolModel::getAll();
		}
	}
?>