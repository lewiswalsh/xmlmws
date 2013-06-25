# XMLMWS

A set of classes to work with Amazons MWS service using PHP and XML. I built this for my own needs as I was unhappy with what was already out there.

**This is very much in alpha at the moment though is considered working**

## Usage

1. Include/require the class files, or use (or generate) the optional PHAR file.
2. Update the config file `inc.xmlmws.config.php` and ensure your application includes it.
3. Instantiate an object of the class referring the part of the API you wish to use.
4. Use your object to call the function needed, passing in any XML or parameters

A good test to make sure all is working is to try the GetServiceStatus() function:

```php
require_once('inc.xmlmws.config.php');
require_once('xmlmws.phar.gz');

$sellers = new \XMLMWS\Sellers();
$response = $sellers->GetServiceStatus();
```

Another example: To use the ListOrders function of the Orders API endpoint do the following:

```php
require_once('inc.xmlmws.config.php');
require_once('xmlmws.phar.gz');

$orders = new \XMLMWS\Orders();

$marketPlaceId = '12345678910';
$options = Array()
$options['OrderStatus'] = 'new';
$options['BuyerEmail'] = 'person@example.com';
$response = $orders->ListOrders($marketPlaceId, $options);
```

## Please note

Required parameters are always seperate arguments, optional parameters take the form of an associative array.

For more information on functions, parameters etc please view the source for the class you wish to use and consult Amazon's own documentation.

## API endpoint versions

Periodically Amazon updates their API endpoint URIs and version numbers. These can be updated in each class:

```php
class Sellers extends AmazonMWS {

	private $api_endpoint = '/Sellers/2011-07-01';
	private $api_version = '2011-07-01';

	...
```	

### ToDo

1. Add option to return SimpleXML object or DocDocument object rather than just raw XML
2. Add error reporting
3. Maybe add XML payload building
4. ...