<?php
	class ErrorHelper {
		 function GetExceptionLog(Exception $e) {
			$trace = $e->getTrace();

			$result = 'Exception: "';
			$result .= $e->getMessage();
			$result .= '" @ ';
			if($trace[0]['class'] != '') {
			  $result .= $trace[0]['class'];
			  $result .= '->';
			}
			$result .= $trace[0]['function'];
			$result .= '();<br />';

			return $result;
		  }
		  
		  function logEvent($exception) {
			Model_ErrorlogModel::insert($exception);
			// $file = "C:\\" . $filename . '_' . date("d_m_Y") . '.txt';
			
			// $c = file_get_contents($file);
			
			// $current = $c . date("hh:mm:ss d-m-Y") . "\n" . $message."\n";
			
			// file_put_contents($file, $current);
		}
	}
?>