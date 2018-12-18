<?php 
	class Emailer {
		private $_from;
		private $_to;
		private $_cc;
		private $_bcc;
		private $_subject;
		private $_message;
		private $_headers;
		
		public function __construct(){
			return $this;
		}

		public function __get($name){
			$property = '_' . strtolower($name);
			if(!property_exists($this, $property))
				throw new InvalidArgumentException(
				"Het veld '$name' is ongeldig"		
			);
			return $this->$property;
		}
		
		function send(){
			

			//Stupid Php overloading. C# > php
			$optionalArgs = func_get_args();
			
			$config = Loaders_ConfigLoader::loadConfiguration();
			
			$sender = (string)$config->mail->sender;
			$recipient = (string)$config->mail->recipient;
			
			if(sizeof($optionalArgs)> 0) {
				$headers  = "MIME-Version: 1.0" . "\r\n";
				$headers .= "Content-type: text/html; charset=iso-8859-1" . "\r\n";
				$headers .= "To: <" . $recipient . ">" . "\r\n";
				$headers .= 'From: <' . $sender . '>' . "\r\n";
				$headers .= "Bcc: $optionalArgs[3]" . "\r\n";
				$this->_headers = $headers;
			
				return mail($optionalArgs[0], $optionalArgs[1], $optionalArgs[2], $this->_headers);
			}

			return mail($this->_to, $this->_subject, $this->_message, $this->_headers);
		}

		
	}
?>