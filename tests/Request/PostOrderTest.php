<?php

declare(strict_types=1);

namespace Lsv\FoodMarketIntegrationTest\Request;

use Lsv\FoodMarketIntegration\Model\ReservationPostOrder;
use Lsv\FoodMarketIntegration\Model\ReservationPostOrder\Consumer;
use Lsv\FoodMarketIntegration\Model\ReservationPostOrder\SellingPoint;
use Lsv\FoodMarketIntegration\Request\PostOrder;
use Symfony\Component\HttpClient\Response\MockResponse;

class PostOrderTest extends AbstractRequestTest
{
    private const MARKET_ID = '123';

    public function testCanPostReservationOrder(): void
    {
        $sellingPoint = new SellingPoint(456);
        $consumer = new Consumer(
            'mail',
            'name',
            'lastname',
            'phone',
            null,
            null,
            null
        );
        $reservationOrder = new ReservationPostOrder(
            '123',
            '321',
            '+20',
            'comment',
            $consumer,
            $sellingPoint,
            4
        );
        $testObject = new PostOrder(
            self::MARKET_ID,
            $reservationOrder
        );

        $responses = [
            new MockResponse(file_get_contents(__DIR__.'/responses/get_order.json')),
        ];
        self::setRequest($responses);

        $data = $testObject->request();
        self::assertSame(
            '/markets/123/orders',
            $testObject->getRequestUrl()
        );
        $requestData = $testObject->getRequestPostData();
        self::assertIsArray($requestData);
        self::assertSame('123', $requestData['marketOrderId']);
        self::assertSame('POST', $testObject->getMethod());
    }
}
