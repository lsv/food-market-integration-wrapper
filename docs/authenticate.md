[<](../README.md) Sinqro Food Market wrapper
--------------------------

### Authenticate

You will need a user access token, and a server access token to be able to authenticate.

When you have them, you can set the authentication like this

Only needs to be set once - After this you can make multiple requsts.

```php
use Lsv\FoodMarketIntegration\Authenticate;
use Lsv\FoodMarketIntegration\Request;

$userAccessToken = 'your user access token';
$serverAccessToken = 'your server access token';
$authenticate = new Authenticate($userAccessToken, $serverAccessToken);
Request\AbstractRequest::setAuthentication($authenticate);
```
