<?php

declare(strict_types=1);

namespace Lsv\FoodMarketIntegrationTest\Request;

use Http\Mock\Client;
use Lsv\FoodMarketIntegration\Authenticate;
use Lsv\FoodMarketIntegration\Request\AbstractRequest;
use PHPUnit\Framework\TestCase;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Message\ResponseInterface;

abstract class AbstractRequestTest extends TestCase
{
    protected static function getAuthenticate(): Authenticate
    {
        return new Authenticate('user', 'server');
    }

    /**
     * @param array<ResponseInterface> $mockResponses
     */
    protected static function setRequest(array $mockResponses): void
    {
        $client = new Client();
        foreach ($mockResponses as $response) {
            if (404 === $response->getStatusCode()) {
                $exception = new class() extends \Exception implements ClientExceptionInterface {
                };
                $client->addException($exception);
            }

            $client->addResponse($response);
        }

        AbstractRequest::setAuthentication(self::getAuthenticate());
        AbstractRequest::setHttpClient($client);
    }

    public function responseObjectTest(object $object, array $tests): void
    {
        foreach ($tests as $key => $value) {
            self::assertSame($value, $object->{$key});
        }
    }
}
