<?php

declare(strict_types=1);

namespace Lsv\FoodMarketIntegrationTest\Request;

use Lsv\FoodMarketIntegration\Request\GetSellingPointAvailability;
use Lsv\FoodMarketIntegration\Response\SellingPointAvailability\CollectionServiceAvailability;
use Lsv\FoodMarketIntegration\Response\SellingPointAvailability\DeliveryServiceAvailability;
use Lsv\FoodMarketIntegration\Response\SellingPointAvailability\InsituServiceAvailability;
use Lsv\FoodMarketIntegration\Response\SellingPointAvailability\ReservationServiceAvailability;
use Symfony\Component\HttpClient\Response\MockResponse;

class GetSellingPointAvailabilityTest extends AbstractRequestTest
{
    private const MARKET_ID = '123';
    private const SELLING_POINT = 321;

    private GetSellingPointAvailability $testObject;

    protected function setUp(): void
    {
        $this->testObject = new GetSellingPointAvailability(self::MARKET_ID, self::SELLING_POINT);
    }

    public function testCanSetDate(): void
    {
        $responses = [
            new MockResponse(file_get_contents(__DIR__.'/responses/get_selling_point_availability.json')),
        ];
        self::setRequest($responses);

        $date = new \DateTime('2021-12-15');
        $this->testObject->setDate($date);
        $data = $this->testObject->request();
        self::assertSame(
            '/markets/123/sellingPoints/321/availability?date=2021-12-15',
            $this->testObject->getRequestUrl()
        );
    }

    public function testCanGetResponse(): void
    {
        $responses = [
            new MockResponse(file_get_contents(__DIR__.'/responses/get_selling_point_availability.json')),
        ];
        self::setRequest($responses);

        $data = $this->testObject->request();
        self::assertSame(
            '/markets/123/sellingPoints/321/availability',
            $this->testObject->getRequestUrl()
        );

        self::assertInstanceOf(DeliveryServiceAvailability::class, $data->deliveryServiceAvailability);
        self::assertSame('35 min', $data->deliveryServiceAvailability->availabilityLabelShort);
        self::assertSame('Delivery in 30 min', $data->deliveryServiceAvailability->availabilityLabel);
        self::assertTrue($data->deliveryServiceAvailability->desiredDayHasService);
        self::assertSame(2.34, $data->deliveryServiceAvailability->distance);
        self::assertTrue($data->deliveryServiceAvailability->enabled);
        self::assertFalse($data->deliveryServiceAvailability->isOutOfRange);
        self::assertSame('From 09.30h to 23.30h', $data->deliveryServiceAvailability->executionTimeLabel);
        self::assertSame('2017-02-10T09:30:00+0000', $data->deliveryServiceAvailability->firstExecutionTime);
        self::assertNull($data->deliveryServiceAvailability->maxDiners);
        self::assertCount(2, $data->deliveryServiceAvailability->services);
        $services = $data->deliveryServiceAvailability->services;
        self::assertSame('service_1', $services[0]);

        self::assertInstanceOf(CollectionServiceAvailability::class, $data->collectionServiceAvailability);
        self::assertInstanceOf(InsituServiceAvailability::class, $data->insituServiceAvailability);
        self::assertInstanceOf(ReservationServiceAvailability::class, $data->reservationServiceAvailability);
        self::assertSame(20, $data->reservationServiceAvailability->maxDiners);
    }
}
