<?php

	namespace XMLMWS;

	class Reports extends AmazonMWS {
	
		private $api_endpoint = '/';
		private $api_version = '2009-01-01';
		

		/***************************************************************
		*	Function RequestReport
		*	
		*	Creates a report request and submits the request to Amazon MWS.
		*	
		*	@reportType 		(string)		A value of the ReportType enumeration that indicates the type of report to request.
		*	
		*	@options['StartDate'] 				(date string)	The start of a date range used for selecting the data to report.
		*	@options['EndDate'] 				(date string)	The end of a date range used for selecting the data to report.
		*	@options['ReportOptions'] 			(string)		Additional information to pass to the report.
		*	@options['MarketplaceIdList'] 		(array)			Indexed array of one or more marketplace IDs for the marketplaces you are registered to sell in.
		*		
		*/
		public function RequestReport($reportType, $options=false){
			$params = Array();
			$params['ReportType'] = $reportType;
			
			if(isset($options['StartDate'])){ $params['StartDate'] = (is_numeric($options['StartDate']) ? date(parent::php_date_format, $options['StartDate']) : $options['StartDate']);  } // Converts if unixtime provided
			if(isset($options['EndDate'])){ $params['EndDate'] = (is_numeric($options['EndDate']) ? date(parent::php_date_format, $options['EndDate']) : $options['EndDate']);  } // Converts if unixtime provided			
			if(isset($options['ReportOptions'])){ $params['ReportOptions'] = $options['ReportOptions']; }
			
			if(isset($options['MarketplaceIdList'])){ 
				foreach($options['MarketplaceIdList'] as $index => $mpi){
					$params['MarketplaceIdList.Id.'.$index] = $mpi;
				}
			}
			
			$uri = parent::createMWSUri('RequestReport', $this->api_endpoint, $this->api_version, $params);
			return parent::mwsCurlRetrieve($uri);
		}
		
		
		
		/***************************************************************
		*	Function GetReportRequestList
		*	
		*	Returns a list of report requests that you can use to get the ReportRequestId for a report.
		*	
		*	@options['ReportRequestIdList'] 		(array)			Indexed array of ReportRequestId values. If you pass in ReportRequestId values, other query conditions are ignored.
		*	@options['ReportTypeList'] 				(array)			Indexed array of ReportType enumeration values.
		*	@options['ReportProcessingStatusList'] 	(array)			Indexed array of report processing statuses by which to filter report requests.
		*	@options['MaxCount'] 					(number)		A non-negative integer that represents the maximum number of report requests to return. 1-100, default 10
		*	@options['RequestedFromDate'] 			(date string)	The start of the date range used for selecting the data to report
		*	@options['RequestedToDate'] 			(date string)	The end of the date range used for selecting the data to report
		*		
		*/
		public function GetReportRequestList($options=false){
			if($options){
				$params = Array();

				if(isset($options['ReportRequestIdList'])){ 
					foreach($options['ReportRequestIdList'] as $index => $rri){
						$params['ReportRequestIdList.Id.'.$index] = $rri;
					}
				}
				
				if(isset($options['ReportTypeList'])){ 
					foreach($options['ReportTypeList'] as $index => $rt){
						$params['ReportTypeList.Type.'.$index] = $rt;
					}
				}
				
				if(isset($options['ReportProcessingStatusList'])){ 
					foreach($options['ReportProcessingStatusList'] as $index => $rps){
						$params['ReportProcessingStatusList.Status.'.$index] = $rps;
					}
				}
				
				if(isset($options['MaxCount'])){ $params['MaxCount'] = $options['MaxCount']; }
				if(isset($options['RequestedFromDate'])){ $params['RequestedFromDate'] = (is_numeric($options['RequestedFromDate']) ? date(parent::php_date_format, $options['RequestedFromDate']) : $options['RequestedFromDate']);  } // Converts if unixtime provided
				if(isset($options['RequestedToDate'])){ $params['RequestedToDate'] = (is_numeric($options['RequestedToDate']) ? date(parent::php_date_format, $options['RequestedToDate']) : $options['RequestedToDate']);  } // Converts if unixtime provided			
				
			} else {
				$params = false;
			}
			
			$uri = parent::createMWSUri('GetReportRequestList', $this->api_endpoint, $this->api_version, $params);
			return parent::mwsCurlRetrieve($uri);
		}
		
		
		
		/***************************************************************
		*	Function GetReportRequestListByNextToken
		*	
		*	As GetReportRequestList() but for next page of existing results. NextToken is required
		*	
		*	@nextToken 		(string)		NextToken from GetReportRequestList()
		*		
		*/
		public function GetReportRequestListByNextToken($nextToken){
			$params = Array();
			$params['NextToken'] = $nextToken;
			
			$uri = parent::createMWSUri('GetReportRequestListByNextToken', $this->api_endpoint, $this->api_version, $params);
			return parent::mwsCurlRetrieve($uri);
		}
		
		
		
		/***************************************************************
		*	Function GetReportRequestCount
		*	
		*	Returns a count of report requests that have been submitted to Amazon MWS for processing
		*	
		*	@options['ReportTypeList'] 				(array)			Indexed array of ReportType enumeration values.
		*	@options['ReportProcessingStatusList'] 	(array)			Indexed array of report processing statuses by which to filter report requests.
		*	@options['RequestedFromDate'] 			(date string)	The start of the date range used for selecting the data to report
		*	@options['RequestedToDate'] 			(date string)	The end of the date range used for selecting the data to report
		*		
		*/
		public function GetReportRequestCount($options=false){
			if($options){
				$params = Array();

				if(isset($options['ReportTypeList'])){ 
					foreach($options['ReportTypeList'] as $index => $rt){
						$params['ReportTypeList.Type.'.$index] = $rt;
					}
				}
				
				if(isset($options['ReportProcessingStatusList'])){ 
					foreach($options['ReportProcessingStatusList'] as $index => $rps){
						$params['ReportProcessingStatusList.Status.'.$index] = $rps;
					}
				}
				
				if(isset($options['RequestedFromDate'])){ $params['RequestedFromDate'] = (is_numeric($options['RequestedFromDate']) ? date(parent::php_date_format, $options['RequestedFromDate']) : $options['RequestedFromDate']);  } // Converts if unixtime provided
				if(isset($options['RequestedToDate'])){ $params['RequestedToDate'] = (is_numeric($options['RequestedToDate']) ? date(parent::php_date_format, $options['RequestedToDate']) : $options['RequestedToDate']);  } // Converts if unixtime provided			
				
			} else {
				$params = false;
			}
			
			$uri = parent::createMWSUri('GetReportRequestCount', $this->api_endpoint, $this->api_version, $params);
			return parent::mwsCurlRetrieve($uri);
		}
		
		
		
		/***************************************************************
		*	Function CancelReportRequests
		*	
		*	Cancels one or more report requests
		*	
		*	@options['ReportRequestIdList'] 		(array)			Indexed array of ReportRequestId values. If you pass in ReportRequestId values, other query conditions are ignored.
		*	@options['ReportTypeList'] 				(array)			Indexed array of ReportType enumeration values.
		*	@options['ReportProcessingStatusList'] 	(array)			Indexed array of report processing statuses by which to filter report requests.
		*	@options['RequestedFromDate'] 			(date string)	The start of the date range used for selecting the data to report
		*	@options['RequestedToDate'] 			(date string)	The end of the date range used for selecting the data to report
		*		
		*/
		public function CancelReportRequests($options=false){
			if($options){
				$params = Array();
				
				
				if(isset($options['ReportRequestIdList'])){ 
					foreach($options['ReportRequestIdList'] as $index => $rri){
						$params['ReportRequestIdList.Id.'.$index] = $rri;
					}
				}

				if(isset($options['ReportTypeList'])){ 
					foreach($options['ReportTypeList'] as $index => $rt){
						$params['ReportTypeList.Type.'.$index] = $rt;
					}
				}
				
				if(isset($options['ReportProcessingStatusList'])){ 
					foreach($options['ReportProcessingStatusList'] as $index => $rps){
						$params['ReportProcessingStatusList.Status.'.$index] = $rps;
					}
				}
				
				if(isset($options['RequestedFromDate'])){ $params['RequestedFromDate'] = (is_numeric($options['RequestedFromDate']) ? date(parent::php_date_format, $options['RequestedFromDate']) : $options['RequestedFromDate']);  } // Converts if unixtime provided
				if(isset($options['RequestedToDate'])){ $params['RequestedToDate'] = (is_numeric($options['RequestedToDate']) ? date(parent::php_date_format, $options['RequestedToDate']) : $options['RequestedToDate']);  } // Converts if unixtime provided			
				
			} else {
				$params = false;
			}
			
			$uri = parent::createMWSUri('CancelReportRequests', $this->api_endpoint, $this->api_version, $params);
			return parent::mwsCurlRetrieve($uri);
		}
		
		
		
		/***************************************************************
		*	Function GetReportList
		*	
		*	Returns a list of reports that were created in the previous 90 days.
		*	
		*	@options['MaxCount'] 					(number)		A non-negative integer that represents the maximum number of report requests to return. 1-100, default 10
		*	@options['ReportTypeList'] 				(array)			Indexed array of ReportType enumeration values.
		*	@options['Acknowledged'] 				(bool)			A Boolean value that indicates if an order report has been acknowledged by a prior call to UpdateReportAcknowledgements
		*	@options['AvailableFromDate'] 			(date string)	The start of the date range used for selecting the data to report
		*	@options['AvailableToDate'] 			(date string)	The end of the date range used for selecting the data to report
		*	@options['ReportRequestIdList'] 		(array)			Indexed array of ReportRequestId values. If you pass in ReportRequestId values, other query conditions are ignored.
		*		
		*/
		public function GetReportList($options=false){
			if($options){
				$params = Array();
				if(isset($options['MaxCount'])){ $params['MaxCount'] = $options['MaxCount']; }
				
				if(isset($options['ReportTypeList'])){ 
					foreach($options['ReportTypeList'] as $index => $rt){
						$params['ReportTypeList.Type.'.$index] = $rt;
					}
				}
				
				if(isset($options['Acknowledged'])){ $params['Acknowledged'] = $options['Acknowledged']; }
				
				if(isset($options['AvailableFromDate'])){ $params['AvailableFromDate'] = (is_numeric($options['AvailableFromDate']) ? date(parent::php_date_format, $options['AvailableFromDate']) : $options['AvailableFromDate']);  } // Converts if unixtime provided
				if(isset($options['AvailableToDate'])){ $params['AvailableToDate'] = (is_numeric($options['AvailableToDate']) ? date(parent::php_date_format, $options['AvailableToDate']) : $options['AvailableToDate']);  } // Converts if unixtime provided			
				
				if(isset($options['ReportRequestIdList'])){ 
					foreach($options['ReportRequestIdList'] as $index => $rri){
						$params['ReportRequestIdList.Id.'.$index] = $rri;
					}
				}
				
			} else {
				$params = false;
			}
			
			$uri = parent::createMWSUri('GetReportList', $this->api_endpoint, $this->api_version, $params);
			return parent::mwsCurlRetrieve($uri);
		}
		
		
		
		/***************************************************************
		*	Function GetReportListByNextToken
		*	
		*	As GetReportList() but for next page of existing results. NextToken is required
		*	
		*	@nextToken 		(string)		NextToken from GetReportList()
		*		
		*/
		public function GetReportListByNextToken($nextToken){
			$params = Array();
			$params['NextToken'] = $nextToken;
			
			$uri = parent::createMWSUri('GetReportListByNextToken', $this->api_endpoint, $this->api_version, $params);
			return parent::mwsCurlRetrieve($uri);
		}
		
		
		
		/***************************************************************
		*	Function GetReportCount
		*	
		*	Returns a list of reports that were created in the previous 90 days.
		*	
		*	@options['ReportTypeList'] 				(array)			Indexed array of ReportType enumeration values.
		*	@options['Acknowledged'] 				(bool)			A Boolean value that indicates if an order report has been acknowledged by a prior call to UpdateReportAcknowledgements
		*	@options['AvailableFromDate'] 			(date string)	The start of the date range used for selecting the data to report
		*	@options['AvailableToDate'] 			(date string)	The end of the date range used for selecting the data to report
		*		
		*/
		public function GetReportCount($options=false){
			if($options){
				$params = Array();
				
				if(isset($options['ReportTypeList'])){ 
					foreach($options['ReportTypeList'] as $index => $rt){
						$params['ReportTypeList.Type.'.$index] = $rt;
					}
				}
				
				if(isset($options['Acknowledged'])){ $params['Acknowledged'] = $options['Acknowledged']; }
				
				if(isset($options['AvailableFromDate'])){ $params['AvailableFromDate'] = (is_numeric($options['AvailableFromDate']) ? date(parent::php_date_format, $options['AvailableFromDate']) : $options['AvailableFromDate']);  } // Converts if unixtime provided
				if(isset($options['AvailableToDate'])){ $params['AvailableToDate'] = (is_numeric($options['AvailableToDate']) ? date(parent::php_date_format, $options['AvailableToDate']) : $options['AvailableToDate']);  } // Converts if unixtime provided			
								
			} else {
				$params = false;
			}
			
			$uri = parent::createMWSUri('GetReportCount', $this->api_endpoint, $this->api_version, $params);
			return parent::mwsCurlRetrieve($uri);
		}
		
		
		
		/***************************************************************
		*	Function GetReport
		*	
		*	Returns the contents of a report and the Content-MD5 header for the returned report body
		*	
		*	@reportId 		(string)		A unique identifier of the report to download
		*	
		*	TODO - compute MD5 of returned and compare		
		*/
		public function GetReport($reportId){
			$params = Array();
			$params['ReportId'] = $reportId;
			
			$uri = parent::createMWSUri('GetReport', $this->api_endpoint, $this->api_version, $params);
			return parent::mwsCurlRetrieve($uri);
		}
		
		
		
		/***************************************************************
		*	Function ManageReportSchedule
		*	
		*	Creates, updates, or deletes a report request schedule for a specified report type.
		*	
		*	@reportType 		(string)		A value of the ReportType enumeration that indicates the type of report to request (required)
		*	@schedule 			(string)		A value of the Schedule enumeration that indicates how often a report request should be created (required)
		*
		*	@options['ScheduleDate'] 	(date string)	The date when the next report request is scheduled to be submitted.
		*	
		*/
		public function ManageReportSchedule($reportType, $schedule, $options=false){
			$params = Array();
			$params['ReportType'] = $reportType;
			$params['Schedule'] = $schedule;
			if(isset($options['ScheduleDate'])){ $params['ScheduleDate'] = (is_numeric($options['ScheduleDate']) ? date(parent::php_date_format, $options['ScheduleDate']) : $options['ScheduleDate']);  } // Converts if unixtime provided
			
			$uri = parent::createMWSUri('ManageReportSchedule', $this->api_endpoint, $this->api_version, $params);
			return parent::mwsCurlRetrieve($uri);
		}
		
		
		
		/***************************************************************
		*	Function GetReportScheduleList
		*	
		*	Returns a list of order report requests that are scheduled to be submitted to Amazon MWS for processing.
		*
		*	@options['ReportTypeList'] 				(array)			Indexed array of ReportType enumeration values.
		*	
		*/
		public function GetReportScheduleList($options=false){
			if($options){
				$params = Array();
				
				if(isset($options['ReportTypeList'])){ 
					foreach($options['ReportTypeList'] as $index => $rt){
						$params['ReportTypeList.Type.'.$index] = $rt;
					}
				}
			
			} else {
				$params = false;
			}
			
			$uri = parent::createMWSUri('GetReportScheduleList', $this->api_endpoint, $this->api_version, $params);
			return parent::mwsCurlRetrieve($uri);
		}
		
		
		
		/***************************************************************
		*	Function GetReportScheduleCount
		*	
		*	Returns a count of order report requests that are scheduled to be submitted to Amazon MWS.
		*
		*	@options['ReportTypeList'] 				(array)			Indexed array of ReportType enumeration values.
		*	
		*/
		public function GetReportScheduleCount($options=false){
			if($options){
				$params = Array();
				
				if(isset($options['ReportTypeList'])){ 
					foreach($options['ReportTypeList'] as $index => $rt){
						$params['ReportTypeList.Type.'.$index] = $rt;
					}
				}
			
			} else {
				$params = false;
			}
			
			$uri = parent::createMWSUri('GetReportScheduleCount', $this->api_endpoint, $this->api_version, $params);
			return parent::mwsCurlRetrieve($uri);
		}
		
		
		
		/***************************************************************
		*	Function UpdateReportAcknowledgements
		*	
		*	Updates the acknowledged status of one or more reports.
		*	
		*	@reportIdList 	(array)		A structured list of Report Ids. MAX: 100
		*
		*	@options['Acknowledged'] 	(bool)			A Boolean value that indicates if an order report has been acknowledged by a prior call to UpdateReportAcknowledgements
		*		
		*/
		public function UpdateReportAcknowledgements($reportIdList, $options=false){
			$params = Array();
			foreach($reportIdList as $index => $id){
				$params['ReportIdList.Id.'.$index] = $id;
			}
			
			if(isset($options['Acknowledged'])){ $params['Acknowledged'] = $options['Acknowledged']; }
			
			$uri = parent::createMWSUri('UpdateReportAcknowledgements', $this->api_endpoint, $this->api_version, $params);
			return parent::mwsCurlRetrieve($uri);
		}
		
		
	
	}

?>