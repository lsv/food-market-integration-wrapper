<?php

declare(strict_types=1);

namespace Lsv\FoodMarketIntegrationTest\Request;

use Lsv\FoodMarketIntegration\Request\GetSellingPointClosingExceptions;
use Symfony\Component\HttpClient\Response\MockResponse;

class GetSellingPointClosingExceptionsTest extends AbstractRequestTest
{
    private const MARKET_ID = '123';
    private const SELLING_POINT = 321;

    private GetSellingPointClosingExceptions $testObject;

    public function testCanGetResponse(): void
    {
        $responses = [
            new MockResponse(file_get_contents(__DIR__.'/responses/get_selling_point_closing_exceptions.json')),
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
            'startsAt' => '2017-10-14T22:00:00+0000',
            'expiresAt' => '2017-10-15T21:59:00+0000',
        ]);
    }

    protected function setUp(): void
    {
        $this->testObject = new GetSellingPointClosingExceptions(self::MARKET_ID, self::SELLING_POINT);
    }
}
