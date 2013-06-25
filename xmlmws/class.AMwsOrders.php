<?php

	namespace XMLMWS;

	class Orders extends AmazonMWS {
	
		private $api_endpoint = '/Orders/2011-01-01';
		private $api_version = '2011-01-01';
		
		

		/***************************************************************
		*	Function ListOrders
		*	
		*	As ListOrders() but for next page of existing results. NextToken is required
		*	
		*	@marketPlaceId		(array)				A structured list of MarketplaceId values.
		*		
		*	@options['CreatedAfter']		(Date string)		Date used for selecting orders created after (or at) a specified time. Required if LastUpdatedAfter is not set.
		*	@options['CreatedBefore']		(Date string)		Date used for selecting orders created before a specified time. Use only if CreatedAfter is set
		*	@options['LastUpdatedAfter']	(Date string)		Date used for selecting orders updated after (or at) a specified time. Required if CreatedAfter is not set.
		*	@options['LastUpdatedBefore']	(Date string)		Date used for selecting orders updated after (or at) a specified time.  Use only if LastUpdatedAfter is set
		*	@options['OrderStatus']			(array)				Indexed array of status values (list here from PDF)
		*	@options['FulfillmentChannel']	(array)				Indexed array that indicates how an order was fulfilled.
		*	@options['PaymentMethod']		(array)				Indexed array of PaymentMethod values. Used to select orders paid for with the payment methods that you specify.
		*	@options['BuyerEmail']			(string)			The e-mail address of a buyer.
		*	@options['SellerOrderId']		(string)			An order identifier that is specified by the seller.	
		*	@options['MaxResultsPerPage']	(integer)			A number that indicates the maximum number of orders that can be returned per page.	1-100, defualt: 100
		*	@options['TFMShipmentStatus']	(array)				Indexed array of A structured list of No TFMShipmentStatus values. Used to select Amazon Transportation for Merchants (TFM) orders with a current status that matches one of the status values that you specify
		*
		*/
		public function ListOrders($marketPlaceId, $options=false){
			$params = Array();
			foreach($marketPlaceId as $index => $mpi){
				$params['MarketPlaceId.Id.'.$index] = $mpi;
			}
			
			if(isset($options['CreatedAfter'])){ $params['CreatedAfter'] = (is_numeric($options['CreatedAfter']) ? date(parent::php_date_format, $options['CreatedAfter']) : $options['CreatedAfter']);  } // Converts if unixtime provided
			if(isset($options['CreatedBefore'])){ $params['CreatedBefore'] = (is_numeric($options['CreatedBefore']) ? date(parent::php_date_format, $options['CreatedBefore']) : $options['CreatedBefore']);  } // Converts if unixtime provided			
		
			if(isset($options['LastUpdatedAfter'])){ $params['LastUpdatedAfter'] = (is_numeric($options['LastUpdatedAfter']) ? date(parent::php_date_format, $options['LastUpdatedAfter']) : $options['LastUpdatedAfter']);  } // Converts if unixtime provided
			if(isset($options['LastUpdatedBefore'])){ $params['LastUpdatedBefore'] = (is_numeric($options['LastUpdatedBefore']) ? date(parent::php_date_format, $options['LastUpdatedBefore']) : $options['LastUpdatedBefore']);  } // Converts if unixtime provided			

			if(isset($options['OrderStatus'])){  
				foreach($options['OrderStatus'] as $index => $os){
					$params['OrderStatus.Status.'.$index] = $os;
				}
			}
			
			if(isset($options['FulfillmentChannel'])){  
				foreach($options['FulfillmentChannel'] as $index => $fc){
					$params['FulfillmentChannel.Channel.'.$index] = $fc;
				}
			}
			
			if(isset($options['PaymentMethod'])){  
				foreach($options['PaymentMethod'] as $index => $pm){
					$params['PaymentMethod.'.$index] = $pm;
				}
			}
			
			if(isset($options['BuyerEmail'])){ $params['BuyerEmail'] = $options['BuyerEmail']; }
			if(isset($options['SellerOrderId'])){ $params['SellerOrderId'] = $options['SellerOrderId']; }
			if(isset($options['MaxResultsPerPage'])){ $params['MaxResultsPerPage'] = (int)$options['MaxResultsPerPage']; }
			
			if(isset($options['TFMShipmentStatus'])){  
				foreach($options['TFMShipmentStatus'] as $index => $ts){
					$params['TFMShipmentStatus.Status.'.$index] = $ts;
				}
			}
				
			$uri = parent::createMWSUri('ListOrders', $this->api_endpoint, $this->api_version, $params);
			return parent::mwsCurlRetrieve($uri);
		}
		
		
		
		/***************************************************************
		*	Function ListOrdersByNextToken
		*	
		*	As ListOrders() but for next page of existing results. NextToken is required
		*	
		*	@nextToken 		(string)		NextToken from ListOrders()
		*		
		*/
		public function ListOrdersByNextToken($nextToken){
			$params = Array();
			$params['NextToken'] = $nextToken;
			
			$uri = parent::createMWSUri('ListOrdersByNextToken', $this->api_endpoint, $this->api_version, $params);
			return parent::mwsCurlRetrieve($uri);
		}
		
		
		
		/***************************************************************
		*	Function GetOrder
		*	
		*	Returns orders based on the AmazonOrderId values that you specify
		*	
		*	@amazonOrderId 		(type)		A list of AmazonOrderId values. An AmazonOrderId is an Amazon-defined order identifier, in 3-7-7 format. MAX: 50 (required)
		*		
		*/
		public function GetOrder($amazonOrderId){
			$params = Array();
			foreach($amazonOrderId as $index => $id){
				$params['AmazonOrderId.Id.'.$index] = $id;
			}
			$uri = parent::createMWSUri('GetOrder', $this->api_endpoint, $this->api_version, $params);
			return parent::mwsCurlRetrieve($uri);
		}	
		
		
		
		/***************************************************************
		*	Function ListOrderItems
		*	
		*	Returns order items based on the AmazonOrderId that you specify.
		*	
		*	@amazonOrderId 		(string)		An Amazon-defined order identifier, in 3-7-7 format.
		*		
		*/
		public function ListOrderItems($amazonOrderId){
			$params = Array();
			$params['AmazonOrderId'] = $amazonOrderId;
			
			$uri = parent::createMWSUri('ListOrderItems', $this->api_endpoint, $this->api_version, $params);
			return parent::mwsCurlRetrieve($uri);
		}		
		
		
		
		/***************************************************************
		*	Function ListOrderItemsByNextToken
		*	
		*	As ListOrderItems() but for next page of existing results. NextToken is required
		*	
		*	@nextToken 		(string)		NextToken from ListOrderItems()
		*		
		*/
		public function ListOrderItemsByNextToken($nextToken){
			$params = Array();
			$params['NextToken'] = $nextToken;
			
			$uri = parent::createMWSUri('ListOrderItemsByNextToken', $this->api_endpoint, $this->api_version, $params);
			return parent::mwsCurlRetrieve($uri);
		}
	
		
		
		/***************************************************************
		*	Function GetServiceStatus
		*	
		*	As ListMarketplaceParticipations() but for next page of existing results. NextToken is required
		*		
		*/
		public function GetServiceStatus(){
			$uri = parent::createMWSUri('GetServiceStatus', $this->api_endpoint, $this->api_version);
			return parent::mwsCurlRetrieve($uri);
		}
		
	
	}

?>