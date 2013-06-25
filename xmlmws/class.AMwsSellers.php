<?php

	namespace XMLMWS;

	class Sellers extends AmazonMWS {
	
		private $api_endpoint = '/Sellers/2011-07-01';
		private $api_version = '2011-07-01';
		
		
		/***************************************************************
		*	Function ListMarketplaceParticipations
		*	
		*	Returns a list of marketplaces that the seller submitting the request can sell in, and a list of participations that include seller-specific information in that marketplace.
		*		
		*/
		public function ListMarketplaceParticipations(){
			$uri = parent::createMWSUri('ListMarketplaceParticipations', $this->api_endpoint, $this->api_version);
			return parent::mwsCurlRetrieve($uri);
		}
		
		
		
		/***************************************************************
		*	Function ListMarketplaceParticipationsByNextToken
		*	
		*	As ListMarketplaceParticipations() but for next page of existing results. NextToken is required
		*	
		*	@nextToken 		(string)		NextToken from ListMarketplaceParticipations()
		*		
		*/
		public function ListMarketplaceParticipationsByNextToken($nextToken){
			$params = Array();
			$params['NextToken'] = $nextToken;
			$uri = parent::createMWSUri('ListMarketplaceParticipationsByNextToken', $this->api_endpoint, $this->api_version, $params);
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