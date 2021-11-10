[<](../../README.md) Sinqro Food Market wrapper
--------------------------

### Get selling point closing exceptions

Get selling point next closing exceptions

##### Usage

```php
use Lsv\FoodMarketIntegration\Request\GetSellingPointClosingExceptions;

$marketCode = 'Market code identifier';
$sellingPointId = <ID of selling point>;

$request = new GetSellingPointClosingExceptions($marketCode, $sellingPointId);
$response = $request->request();
```

##### Optional parameters

None

##### Response

array of [Selling point exception](../response/SellingPointException.md)
