<?php

declare(strict_types=1);

namespace Lsv\FoodMarketIntegrationTest\Request;

use Lsv\FoodMarketIntegration\Request\GetSellingPointZonesAndTables;
use Symfony\Component\HttpClient\Response\MockResponse;

class GetSellingPointZonesAndTablesTest extends AbstractRequestTest
{
    private const MARKET_ID = '123';
    private const SELLING_POINT = 321;

    private GetSellingPointZonesAndTables $testObject;

    protected function setUp(): void
    {
        $this->testObject = new GetSellingPointZonesAndTables(self::MARKET_ID, self::SELLING_POINT);
    }

    public function testCanGetResponse(): void
    {
        $responses = [
            new MockResponse(file_get_contents(__DIR__.'/responses/get_selling_point_zones_and_tables.json')),
        ];
        self::setRequest($responses);

        $data = $this->testObject->request();
        self::assertSame(
            '/markets/123/sellingPoints/321/serviceZones',
            $this->testObject->getRequestUrl()
        );

        self::assertCount(2, $data);
        $location = $data[0];
        $this->responseObjectTest($location, [
            'code' => 'TZ',
            'name' => 'Terraza',
        ]);
        self::assertCount(20, $location->serviceLocations);
        $this->responseObjectTest($location->serviceLocations[0], [
            'code' => 'TZ1',
            'name' => 'Mesa 1',
        ]);
    }
}
