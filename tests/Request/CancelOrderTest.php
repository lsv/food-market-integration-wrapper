<?php

declare(strict_types=1);

namespace Lsv\FoodMarketIntegrationTest\Request;

use Lsv\FoodMarketIntegration\Request\CancelOrder;
use Lsv\FoodMarketIntegration\Response\Order;
use Lsv\FoodMarketIntegrationTest\ResponseObject;

class CancelOrderTest extends AbstractRequestTest
{
    private const MARKET_ID = '123';
    private const ORDER_ID = '321';
    private const COMMENT = 'comment';

    private CancelOrder $testObject;

    public function testCanGetResponse(): void
    {
        $responses = [
            new ResponseObject(file_get_contents(__DIR__.'/responses/get_order.json')),
        ];
        self::setRequest($responses);

        $data = $this->testObject->request();
        self::assertSame(
            '/markets/123/orders/321/cancel',
            $this->testObject->getRequestUrl()
        );
        self::assertSame(['comment' => 'comment'], $this->testObject->getRequestPostData());
        self::assertSame('POST', $this->testObject->getMethod());

        self::assertInstanceOf(Order::class, $data);
    }

    protected function setUp(): void
    {
        $this->testObject = new CancelOrder(
            self::MARKET_ID,
            self::ORDER_ID,
            self::COMMENT
        );
    }
}
