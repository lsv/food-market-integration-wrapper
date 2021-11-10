[<](../../README.md) Sinqro Food Market wrapper
--------------------------

### Get market selling point zones and tables

Get all the restaurant zones and tables

##### Usage

```php
use Lsv\FoodMarketIntegration\Request\GetSellingPointZonesAndTables;

$marketCode = 'Market code identifier';
$sellingPointId = <ID of selling point>;

$request = new GetSellingPointZonesAndTables($marketCode, $sellingPointId);
$response = $request->request();
```

##### Optional parameters

None

##### Response

[ServiceZone](../response/ServiceZone.md)
