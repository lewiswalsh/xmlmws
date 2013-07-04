<?php

	namespace XMLMWS;

	class Recommendations extends AmazonMWS {
	
		private $api_endpoint = '/Recommendations/2013-04-01';
		private $api_version = '2013-04-01';
		
		
		/***************************************************************
		*	Function GetLastUpdatedTimeForRecommendations
		*	
		*	Checks whether there are active recommendations for each category for the given marketplace, and if 
		*	there are, returns the time when recommendations were last updated for each category.
		*		
		*	@marketPlaceId		(string)	Specifies the marketplace from which products are returned. (required)
		*
		*/
		public function GetLastUpdatedTimeForRecommendations($marketPlaceId){
			$params = Array();
			$params['MarketPlaceId'] = $marketPlaceId;
			
			$uri = parent::createMWSUri('GetLastUpdatedTimeForRecommendations', $this->api_endpoint, $this->api_version, $params);
			return parent::mwsCurlRetrieve($uri);
		}
		
		
		
		/***************************************************************
		*	Function ListRecommendations
		*	
		*	Returns your active recommendations for a specific category or for all categories for a specific marketplace
		*	
		*	@marketPlaceId				(string)	Specifies the marketplace from which products are returned. (required)
		*	@recommendationCategory		(string)	Specifies a category for the recommendations to retrieve.
		*	@categoryQueryList			(array)		Indexed array of category-specific filters that you can specify to narrow down the types of recommendations returned for each category.
		*		
		*/
		public function ListRecommendations($marketPlaceId, $recommendationCategory, $options=false){
			$params = Array();
			$params['MarketPlaceId'] = $marketPlaceId;
			$params['RecommendationCategory'] = $recommendationCategory;
			if(isset($options['CategoryQueryList'])){ 
				foreach($options['CategoryQueryList'] as $index => $cq){
					$params['CategoryQueryList.CategoryQuery.'.($index+1)] = $cq;
				}
			}
			
			$uri = parent::createMWSUri('ListRecommendations', $this->api_endpoint, $this->api_version, $params);
			return parent::mwsCurlRetrieve($uri);
		}
		
		
		
		/***************************************************************
		*	Function ListRecommendationsByNextToken
		*	
		*	As ListRecommendations() but for next page of existing results. NextToken is required
		*	
		*	@nextToken 		(string)		NextToken from ListRecommendations()
		*		
		*/
		public function ListRecommendationsByNextToken($nextToken){
			$params = Array();
			$params['NextToken'] = $nextToken;
			
			$uri = parent::createMWSUri('ListRecommendationsByNextToken', $this->api_endpoint, $this->api_version, $params);
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