<?php
	class DiagnosticsController extends BaseController 
	{
		public $queryResult;
		
		public $service;
		
		public $statement;
		
		function __construct()
		{
			parent::__construct();
			
			$this->service = new Services_DiagnosticsService($this);
		}
		
		function IndexAction()
		{
		}
		
		function SqlAction()
		{
			if(Utils_DataHelper::isPost())
			{
				$this->queryResult = $this->service->performSelect();
			}
		}
	}
?>