[<](../../README.md) Sinqro Food Market wrapper
--------------------------

### Get market selling points

Get all market selling points

##### Usage

```php
use Lsv\FoodMarketIntegration\Request\GetMarketSellingPoints;

$marketCode = 'Market code identifier';

$request = new GetMarketSellingPoints($marketCode);
$response = $request->request();
```

##### Optional parameters

###### Request tags

```php
use Lsv\FoodMarketIntegration\Model\RequestTags;
$requestTags = new RequestTags();
$requestTags->addTag('code', 'value');

$request->setRequestTags($requestTags);
```

##### Response

array of [selling points](../response/SellingPoint.md)
