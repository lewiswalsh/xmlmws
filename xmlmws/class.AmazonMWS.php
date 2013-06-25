<?php

	namespace XMLMWS;

	class AmazonMWS {
	
		protected $php_date_format = 'Y-m-d\TH:i:s\Z';
			
	
		/**
		*	Function createMWSUri
		*	
		*	Creates the URI to submit to the API endpoint along with the MD5 signature.
		*	
		*	@action 		(string)	The API action to call eg. GetServiceStatus
		*	@api_endpoint	(string)	The endpoint of the API to submit to eg. /Sellers/2011-07-01
		*	@api_version	(string)	The API version, usually found at the end of the api endpoint eg. 2011-07-01
		*	@extra_params	(array)		Associative array of parameters to submit
		*	@http_verb		(string)	Is it a GET, PUT or POST request
		*		
		*/
		protected function createMWSUri($action, $api_endpoint, $api_version, $extra_params=false, $http_verb='POST'){
			$params = Array();
			$params['AWSAccessKeyId']		= AWS_ACCESS_KEY_ID;
			$params['Action']				= $action;
			$params['SellerId']				= MERCHANT_ID;
			$params['SignatureMethod']		= "HmacSHA256";
			$params['SignatureVersion']		= "2";
			$params['Timestamp']			= date($this->php_date_format);
			$params['Version']				= $api_version;
			if($extra_params){ $params = array_merge($params, $extra_params); }
			ksort($params, 4); // argument '4' specifies natural byte ordering for the keys

			$parameter_string = '';
			foreach($params as $k => $v){
				$parameter_string .=  rawurlencode($k) ."=".  rawurlencode($v) ."&"; // rawurlencode to adhere to RFC 3986
			}
			$parameter_string = rtrim($parameter_string, '&'); // remove extraneous ampersand from end
			
			$query_request_string = $http_verb ."\n"; // POST or GET
			$query_request_string .= SERVICE_URL ."\n"; 
			$query_request_string .= $api_endpoint ."\n"; 
			$query_request_string .= $parameter_string; 
			
			$signature = base64_encode(hash_hmac('sha256', $query_request_string, AWS_SECRET_ACCESS_KEY, TRUE)); // Set TRUE at end of hash_hmac for raw binary output
			$uri = "https://". SERVICE_URL . $api_endpoint ."?". $parameter_string ."&Signature=". urlencode($signature);		
			return $uri;
		}
		
		
		
		/**
		*	Function mwsCurlRetrieve
		*	
		*	Retrieves XML response from Amazon MWS where XML submission is not required
		*	
		*	@uri 	(string)	The string created in createMWSUri()
		*		
		*/
		protected function mwsCurlRetrieve($uri){
			$ch = curl_init($uri);
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_USERAGENT, APPLICATION_USER_AGENT);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			$output = curl_exec($ch);       
			curl_close($ch);
			return $output;
		}
		
		
		
		/**
		*	Function mwsCurlSubmit
		*	
		*	Submits to the API with XML date
		*	
		*	@uri 	(string)	The string created in createMWSUri()
		*	@xml 	(string)	XML payload
		*		
		*/
		protected function mwsCurlSubmit($uri, $xml){
			$feedHandle = @fopen('php://temp', 'rw+');
			fwrite($feedHandle, $xml);
			rewind($feedHandle);
			$content_md5 = base64_encode(md5(stream_get_contents($feedHandle), true));
		
			$ch = curl_init($uri);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				'Content-Type: text/xml',
				'Content-MD5: '. $content_md5,
				'Transfer-Encoding: chunked',
			));
			fclose($feedHandle);
			
			//curl_setopt($ch, CURLINFO_HEADER_OUT, true);
			//curl_setopt($ch, CURLOPT_UPLOAD => true); // SHOULDN'T NEED
			//curl_setopt($ch, CURLOPT_HEADER, 0);
			//curl_setopt($ch, CURLOPT_PROTOCOLS CURLPROTO_HTTPS);
			//curl_setopt($ch, CURLOPT_VERBOSE, true);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_USERAGENT, APPLICATION_USER_AGENT);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
			$output = curl_exec($ch);       
			curl_close($ch);
			
			return $output;
		}
		
				
	}

?>