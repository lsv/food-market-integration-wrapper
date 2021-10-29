<?php

declare(strict_types=1);

namespace Lsv\FoodMarketIntegrationTest\Request;

use Lsv\FoodMarketIntegration\Authenticate;
use Lsv\FoodMarketIntegration\Request\AbstractRequest;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpClient\MockHttpClient;

abstract class AbstractRequestTest extends TestCase
{
    protected static function getAuthenticate(): Authenticate
    {
        return new Authenticate('user', 'server');
    }

    protected static function setRequest(array $mockResponses): void
    {
        $client = new MockHttpClient($mockResponses, 'http://url.com');
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
