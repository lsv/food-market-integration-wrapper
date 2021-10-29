<?php

declare(strict_types=1);

namespace Lsv\FoodMarketIntegrationTest\Request;

use Lsv\FoodMarketIntegration\Request\GetMarketSellingPoint;
use Lsv\FoodMarketIntegration\Response\SellingPoint\SellingPointAddress;
use Symfony\Component\HttpClient\Response\MockResponse;

class GetMarketSellingPointTest extends AbstractRequest
{
    private const MARKET_ID = '123';
    private const SELLING_POINT = 321;

    private GetMarketSellingPoint $testObject;

    protected function setUp(): void
    {
        $this->testObject = new GetMarketSellingPoint(self::MARKET_ID, self::SELLING_POINT);
    }

    public function testCanGetResponse(): void
    {
        $responses = [
            new MockResponse(file_get_contents(__DIR__.'/responses/get_market_selling_point.json')),
        ];
        self::setRequest($responses);

        $data = $this->testObject->request();
        self::assertSame(
            '/markets/123/sellingPoints/321',
            $this->testObject->getRequestUrl()
        );

        self::assertSame(3442, $data->id);
        self::assertInstanceOf(SellingPointAddress::class, $data->address);
    }
}
