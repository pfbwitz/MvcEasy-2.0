<?php
	class ApiController extends BaseController {
		public $service;
		
		function __construct()
		{
			parent::__construct();
			
			$this->service = new Services_ApiService($this);
		}
		
		function usersOnNeedDataSourceAction(){
			echo $this->service->usersOnNeedDataSource();
		}
		
		function getUserById(){
			echo $this->service->getUserById();
		}
		
		function usersSaveAction(){
			echo $this->service->saveUser();
		}
		
		function getRandomPasswordAction(){
			echo $this->service->generateRandomPassword();
		}
	}
?>