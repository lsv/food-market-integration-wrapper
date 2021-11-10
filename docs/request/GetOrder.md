[<](../../README.md) Sinqro Food Market wrapper
--------------------------

### Get order request

Get an order with the ID

##### Usage

```php
use Lsv\FoodMarketIntegration\Request\GetOrder;

$marketCode = 'Market code identifier';
$marketOrderId = 'Market order identifier';

$request = new GetOrder();
$response = $request->request();
```

##### Optional parameters

None

##### Response

[The order](../response/Order.md)
