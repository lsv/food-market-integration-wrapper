[<](../../README.md) Sinqro Food Market wrapper
--------------------------

### Get a single market selling point

Get a market selling point, from a ID

##### Usage

```php
use Lsv\FoodMarketIntegration\Request\GetMarketSellingPoint;

$marketCode = 'Market code identifier';
$sellingPointId = <ID of selling point>;

$request = new GetMarketSellingPoint($marketCode, $sellingPointId);
$response = $request->request();
```

##### Optional parameters

None

##### Response

[The selling point](../response/SellingPoint.md)
