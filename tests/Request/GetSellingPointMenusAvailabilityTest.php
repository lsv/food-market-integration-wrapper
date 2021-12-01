<?php

declare(strict_types=1);

namespace Lsv\FoodMarketIntegrationTest\Request;

use Lsv\FoodMarketIntegration\Request\GetSellingPointMenusAvailability;
use Lsv\FoodMarketIntegrationTest\ResponseObject;

class GetSellingPointMenusAvailabilityTest extends AbstractRequestTest
{
    private const MARKET_ID = '123';
    private const SELLING_POINT = 321;

    private GetSellingPointMenusAvailability $testObject;

    protected function setUp(): void
    {
        $this->testObject = new GetSellingPointMenusAvailability(self::MARKET_ID, self::SELLING_POINT);
    }

    public function testCanGetResponse(): void
    {
        $responses = [
            new ResponseObject(file_get_contents(__DIR__.'/responses/get_selling_point_menus.json')),
        ];
        self::setRequest($responses);

        $this->testObject->setLoadProducts(false);
        $this->testObject->request();
        self::assertSame(
            '/markets/123/sellingPoints/321/menus?loadProducts=0',
            $this->testObject->getRequestUrl()
        );
    }
}
