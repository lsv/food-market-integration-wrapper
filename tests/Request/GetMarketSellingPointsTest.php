<?php

declare(strict_types=1);

namespace Lsv\FoodMarketIntegrationTest\Request;

use Lsv\FoodMarketIntegration\Model\RequestTags;
use Lsv\FoodMarketIntegration\Request\GetMarketSellingPoints;
use Lsv\FoodMarketIntegration\Response\SellingPoint;
use Lsv\FoodMarketIntegration\Response\SellingPointAddress;
use Lsv\FoodMarketIntegration\Response\SellingPointTags;
use RuntimeException;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Response\MockResponse;

class GetMarketSellingPointsTest extends AbstractRequest
{
    private const MARKET_ID = '123';

    private GetMarketSellingPoints $testObject;

    protected function setUp(): void
    {
        $this->testObject = new GetMarketSellingPoints(self::MARKET_ID);
    }

    public function testCanMakeResponse(): void
    {
        $responses = [
            new MockResponse(file_get_contents(__DIR__.'/responses/get_market_selling_points.json')),
        ];
        self::setRequest($responses);

        $requestTags = new RequestTags();
        $requestTags->addTag('code', 'value');
        $this->testObject->setRequestTags($requestTags);

        $data = $this->testObject->request();
        self::assertSame(
            '/markets/123/sellingPoints?tags%5B0%5D%5Bcode%5D=code&tags%5B0%5D%5Bvalue%5D=value',
            $this->testObject->getRequestUrl()
        );

        self::assertCount(1, $data);
        $obj = $data[0];
        self::assertInstanceOf(SellingPoint::class, $obj);
        self::assertSame(3442, $obj->id);
        self::assertInstanceOf(SellingPointAddress::class, $obj->address);
        self::assertSame(1003, $obj->address->id);
        self::assertCount(1, $obj->schedule->ranges);
        $range = $obj->schedule->ranges[0];
        self::assertSame('06:00:00', $range->startTime);
        self::assertSame(1, $range->startDay->id);
        self::assertCount(2, $obj->allowedOrderTypes);
        self::assertCount(1, $obj->tags);
        $tag = $obj->tags[0];
        self::assertInstanceOf(SellingPointTags::class, $tag);
        self::assertSame('Veggie', $tag->name);
    }
}
