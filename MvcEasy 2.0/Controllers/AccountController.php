<?php
	class AccountController extends BaseController {
		public $service;
		
		function __construct()
		{
			parent::__construct();
			
			$this->service = new Services_AccountService($this);
			
			$this->service->clearFields();
		}
		
		function IndexAction() 
		{
			if(!$this->isLoggedIn())
				Redirect("/Account/Login/");
			
			if(Utils_DataHelper::isPost())
				$this->service->updateUser();
		}
		
		function LoginAction() 
		{
			$this->renderLayout = false;
			$this->service->login();
		}
		
		function LogoutAction()
		{
			$this->service->logout();
		}
		
		function ChangePasswordAction()
		{
			if(!$this->isLoggedIn()) 
				Redirect("/Account/Login/");
			
			if(Utils_DataHelper::isPost())
				$this->service->changePassword();
		}
		
		function RegisterAction() {
			if($this->isLoggedIn()) 
				Redirect("/Account/Index/");
			
			$this->service->register();
		}
		
		function ForgotPasswordAction(){
			if($this->isLoggedIn()) 
				Redirect("/Account/Index/");
			
			$this->service->resetPassword();
		}
	}
?>