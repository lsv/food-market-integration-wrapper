<?php

declare(strict_types=1);

namespace Lsv\FoodMarketIntegrationTest\Request;

use DateTime;
use DateTimeInterface;
use Lsv\FoodMarketIntegration\Model\DeliveryOrder;
use Lsv\FoodMarketIntegration\Model\Order\ChildOrderLine;
use Lsv\FoodMarketIntegration\Model\Order\Consumer;
use Lsv\FoodMarketIntegration\Model\Order\Delivery;
use Lsv\FoodMarketIntegration\Model\Order\DeliveryAddress;
use Lsv\FoodMarketIntegration\Model\Order\OrderLine;
use Lsv\FoodMarketIntegration\Model\Order\Payment;
use Lsv\FoodMarketIntegration\Model\Order\Product;
use Lsv\FoodMarketIntegration\Model\Order\SellingPoint;
use Lsv\FoodMarketIntegration\Model\ReservationOrder;
use Lsv\FoodMarketIntegration\Request\PostOrder;
use Lsv\FoodMarketIntegrationTest\ResponseObject;

class PostOrderTest extends AbstractRequestTest
{
    private const MARKET_ID = '123';

    public function testCanPostDeliveryOrder(): void
    {
        $payments = [
            new Payment(5.0, 'method'),
        ];

        $childrenOrderlines = [
            new ChildOrderLine(
                'PRODUCT',
                125.0,
                5.0,
                105.0,
                105.0,
                2,
                'label',
                'comment',
                75.95,
                12.5,
                11.0,
                [],
                new Product(2550)
            ),
        ];

        $orderlines = [
            new OrderLine(
                'PRODUCT',
                125.0,
                5.0,
                105.0,
                105.0,
                2,
                'label',
                'comment',
                75.95,
                12.5,
                11.0,
                $childrenOrderlines,
                new Product(1880)
            ),
        ];

        $delivery = new Delivery(new DeliveryAddress('my house', 'on the street'));

        $order = new DeliveryOrder(
            self::MARKET_ID,
            'code',
            30.50,
            5.5,
            0,
            0,
            36.0,
            $this->getExecutionTime(),
            'comment',
            'DKK',
            $this->getConsumer(),
            $this->getSellingPoint(),
            $payments,
            $orderlines,
            $delivery
        );

        $testObject = new PostOrder(
            self::MARKET_ID,
            $order
        );

        $responses = [
            new ResponseObject(file_get_contents(__DIR__.'/responses/get_order.json')),
        ];
        self::setRequest($responses);

        $testObject->request();
        self::assertSame(
            '/markets/123/orders',
            $testObject->getRequestUrl()
        );
        $requestData = $testObject->getRequestPostData();
        self::assertIsArray($requestData);

        self::assertSame('code', $requestData['code']);
        self::assertSame('2017-02-18T10:00:00+00:00', $requestData['executionTime']);
        self::assertCount(1, $requestData['payments']);
        $payment = $requestData['payments'][0];
        self::assertSame(5, $payment['amount']);
        self::assertSame('method', $payment['methodCode']);
    }

    public function testCanPostReservationOrder(): void
    {
        $reservationOrder = new ReservationOrder(
            self::MARKET_ID,
            '321',
            $this->getExecutionTime(),
            'comment',
            $this->getConsumer(),
            $this->getSellingPoint(),
            4
        );
        $testObject = new PostOrder(
            self::MARKET_ID,
            $reservationOrder
        );

        $responses = [
            new ResponseObject(file_get_contents(__DIR__.'/responses/get_order.json')),
        ];
        self::setRequest($responses);

        $testObject->request();
        self::assertSame(
            '/markets/123/orders',
            $testObject->getRequestUrl()
        );
        $requestData = $testObject->getRequestPostData();
        self::assertIsArray($requestData);
        self::assertSame('123', $requestData['marketOrderId']);
        self::assertSame('POST', $testObject->getMethod());
        self::assertSame('mail', $requestData['consumer']['email']);
    }

    private function getSellingPoint(): SellingPoint
    {
        return new SellingPoint(456);
    }

    private function getConsumer(): Consumer
    {
        return new Consumer(
            'mail',
            'name',
            'lastname',
            'phone',
            null,
            null,
            null
        );
    }

    private function getExecutionTime(): DateTimeInterface
    {
        return new DateTime('2017-02-18 10:00:00');
    }
}
