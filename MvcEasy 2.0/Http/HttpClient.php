<?php
	define("HTTP_METHOD_POST", "POST");
	define("HTTP_METHOD_GET", "GET");
	define("HTTP_RESPONSE_METHOD_JSON", "JSON");
	define("HTTP_RESPONSE_METHOD_XML", "XML");
	
	abstract class HttpClient 
	{
		protected $data;
		protected $headers;
		protected $uri;
		
		protected $response_method;
		
		function __construct()
		{
			$parameters = func_get_args();
			if(sizeof($parameters)> 0)
				$this->uri = $parameters[0];
			
			$this->data = array();
			$this->headers = array();
			$this->addHeader("header", "Content-type: application/x-www-form-urlencoded\r\n");
		}
		
		function getContentQuery()
		{
			return http_build_query($this->data);
		}
		
		function addHeaders(array $headers) 
		{
			$result = $headers;
			if(sizeof($this->headers) > 0)
				$result = array_merge($this->headers['http'], $headers);	
			$this->headers = array('http' => $result);
		}
		
		function addHeader($key, $value)
		{
			if(sizeof($this->headers > 0)) 
				$this->headers['http'][$key] = $value;
			else
				$this->headers = array('http' => array($key => $value));
		}
		
		function addParameters(array $data) 
		{
			foreach($data as $key => $value) {
				addParameter($key, $value);
			}
		}
		
		function addParameter($key, $value)
		{
			$this->data[$key] = $value;
		}
		
		function response()
		{
			if(!array_key_exists("method", $this->headers["http"]))
				throw new Exception("request method not set");
			
			if($this->headers["http"]["method"] == HTTP_METHOD_GET) {
				if(!strpos($this->uri, '?'))
					$this->uri = $this->uri."?";
				
				foreach($this->data as $key => $value) {
					$this->uri = $this->uri . $key . "=" . $value . "&";
				}
				$this->uri = rtrim($this->uri, "&");
			}
			
			$context  = stream_context_create($this->headers);
			$result = file_get_contents($this->uri, false, $context);
			if($result === FALSE)
				return false;
			
			if($this->response_method == HTTP_RESPONSE_METHOD_JSON)
				return json_decode($result);
			else if($this->response_method == HTTP_RESPONSE_METHOD_XML)
				return simplexml_load_string($result, "SimpleXMLElement", LIBXML_NOCDATA);
		}
	}
?>