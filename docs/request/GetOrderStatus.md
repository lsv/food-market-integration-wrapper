[<](../../README.md) Sinqro Food Market wrapper
--------------------------

### Get order status request

With this you can get the status of an order.

***Do not use this to listen for order status changes, instead you need to setup a web socket for that, see [websocket](https://developer.sinqro.com/en-us/notifications)***

##### Usage

```php
use Lsv\FoodMarketIntegration\Request\GetOrder;

$marketCode = 'Market code identifier';
$marketOrderId = 'Market order identifier';

$request = new GetOrder($marketCode, $marketOrderId);
$response = $request->request();
```

##### Optional parameters

None

##### Response

[The order](../response/Order.md)
