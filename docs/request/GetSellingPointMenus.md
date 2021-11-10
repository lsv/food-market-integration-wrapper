[<](../../README.md) Sinqro Food Market wrapper
--------------------------

### Get market selling point menu

Get the menu of a market seller point

##### Usage

```php
use Lsv\FoodMarketIntegration\Request\GetSellingPointMenus;

$marketCode = 'Market code identifier';
$sellingPointId = <ID of selling point>;

$request = new GetSellingPointMenus($marketCode, $sellingPointId);
$response = $request->request();
```

##### Optional parameters

###### Date

If not added, it will be show availabiltity for the current date

```php
$date = new DateTime();
$request->setDate($date);
```

###### Order type

Set the order type you want to use

```php
$orderType = 'order type';
$request->setOrderType($orderType);
```

##### Response

array of [menu](../response/Menu.md)
