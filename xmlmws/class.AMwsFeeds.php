<?php

	namespace XMLMWS;

	class Feeds extends AmazonMWS {
		
		private $api_endpoint = '/';
		private $api_version = '2009-01-01';
		
		
		/***************************************************************
		*	Function SubmitFeed
		*	
		*	Submit XML feed to the API
		*	
		*	@feedContent 		(string)	XML payload
		*	@feedType 			(string)	A FeedType enumeration value indicating how the data should be processed. eg. _POST_PRODUCT_DATA_
		*
		*	@options['markplaceIdList'] 	(array)		Array of one or more marketplace IDs (of marketplaces you are registered to sell in) that you want the feed to be applied to.
		*	@options['purgeAndReplace'] 	(bool)		Indexed array of one or more marketplace IDs (of marketplaces you are registered to sell in) that you want the feed to be applied to.
		*		
		*/
		public function SubmitFeed($feedContent, $feedType, $options=false){
			$params = Array();
			$params['FeedType'] = $feedType;
			if(isset($options['MarkplaceIdList'])){ 
				foreach($options['MarkplaceIdList'] as $index => $mid){
					$params['MarkplaceIdList.Id.'.$index] = $mid;
				}
			}
			if(isset($options['PurgeAndReplace'])){ $params['PurgeAndReplace'] = 'true'; }
			
			$uri = parent::createMWSUri('SubmitFeed', $this->api_endpoint, $this->api_version, $params);
			return parent::mwsCurlSubmit($uri, $feedContent);
		}
		
		
		
		/***************************************************************
		*	Function GetFeedSubmissionList
		*	
		*	Returns a list of feed submissions submitted in the previous 90 days that match the query parameters.
		*	
		*	@options['feedSubmissionIdList'] 		(array)		Indexed array of FeedSubmmissionId values. If you pass in FeedSubmmissionId values in a request, other query conditions are ignored.
		*	@options['maxCount']					(number)	Non-negative. Maximum number of submissions returned. Default 10. Limit 100.
		*	@options['feedTypeList'] 				(array)		Indexed array of FeedType enumeration values to filter by
		*	@options['feedProcessingStatusList'] 	(array)		Indexed array of feed processing statuses
		*	@options['submittedFromDate'] 			(type)		The earliest submission date that you are looking for, in ISO8601 date format eg. 2013-06-18T13:50:17Z' (PHP date format string: 'Y-m-d\TH:i:s\Z')
		*	@options['submittedToDate'] 			(type)		The earliest submission date that you are looking for, in ISO8601 date format eg. 2013-06-18T13:50:17Z' (PHP date format string: 'Y-m-d\TH:i:s\Z')
		*		
		*/
		public function GetFeedSubmissionList($options=false){
			if($options){
				$params = Array();
				if(isset($options['FeedSubmissionIdList'])){ 
					foreach($options['FeedSubmissionIdList'] as $index => $fsid){
						$params['FeedSubmissionIdList.Id.'.$index] = $fsid;
					}
				}
				if(isset($options['MaxCount'])){ $params['MaxCount'] = $options['MaxCount']; }
				if(isset($options['FeedTypeList'])){ 
					foreach($options['FeedTypeList'] as $index => $ft){
						$params['FeedTypeList.Type.'.$index] = $ft;
					}
				}
				if(isset($options['FeedProcessingStatusList'])){ 
					foreach($options['FeedProcessingStatusList'] as $index => $fps){
						$params['FeedProcessingStatusList.Status.'.$index] = $ps;
					}
				}
				if(isset($options['SubmittedFromDate'])){ $params['SubmittedFromDate'] = (is_numeric($options['SubmittedFromDate']) ? date(parent::php_date_format, $options['SubmittedFromDate']) : $options['SubmittedFromDate']);  } // Converts if unixtime provided
				if(isset($options['SubmittedToDate'])){ $params['SubmittedToDate'] = (is_numeric($options['SubmittedToDate']) ? date(parent::php_date_format, $options['SubmittedToDate']) : $options['SubmittedToDate']);  } // Converts if unixtime provided

			} else {
				$params = false;
			}
			
			$uri = parent::createMWSUri('GetFeedSubmissionList', $this->api_endpoint, $this->api_version, $params);
			return parent::mwsCurlRetrieve($uri);
		}
		
		
		
		/***************************************************************
		*	Function GetFeedSubmissionListByNextToken
		*	
		*	As GetFeedSubmissionList() but for next page of existing results. NextToken is required
		*	
		*	@nextToken 		(string)		NextToken from GetFeedSubmissionList()
		*		
		*/
		public function GetFeedSubmissionListByNextToken($nextToken){
			$params = Array();
			$params['NextToken'] = $nextToken;
			
			$uri = parent::createMWSUri('GetFeedSubmissionListByNextToken', $this->api_endpoint, $this->api_version, $params);
			return parent::mwsCurlRetrieve($uri);
		}
		

		
		/***************************************************************
		*	Function GetFeedSubmissionCount
		*	
		*	Returns a count of the total number of feeds submitted in the previous 90 days.
		*	
		*	@options['FeedTypeList'] 				(array)		Indexed array of FeedType enumeration values to filter by
		*	@options['FeedProcessingStatusList'] 	(array)		Indexed array of feed processing statuses
		*	@options['SubmittedFromDate'] 			(type)		The earliest submission date that you are looking for, in ISO8601 date format eg. 2013-06-18T13:50:17Z' (PHP date format string: 'Y-m-d\TH:i:s\Z')
		*	@options['SubmittedToDate'] 			(type)		The earliest submission date that you are looking for, in ISO8601 date format eg. 2013-06-18T13:50:17Z' (PHP date format string: 'Y-m-d\TH:i:s\Z')
		*		
		*/
		public function GetFeedSubmissionCount($options=false){
			if($options){
				$params = Array();
				if(isset($options['feedTypeList'])){ 
					foreach($options['feedTypeList'] as $index => $ft){
						$params['FeedTypeList.Type.'.$index] = $ft;
					}
				}
				if(isset($options['feedProcessingStatusList'])){ 
					foreach($options['feedProcessingStatusList'] as $index => $fps){
						$params['FeedProcessingStatusList.Status.'.$index] = $ps;
					}
				}
				if(isset($options['SubmittedFromDate'])){ $params['SubmittedFromDate'] = (is_numeric($options['SubmittedFromDate']) ? date(parent::php_date_format, $options['SubmittedFromDate']) : $options['SubmittedFromDate']);  } // Converts if unixtime provided
				if(isset($options['SubmittedToDate'])){ $params['SubmittedToDate'] = (is_numeric($options['SubmittedToDate']) ? date(parent::php_date_format, $options['SubmittedToDate']) : $options['SubmittedToDate']);  } // Converts if unixtime provided

			} else {
				$params = false;
			}
			
			$uri = parent::createMWSUri('GetFeedSubmissionCount', $this->api_endpoint, $this->api_version, $params);
			return parent::mwsCurlRetrieve($uri);
		}
		
		
		
		/***************************************************************
		*	Function CancelFeedSubmissions
		*	
		*	Describe function
		*	
		*	@options['FeedTypeList']				(array)		Indexed array of FeedType enumeration values to filter by
		*	@options['FeedProcessingStatusList'] 	(array)		Indexed array of feed processing statuses
		*	@options['SubmittedFromDate'] 			(type)		The earliest submission date that you are looking for, in ISO8601 date format eg. 2013-06-18T13:50:17Z' (PHP date format string: 'Y-m-d\TH:i:s\Z')
		*	@options['SubmittedToDate'] 			(type)		The earliest submission date that you are looking for, in ISO8601 date format eg. 2013-06-18T13:50:17Z' (PHP date format string: 'Y-m-d\TH:i:s\Z')
		*		
		*/
		public function CancelFeedSubmissions($options=false){
			if($options){
				$params = Array();
				if(isset($options['FeedTypeList'])){ 
					foreach($feedTypeList as $index => $ft){
						$params['FeedTypeList.Type.'.$index] = $ft;
					}
				}
				if(isset($options['FeedProcessingStatusList'])){ 
					foreach($feedProcessingStatusList as $index => $fps){
						$params['FeedProcessingStatusList.Status.'.$index] = $ps;
					}
				}
				if(isset($options['SubmittedFromDate'])){ $params['SubmittedFromDate'] = (is_numeric($options['SubmittedFromDate']) ? date(parent::php_date_format, $options['SubmittedFromDate']) : $options['SubmittedFromDate']);  } // Converts if unixtime provided
				if(isset($options['SubmittedToDate'])){ $params['SubmittedToDate'] = (is_numeric($options['SubmittedToDate']) ? date(parent::php_date_format, $options['SubmittedToDate']) : $options['SubmittedToDate']);  } // Converts if unixtime provided
				
			} else {
				$params = false;
			}
			
			$uri = parent::createMWSUri('CancelFeedSubmissions', $this->api_endpoint, $this->api_version, $params);
			return parent::mwsCurlRetrieve($uri);
		}
		
		
		
		/***************************************************************
		*	Function GetFeedSubmissionResult
		*	
		*	Returns the feed processing report and the Content-MD5 header for the returned HTTP body.
		*	
		*	@feedSubmissionId 		(type)		The identifier of the feed submission you are requesting a feed processing report for
		*	
		*	TODO - compute MD5 of returned and compare
		*/
		public function GetFeedSubmissionResult($feedSubmissionId){
			$params = Array();
			$params['FeedSubmissionId'] = $feedSubmissionId;
			
			$uri = parent::createMWSUri('GetFeedSubmissionResult', $this->api_endpoint, $this->api_version, $params);
			return parent::mwsCurlRetrieve($uri);
		}		
		
		
	}

?>