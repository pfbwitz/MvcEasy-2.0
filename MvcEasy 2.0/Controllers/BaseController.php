<?php
	abstract class BaseController 
	{
		public $gebruiker;
		public $view;
		public $viewname;
		public $renderLayout;
		
		public $hasMessage;
		public $message;
		
		public $hasError;
		public $error;
		
		public $resources;
		
		protected $parameter;
		
		function __construct($param = null)
		{
			$this->resources = Loaders_ResourceLoader::instance();
			
			set_error_handler(array($this, 'myErrorHandler'));
			$this->renderLayout = $this->isLoggedIn();
			
			$this->hasError = false;
			$this->hasMessage = false;
			
			if(!Utils_SecurityHelper::authorizeController($this)){
				Redirect("/Account/");
				return;
			}
			
			$this->parameter = $param;
			if($this->isLoggedIn())
				$this->gebruiker = new Entities_GebruikerEntity();
		}
		
		function myErrorHandler($errno, $errstr, $errfile, $errline){
			$this->handleException(sprintf("PHP %s:  %s in %s on line %d", $errno, $errstr, $errfile, $errline));
			
			if(Loaders_ConfigLoader::getCurrentEnvironment() == ENV_DEV){
				return false;
			}
			
			if (!(error_reporting() & $errno)) {
				
				// This error code is not included in error_reporting, so let it fall
				// through to the standard PHP error handler
				return false;
			}

			switch ($errno) {
			case E_USER_ERROR:
				Redirect("/500.php");
				break;

			case E_USER_WARNING:
				echo "<b>My WARNING</b> [$errno] $errstr<br />\n";
				break;

			case E_USER_NOTICE:
				echo "<b>My NOTICE</b> [$errno] $errstr<br />\n";
				break;

			default:
				Redirect("/500.php");
				break;
			}

			/* Don't execute PHP internal error handler */
			return true;
		}

		function loadView()
		{
			include_once($this->view);
		}

		function isLoggedIn()
		{
			return Model_GebruikerModel::isLoggedIn();
		}

		function handleException($log) 
		{
			Utils_ErrorHelper::logEvent($log);
		}

		function returnResultString($s)
		{
			echo $s; die();
		}
		
		function load()
		{
			include(MASTER_PAGE . BASE_EXTENSION);
		}
		
		function isApiCall()
		{
			return contains(strtolower(get_class($this)), "api");
		}
		
		function isAdmin()
		{
			return $this->isLoggedIn() && $this->gebruiker->isInRole("AM");
		}
		
		function addGrid($gridcontroller){
			include_once(dirname(__DIR__).'/resources/' . $gridcontroller . '.html');
			include_once(dirname(__DIR__).'/resources/grid.html');
		}
	}

?>