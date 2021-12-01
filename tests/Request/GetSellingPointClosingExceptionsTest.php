<?php

declare(strict_types=1);

namespace Lsv\FoodMarketIntegrationTest\Request;

use Lsv\FoodMarketIntegration\Request\GetSellingPointClosingExceptions;
use Lsv\FoodMarketIntegrationTest\ResponseObject;

class GetSellingPointClosingExceptionsTest extends AbstractRequestTest
{
    private const MARKET_ID = '123';
    private const SELLING_POINT = 321;

    private GetSellingPointClosingExceptions $testObject;

    public function testCanGetResponse(): void
    {
        $responses = [
            new ResponseObject(file_get_contents(__DIR__.'/responses/get_selling_point_closing_exceptions.json')),
        ];
        self::setRequest($responses);

        $data = $this->testObject->request();
        self::assertSame(
            '/markets/123/sellingPoints/321/exceptions/next',
            $this->testObject->getRequestUrl()
        );

        self::assertCount(1, $data);
        $this->responseObjectTest($data[0], [
            'id' => 872,
        ]);

        self::assertSame('2017-10-14', $data[0]->startsAt->format('Y-m-d'));
        self::assertSame('2017-10-15', $data[0]->expiresAt->format('Y-m-d'));
    }

    protected function setUp(): void
    {
        $this->testObject = new GetSellingPointClosingExceptions(self::MARKET_ID, self::SELLING_POINT);
    }
}
