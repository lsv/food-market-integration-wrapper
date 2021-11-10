[<](../../README.md) Sinqro Food Market wrapper
--------------------------

### Get market selling point menu availability

Get menus with availability

##### Usage

```php
use Lsv\FoodMarketIntegration\Request\GetSellingPointMenusAvailability;

$marketCode = 'Market code identifier';
$sellingPointId = <ID of selling point>;

$request = new GetSellingPointMenusAvailability($marketCode, $sellingPointId);
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

###### Load products

If you also want the products to be loaded, you can add this

```php
$request->setLoadProducts(true);
```

##### Response

array of [menu](../response/Menu.md)
