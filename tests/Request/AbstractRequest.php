<?php

declare(strict_types=1);

namespace Lsv\FoodMarketIntegrationTest\Request;

use Lsv\FoodMarketIntegration\Authenticate;
use Lsv\FoodMarketIntegration\Request\Request;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;

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
}
