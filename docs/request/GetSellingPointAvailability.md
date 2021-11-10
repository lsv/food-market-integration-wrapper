[<](../../README.md) Sinqro Food Market wrapper
--------------------------

### Get market selling point availability

Get information about selling point services

##### Usage

```php
use Lsv\FoodMarketIntegration\Request\GetSellingPointAvailability;

$marketCode = 'Market code identifier';
$sellingPointId = <ID of selling point>;

$request = new GetSellingPointAvailability($marketCode, $sellingPointId);
$response = $request->request();
```

##### Optional parameters

###### Date

If not added, it will be show availabiltity for the current date

```php
$date = new DateTime();
$request->setDate($date);
```

##### Response

[Selling point availability](../response/SellingPointAvailability.md)
