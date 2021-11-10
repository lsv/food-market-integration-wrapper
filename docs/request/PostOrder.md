[<](../../README.md) Sinqro Food Market wrapper
--------------------------

### Post order request

With this you can create a new order.

##### Usage

You can create a delivery or a reservation order

###### Delivery order

```php
use Lsv\FoodMarketIntegration\Model\DeliveryOrder;

$order = new DeliveryOrder();
$order->comment = 'Comment';
# ... many more needs to be set
```

See [DeliveryOrder](../../src/Model/DeliveryOrder.php) for all the things that is needed

###### Reservation order

```php
use Lsv\FoodMarketIntegration\Model\ReservationOrder;

$order = new ReservationOrder();
$order->comment = 'Comment';
# ... many more needs to be set
```

See [ReservationOrder](../../src/Model/ReservationOrder.php) for all the things that is needed

###### Create the order

```php
use Lsv\FoodMarketIntegration\Request\PostOrder;

$marketCode = 'Market code identifier';
$order = <see above>

$request = new PostOrder($marketCode, $order);
$response = $request->request();
```

##### Optional parameters

None

##### Response

[The created order](../response/Order.md)
