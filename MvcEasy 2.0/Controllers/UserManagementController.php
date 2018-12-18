<?php
	class UserManagementController extends BaseController {	
		
		public $service;
		
		function __construct(){
			parent::__construct();
			
			$this->service = new Services_UserManagementService($this);
		}
		
		function IndexAction()
		{
			$this->service->setupRoles();
		}
	}
?>