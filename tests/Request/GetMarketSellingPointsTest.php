<?php

declare(strict_types=1);

namespace Lsv\FoodMarketIntegrationTest\Request;

use Lsv\FoodMarketIntegration\Model\RequestTags;
use Lsv\FoodMarketIntegration\Request\GetMarketSellingPoints;
use Lsv\FoodMarketIntegration\Response\Error\Error;
use Lsv\FoodMarketIntegration\Response\ResponseError;
use Lsv\FoodMarketIntegration\Response\SellingPoint;
use Lsv\FoodMarketIntegration\Response\SellingPoint\SellingPointAddress;
use Lsv\FoodMarketIntegration\Response\SellingPoint\SellingPointTags;
use Symfony\Component\HttpClient\Exception\ClientException;
use Symfony\Component\HttpClient\Response\MockResponse;

class GetMarketSellingPointsTest extends AbstractRequestTest
{
    private const MARKET_ID = '123';

    private GetMarketSellingPoints $testObject;

    protected function setUp(): void
    {
        $this->testObject = new GetMarketSellingPoints(self::MARKET_ID);
    }

    public function testThrowsKnownException(): void
    {
        $responses = [
            new MockResponse(file_get_contents(__DIR__.'/responses/throws_error.json'), [
                'http_code' => 400,
            ]),
        ];
        self::setRequest($responses);
        $data = $this->testObject->request();
        self::assertInstanceOf(ResponseError::class, $data);
        self::assertCount(1, $data->errors);
        self::assertInstanceOf(Error::class, $data->errors[0]);
        self::assertSame('ERROR_CODE_EXAMPLE', $data->errors[0]->code);
        self::assertSame('Error message', $data->errors[0]->message);
        self::assertSame('ERROR_CODE_EXAMPLE', $data->code);
        self::assertSame('Error message', $data->message);
        self::assertSame('400', $data->httpResponseCode);
    }

    public function testThrowsException(): void
    {
        $this->expectException(ClientException::class);
        $responses = [
            new MockResponse(file_get_contents(__DIR__.'/responses/throws_error.json'), [
                'http_code' => 404,
            ]),
        ];
        self::setRequest($responses);
        $this->testObject->request();
    }

    public function testCanGetResponse(): void
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
        $this->responseObjectTest($obj, [
            'id' => 3442,
            'name' => 'My restaurant',
            'phone' => '+34600000000',
            'email' => 'myrestaurant@example.com',
            'logo' => 'http://mycdn.com/selling-point-logo.jpeg',
            'mainImage' => 'http://mycdn.com/selling-point-main-image.jpeg',
            'listImage' => 'http://mycdn.com/selling-point-list-image.jpeg',
            'urlKey' => 'restaurant-name-city',
            'type' => 'Italian',
            'timezone' => 'Europe/Madrid',
            'description' => 'This restaurant...',
        ]);

        self::assertInstanceOf(SellingPointAddress::class, $obj->address);
        $this->responseObjectTest($obj->address, [
            'id' => 1003,
            'street' => 'C/ Example, 23',
            'details' => 'Canada building',
            'city' => 'City name',
            'province' => 'Province name',
            'postalCode' => '12345',
            'latitude' => 41.308166,
            'longitude' => 2.019725,
            'googlePlaceId' => 'xxxxxxxxxxxx',
            'placeName' => 'C/ Example, 23, City name',
        ]);

        self::assertInstanceOf(SellingPoint\SellingPointSchedule::class, $obj->schedule);
        self::assertSame(2113, $obj->schedule->id);
        self::assertCount(1, $obj->schedule->ranges);
        $range = $obj->schedule->ranges[0];
        $this->responseObjectTest($range, [
            'startTime' => '06:00:00',
            'endTime' => '18:00:00',
            'timezone' => 'Europe/Madrid',
        ]);
        self::assertInstanceOf(SellingPoint\SellingPointScheduleRangeDay::class, $range->startDay);
        self::assertSame(1, $range->startDay->id);
        self::assertSame('Lunes', $range->startDay->name);
        self::assertInstanceOf(SellingPoint\SellingPointScheduleRangeDay::class, $range->endDay);
        self::assertSame(1, $range->startDay->id);
        self::assertSame('Lunes', $range->startDay->name);

        self::assertCount(2, $obj->allowedOrderTypes);
        self::assertCount(1, $obj->tags);
        $tag = $obj->tags[0];
        self::assertInstanceOf(SellingPointTags::class, $tag);
        self::assertSame('Veggie', $tag->name);
        self::assertSame('veggie', $tag->code);
    }
}
