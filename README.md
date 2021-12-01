Sinqro Food Market wrapper
--------------------------

PHP wrapper for [sinqro food market integration](https://developer.sinqro.com/en-es/cases/food_market_integration)

## Install and basic usage

Install with composer, requires PHP >8.0

```
composer require lsv/food-market-integration-wrapper
```

Authenticate usage

```php
use Lsv\FoodMarketIntegration\Authenticate;
use Lsv\FoodMarketIntegration\Request;

$userAccessToken = 'your user access token';
$serverAccessToken = 'your server access token';
$authenticate = new Authenticate($userAccessToken, $serverAccessToken);
Request\AbstractRequest::setAuthentication($authenticate);
// Your requests
```

And basic usage, to fetch an order

```php
use Lsv\FoodMarketIntegration\Request;

$marketCodeIdentifier = 'your market code identifier';
$marketOrderIdentifier = 'order id';

$request = new Request\GetOrder($marketCodeIdentifier, $marketOrderIdentifier);
$response = $request->request();
# Response is now an object of Response\Order
```

For more usages, see below.

## Usage

#### Authenticate

[Authenticate](docs/authenticate.md)

#### Order requests

| Request | Description | Response |
| --- | --- | --- |
| [CancelOrder](docs/request/CancelOrder.md) | Cancel a order | [Order](docs/response/Order.md) |
| [GetOrder](docs/request/GetOrder.md) | Get order by identifier | [Order](docs/response/Order.md) |
| [GetOrderStatus](docs/request/GetOrderStatus.md) | Get consumer order current status | [OrderStatus](docs/response/OrderStatus.md) |
| [PostOrder](docs/request/PostOrder.md) | Create new order | [Order](docs/response/Order.md) |

#### Selling point requests

| Request | Description | Response |
| --- | --- | --- |
| [GetMarketSellingPoint](docs/request/GetMarketSellingPoint.md) | Get market selling point by id | [SellingPoint](docs/response/SellingPoint.md) |
| [GetMarketSellingPoints](docs/request/GetMarketSellingPoints.md) | Get all market selling points | array of [SellingPoint](docs/response/SellingPoint.md) |
| [GetSellingPointAvailability](docs/request/GetSellingPointAvailability.md) | Return information about selling point services | [SellingPointAvailability](docs/response/SellingPointAvailability.md) |
| [GetSellingPointClosingExceptions](docs/request/GetSellingPointClosingExceptions.md) | Get selling point next closing exceptions | array of [SellingPointException](docs/response/SellingPointException.md) |
| [GetSellingPointMenus](docs/request/GetSellingPointMenus.md) | Get menus | array of [Menu](docs/response/Menu.md) |
| [GetSellingPointMenusAvailability](docs/request/GetSellingPointMenusAvailability.md) | Get menus with availability | array of [Menu](docs/response/Menu.md) |
| [GetSellingPointZonesAndTables](docs/request/GetSellingPointZonesAndTables.md) | Get all the restaurant zones and tables | [ServiceZone](docs/response/ServiceZone.md) |

## Use another PSR18 HTTP Client

If you dont want to use symfony/http-client implementation, you can easily change it to another one.

You can use a http client from [this list](https://packagist.org/providers/psr/http-client-implementation) - These are all PSR18 http client implementations.

```php
use Lsv\FoodMarketIntegration\Request;

$client = $YourPSR18Client;
Request\AbstractRequest::setHttpClient($client);
// Your requests
```

## TODO

* Easier to make the [websocket integration](https://developer.sinqro.com/en-us/notifications)

## License

[License](LICENSE)
