<?php

declare(strict_types=1);

namespace Lsv\FoodMarketIntegrationTest\Request;

use Lsv\FoodMarketIntegration\Request\GetOrderStatus;
use Lsv\FoodMarketIntegration\Response\OrderStatus;
use Lsv\FoodMarketIntegrationTest\ResponseObject;

class GetOrderStatusTest extends AbstractRequestTest
{
    private const MARKET_ID = '123';
    private const ORDER_ID = '321';

    private GetOrderStatus $testObject;

    protected function setUp(): void
    {
        $this->testObject = new GetOrderStatus(self::MARKET_ID, self::ORDER_ID);
    }

    public function testCanGetResponse(): void
    {
        $responses = [
            new ResponseObject(file_get_contents(__DIR__.'/responses/get_order_status.json')),
        ];
        self::setRequest($responses);

        $data = $this->testObject->request();
        self::assertSame(
            '/markets/123/orders/321/status',
            $this->testObject->getRequestUrl()
        );

        self::assertInstanceOf(OrderStatus::class, $data);
        self::assertSame('waiting_sp_validation', $data->code);
        self::assertSame('Waiting selling point validation', $data->name);
        self::assertSame('#f7981d', $data->color);
        self::assertNull($data->callToAction);
        self::assertSame('processing', $data->globalStatusCode);
    }
}
