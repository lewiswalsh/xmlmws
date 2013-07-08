<?php

	namespace XMLMWS;

	class Products extends AmazonMWS {
	
		private $api_endpoint = 'Products/2011-10-01';
		private $api_version = '2011-10-01';
		
		
		/***************************************************************
		*	Function ListMatchingProducts
		*	
		*	Returns a list of marketplaces that the seller submitting the request can sell in, and a list of participations that include seller-specific information in that marketplace.
		*		
		*	@marketPlaceId		(string)	Specifies the marketplace from which products are returned. (required)
		*	@query				(string)	A search string with the same support as that provided on Amazon marketplace websites. eg. Query=harry potter dvd  (required)
		*
		*	@options['QueryContextId']		(string)	An identifier for the context within which the given search will be performed.
		*		
		*/
		public function ListMatchingProducts($marketPlaceId, $query, $options=false){
			$params = Array();
			$params['MarketplaceId'] = $marketPlaceId;
			$params['Query'] = $query;
			
			if(isset($options['QueryContextId'])){ $params['QueryContextId'] = $options['QueryContextId']; }
			
			$uri = parent::createMWSUri('ListMatchingProducts', $this->api_endpoint, $this->api_version, $params);
			return parent::mwsCurlRetrieve($uri);
		}
		
		
		
		/***************************************************************
		*	Function GetMatchingProduct
		*	
		*	Returns a list of products and their attributes, based on a list of ASIN values.
		*		
		*	@marketPlaceId		(string)	Specifies the marketplace from which products are returned. (required)
		*	@asinList			(array)		Indexed array of ASIN numbers. MAX: 10 (required)
		*		
		*/
		public function GetMatchingProduct($marketPlaceId, $asinList){
			$params = Array();
			$params['MarketplaceId'] = $marketPlaceId;
			foreach($asinList as $index => $al){
				$params['ASINList.'.($index+1)] = $al;
			}
			
			$uri = parent::createMWSUri('GetMatchingProduct', $this->api_endpoint, $this->api_version, $params);
			return parent::mwsCurlRetrieve($uri);
		}
		
		
		
		/***************************************************************
		*	Function GetMatchingProductForId
		*	
		*	Returns a list of products and their attributes, based on a list of ASIN values.
		*		
		*	@marketPlaceId		(string)	Returns a list of products and their attributes, based on a list of ASIN, GCID, SellerSKU, UPC, EAN, ISBN, and JAN values. (required)
		*	@IdType				(string)	The type of product identifier that Id values refer to. Valid values are ASIN, GCID, SellerSKU, UPC, EAN, ISBN, and JAN. (required)
		*	@IdList				(array)		Indexed array of Id values. MAX: 5 (required)
		*		
		*/
		public function GetMatchingProductForId($marketPlaceId, $idType, $idList){
			$params = Array();
			$params['MarketplaceId'] = $marketPlaceId;
			$params['IdType'] = $idType;
			foreach($idList as $index => $id){
				$params['IdList.Id.'.($index+1)] = $id;
			}
			
			$uri = parent::createMWSUri('GetMatchingProductForId', $this->api_endpoint, $this->api_version, $params);
			return parent::mwsCurlRetrieve($uri);
		}
		
		
		
		/***************************************************************
		*	Function GetCompetitivePricingForSKU
		*	
		*	Returns the current competitive price of a product, based on SellerSKU.
		*		
		*	@marketPlaceId		(string)	Returns a list of products and their attributes, based on a list of ASIN, GCID, SellerSKU, UPC, EAN, ISBN, and JAN values. (required)
		*	@sellerSKUList		(array)		Indexed array of SKU values. MAX: 20 (required)
		*		
		*/
		public function GetCompetitivePricingForSKU($marketPlaceId, $sellerSKUList){
			$params = Array();
			$params['MarketplaceId'] = $marketPlaceId;
			foreach($sellerSKUList as $index => $sku){
				$params['SellerSKUList.SellerSKU.'.($index+1)] = $sku;
			}
			
			$uri = parent::createMWSUri('GetCompetitivePricingForSKU', $this->api_endpoint, $this->api_version, $params);
			return parent::mwsCurlRetrieve($uri);
		}
		
		
		
		/***************************************************************
		*	Function GetCompetitivePricingForASIN
		*	
		*	Returns the current competitive price of a product, based on ASIN
		*		
		*	@marketPlaceId		(string)	Returns a list of products and their attributes, based on a list of ASIN, GCID, SellerSKU, UPC, EAN, ISBN, and JAN values. (required)
		*	@asinList			(array)		Indexed array of ASIN numbers. MAX: 20 (required)
		*		
		*/
		public function GetCompetitivePricingForASIN($marketPlaceId, $asinList){
			$params = Array();
			$params['MarketplaceId'] = $marketPlaceId;
			foreach($asinList as $index => $al){
				$params['ASINList.ASIN.'.($index+1)] = $al;
			}
			
			$uri = parent::createMWSUri('GetCompetitivePricingForASIN', $this->api_endpoint, $this->api_version, $params);
			return parent::mwsCurlRetrieve($uri);
		}
		
		
		
		/***************************************************************
		*	Function GetLowestOfferListingsForSKU
		*	
		*	Returns pricing information for the lowest-price active offer listings for a product, based on SellerSKU
		*		
		*	@marketPlaceId		(string)	Returns a list of products and their attributes, based on a list of ASIN, GCID, SellerSKU, UPC, EAN, ISBN, and JAN values. (required)
		*	@sellerSKUList		(array)		Indexed array of SKU values. MAX: 20 (required)
		*
		*	@options['ItemCondition']		(string)	Filters the offer listings to be considered based on item condition. Valid values: Any, New, Used, Collectible, Refurbished, and Club. Default: any
		*	@options['ExcludeMe']			(string)	Excludes your own offer listings from the offer listings that are returned. Values: True, False. Default: False
		*		
		*/
		public function GetLowestOfferListingsForSKU($marketPlaceId, $sellerSKUList, $options=false){
			$params = Array();
			$params['MarketplaceId'] = $marketPlaceId;
			foreach($sellerSKUList as $index => $sku){
				$params['SellerSKUList.SellerSKU.'.($index+1)] = $sku;
			}
			if(isset($options['ItemCondition'])){ $params['ItemCondition'] = $options['ItemCondition']; }
			if(isset($options['ExcludeMe'])){ $params['ExcludeMe'] = $options['ExcludeMe']; }
			
			$uri = parent::createMWSUri('GetLowestOfferListingsForSKU', $this->api_endpoint, $this->api_version, $params);
			return parent::mwsCurlRetrieve($uri);
		}
		
		
		
		/***************************************************************
		*	Function GetLowestOfferListingsForASIN
		*	
		*	Returns pricing information for the lowest-price active offer listings for a product, based on ASIN.
		*		
		*	@marketPlaceId		(string)	Returns a list of products and their attributes, based on a list of ASIN, GCID, SellerSKU, UPC, EAN, ISBN, and JAN values. (required)
		*	@asinList			(array)		Indexed array of ASIN numbers. MAX: 20 (required)
		*
		*	@options['ItemCondition']	(string)	Filters the offer listings to be considered based on item condition. Valid values: Any, New, Used, Collectible, Refurbished, and Club. Default: any
		*		
		*/
		public function GetLowestOfferListingsForASIN($marketPlaceId, $asinList, $options=false){
			$params = Array();
			$params['MarketplaceId'] = $marketPlaceId;
			foreach($asinList as $index => $al){
				$params['ASINList.ASIN.'.($index+1)] = $al;
			}
			if(isset($options['ItemCondition'])){ $params['ItemCondition'] = $options['ItemCondition']; }
			
			$uri = parent::createMWSUri('GetLowestOfferListingsForASIN', $this->api_endpoint, $this->api_version, $params);
			return parent::mwsCurlRetrieve($uri);
		}
		
		
		
		/***************************************************************
		*	Function GetMyPriceForSKU
		*	
		*	Returns pricing information for your own offer listings, based on SellerSKU.
		*		
		*	@marketPlaceId		(string)	Returns a list of products and their attributes, based on a list of ASIN, GCID, SellerSKU, UPC, EAN, ISBN, and JAN values. (required)
		*	@sellerSKUList		(array)		Indexed array of SKU values. MAX: 20 (required)
		*
		*	@options['ItemCondition']	(string)	Filters the offer listings to be considered based on item condition. Valid values: Any, New, Used, Collectible, Refurbished, and Club. Default: any
		*		
		*/
		public function GetMyPriceForSKU($marketPlaceId, $sellerSKUList, $options=false){
			$params = Array();
			$params['MarketplaceId'] = $marketPlaceId;
			foreach($sellerSKUList as $index => $sku){
				$params['SellerSKUList.SellerSKU.'.($index+1)] = $sku;
			}
			if(isset($options['ItemCondition'])){ $params['ItemCondition'] = $options['ItemCondition']; }
			
			$uri = parent::createMWSUri('GetMyPriceForSKU', $this->api_endpoint, $this->api_version, $params);
			return parent::mwsCurlRetrieve($uri);
		}
		
		
		
		/***************************************************************
		*	Function GetMyPriceForASIN
		*	
		*	Returns pricing information for your own offer listings, based on SellerSKU.
		*		
		*	@marketPlaceId		(string)	Returns a list of products and their attributes, based on a list of ASIN, GCID, SellerSKU, UPC, EAN, ISBN, and JAN values. (required)
		*	@asinList			(array)		Indexed array of ASIN numbers. MAX: 20 (required)
		*
		*	@options['ItemCondition']	(string)	Filters the offer listings to be considered based on item condition. Valid values: Any, New, Used, Collectible, Refurbished, and Club. Default: any
		*		
		*/
		public function GetMyPriceForASIN($marketPlaceId, $asinList, $options=false){
			$params = Array();
			$params['MarketplaceId'] = $marketPlaceId;
			foreach($asinList as $index => $al){
				$params['ASINList.ASIN.'.($index+1)] = $al;
			}
			if(isset($options['ItemCondition'])){ $params['ItemCondition'] = $options['ItemCondition']; }
			
			$uri = parent::createMWSUri('GetMyPriceForASIN', $this->api_endpoint, $this->api_version, $params);
			return parent::mwsCurlRetrieve($uri);
		}
		
		
		
		/***************************************************************
		*	Function GetProductCategoriesForSKU
		*	
		*	Returns the parent product categories that a product belongs to, based on SellerSKU.
		*		
		*	@marketPlaceId		(string)	Returns a list of products and their attributes, based on a list of ASIN, GCID, SellerSKU, UPC, EAN, ISBN, and JAN values. (required)
		*	@sellerSKU			(string)	Used to identify products in the given marketplace. (required)
		*		
		*/
		public function GetProductCategoriesForSKU($marketPlaceId, $sellerSKU){
			$params = Array();
			$params['MarketplaceId'] = $marketPlaceId;
			$params['SellerSKU'] = $sellerSKU;
			
			$uri = parent::createMWSUri('GetProductCategoriesForSKU', $this->api_endpoint, $this->api_version, $params);
			return parent::mwsCurlRetrieve($uri);
		}
		
		
		
		/***************************************************************
		*	Function GetProductCategoriesForASIN
		*	
		*	Returns the parent product categories that a product belongs to, based on SellerSKU.
		*	
		*	@marketPlaceId		(string)	Returns a list of products and their attributes, based on a list of ASIN, GCID, SellerSKU, UPC, EAN, ISBN, and JAN values. (required)
		*	@asin				(string)	Identifies the product in given the Marketplace. (required)
		*	
		*/
		public function GetProductCategoriesForASIN($marketPlaceId, $asin){
			$params = Array();
			$params['MarketplaceId'] = $marketPlaceId;
			$params['ASIN'] = $asin;
			
			$uri = parent::createMWSUri('GetProductCategoriesForASIN', $this->api_endpoint, $this->api_version, $params);
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