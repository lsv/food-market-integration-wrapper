<?php

declare(strict_types=1);

namespace Lsv\FoodMarketIntegrationTest\Request;

use Lsv\FoodMarketIntegration\Authenticate;
use Lsv\FoodMarketIntegration\Request\Request;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpClient\MockHttpClient;

abstract class AbstractRequest extends TestCase
{
    protected static function getAuthenticate(): Authenticate
    {
        return new Authenticate('user', 'server');
    }

    protected static function setRequest(array $mockResponses): void
    {
        $client = new MockHttpClient($mockResponses, 'http://url.com');
        Request::setAuthentication(self::getAuthenticate());
        Request::setHttpClient($client);
    }

    abstract public function testCanGetResponse(): void;

    public function responseObjectTest(object $object, array $tests): void
    {
        foreach ($tests as $key => $value) {
            self::assertSame($value, $object->{$key});
        }
    }
}
