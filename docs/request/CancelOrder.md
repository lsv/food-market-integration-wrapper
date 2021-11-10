[<](../../README.md) Sinqro Food Market wrapper
--------------------------

### Cancel order request

Cancel a order

##### Usage

```php
use Lsv\FoodMarketIntegration\Request\CancelOrder;

$marketCode = 'Market code identifier';
$marketOrderId = 'Market order identifier';
$comment = 'Cancellation comment';

$request = new CancelOrder($marketCode, $marketOrderId, $comment);
$response = $request->request();
```

##### Optional parameters

None

##### Response

[The cancelled order](../response/Order.md)
