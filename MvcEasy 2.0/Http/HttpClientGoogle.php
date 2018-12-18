<?php
	class HttpClientGoogle extends Http_HttpClient 
	{
		function verifyGoogleToken($token)
		{
			$this->response_method = HTTP_RESPONSE_METHOD_JSON;
			$this->uri = "https://www.googleapis.com/oauth2/v3/tokeninfo";
			$this->addParameter("id_token", $token);
			$this->addHeaders(array(
				'method'  => HTTP_METHOD_POST,
				'content' => $this->getContentQuery(),
			));
			return $this->response();
		}
	}
?>