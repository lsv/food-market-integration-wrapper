<?php

declare(strict_types=1);

namespace Lsv\FoodMarketIntegrationTest\Request;

use Generator;
use Lsv\FoodMarketIntegration\Request\GetOrder;
use Lsv\FoodMarketIntegration\Response\Order;
use Lsv\FoodMarketIntegration\Response\SellingPoint;
use Lsv\FoodMarketIntegrationTest\ResponseObject;

class GetOrderTest extends AbstractRequestTest
{
    private const MARKET_ID = '123';
    private const ORDER_ID = '321';

    private GetOrder $testObject;

    public function testCanGetResponse(): void
    {
        $responses = [
            new ResponseObject(file_get_contents(__DIR__.'/responses/get_order.json')),
        ];
        self::setRequest($responses);

        $data = $this->testObject->request();
        self::assertSame(
            '/markets/123/orders/321',
            $this->testObject->getRequestUrl()
        );

        self::assertInstanceOf(Order::class, $data);
        $this->responseObjectTest($data, [
            'id' => 418774,
            'orderGroupId' => null,
            'totalAmount' => 68.0,
            'executionTimeLabel' => 'hoy 23/07 a las 09:06h',
            'preparationTimeLabel' => 'hoy 23/07 a las 08:56h',
            'comment' => 'This is the order comment!',
            'cancellationComment' => null,
            'type' => 'delivery',
            'isCancellable' => true,
            'isAcceptable' => true,
            'baseAmount' => 61.75,
            'vatAmount' => 6.25,
            'posOrderId' => null,
            'marketOrderId' => '73626',
            'marketOrderCode' => 'RNYLUD',
            'deliveryAmount' => 1.0,
        ]);
        self::assertSame('2020-23-07', $data->executionTime->format('Y-d-m'));

        $consumer = $data->consumer;
        self::assertInstanceOf(Order\Consumer::class, $consumer);
        $this->responseObjectTest($consumer, [
            'id' => 18899,
            'name' => 'Client_73626',
            'lastname' => 'Lastname_73626',
            'email' => null,
            'phone' => '+34600000000',
            'image' => null,
            'notificationsChannel' => '1f4cac2743f504bb2a10cdff9bc2c365',
            'chatToken' => null,
            'marketClientId' => null,
        ]);
        $status = $data->status;
        self::assertInstanceOf(Order\Status::class, $status);
        $this->responseObjectTest($status, [
            'code' => 'waiting_sp_validation',
            'name' => 'Esperando validación del negocio',
            'color' => '#f7981d',
            'isFinalStatus' => false,
            'globalStatusCode' => 'processing',
        ]);

        $sellingPoint = $data->sellingPoint;
        self::assertInstanceOf(SellingPoint::class, $sellingPoint);
        self::assertSame(3961, $sellingPoint->id);
        self::assertInstanceOf(SellingPoint\SellingPointAddress::class, $sellingPoint->address);
        self::assertSame(16187, $sellingPoint->address->id);

        self::assertCount(1, $data->payments);
        $payment = $data->payments[0];
        self::assertInstanceOf(Order\Payment::class, $payment);
        $this->responseObjectTest($payment, [
            'id' => 54712,
            'amount' => 68.0,
            'paymentMethodName' => 'Efectivo',
            'prepaid' => false,
        ]);

        self::assertCount(4, $data->orderLines);
        $orderLine = $data->orderLines[0];
        self::assertInstanceOf(Order\OrderLine::class, $orderLine);
        $this->responseObjectTest($orderLine, [
            'type' => 'PRODUCT',
            'totalAmount' => 36.0,
            'unitPrice' => 12.0,
            'quantity' => 3,
            'label' => 'Pizza de la huerta',
            'comment' => null,
            'baseAmount' => 32.73,
            'vatAmount' => 3.27,
            'vatValue' => 10.0,
        ]);
        self::assertCount(1, $orderLine->childrenOrderLines);
        $childOrderLine = $orderLine->childrenOrderLines[0];
        self::assertInstanceOf(Order\OrderLine::class, $childOrderLine);
        self::assertSame('PRODUCT_OPTION', $childOrderLine->type);
        self::assertCount(0, $childOrderLine->childrenOrderLines);

        self::assertInstanceOf(Order\Currency::class, $data->currency);
        self::assertSame('EUR', $data->currency->isoCode);
        self::assertSame('€', $data->currency->symbol);
        self::assertSame('{{ amount }}€', $data->currency->displayPattern);

        self::assertInstanceOf(Order\DeliveryAddress::class, $data->deliveryAddress);
        self::assertSame(16188, $data->deliveryAddress->id);

        self::assertCount(1, $data->deliveries);
        $delivery = $data->deliveries[0];
        self::assertInstanceOf(Order\Delivery::class, $delivery);
        $this->responseObjectTest($delivery, [
            'id' => 283003,
            'driver' => null,
            'deliveryAccountName' => null,
            'deliveryAccountPhone' => null,
            'deliveryInstructions' => null,
            'forSenderInstructions' => null,
            'linearDistance' => 0.0,
            'realDistance' => null,
            'route' => null,
            'estimatedDeliveryDuration' => 0,
            'destinationContactEmail' => null,
            'destinationContactName' => 'Client_73626 · Lastname_73626',
            'destinationContactPhone' => '600000000',
            'trackingUrl' => 'https://tracking.sinqro.com/es-es/delivery?t=3b89b290f687eb6abc134d588be7be1a',
        ]);
        self::assertSame('23-07-2020', $delivery->pickupAgreedAt->format('d-m-Y'));
        self::assertSame('23-07-2020', $delivery->pickupConfirmedAt->format('d-m-Y'));
        self::assertSame('23-07-2020', $delivery->deliveryAgreedAt->format('d-m-Y'));
        self::assertSame('23-07-2020', $delivery->deliveryConfirmedAt->format('d-m-Y'));

        $status = $delivery->status;
        self::assertInstanceOf(Order\DeliveryStatus::class, $status);
        $this->responseObjectTest($status, [
            'code' => 'WAITING_SELLING_POINT_ACCEPTANCE',
            'name' => 'Esperando aceptación punto de venta',
            'color' => '#f7981d',
            'isFinalStatus' => false,
        ]);
        $pickup = $delivery->pickupAddress;
        self::assertInstanceOf(Order\PickupAddress::class, $pickup);
        $this->responseObjectTest($pickup, [
            'id' => 16187,
            'street' => 'Carrer de la Tecnologia, 17',
            'details' => '',
            'city' => 'Viladecans',
            'province' => 'Barcelona',
            'postalCode' => '08840',
            'latitude' => 41.31372,
            'longitude' => 2.031222,
            'googlePlaceId' => 'ChIJRQPl5lmcpBIRXpga-ZW5xvY',
            'placeName' => 'Carrer de la Tecnologia, 17, 08840 Viladecans, Barcelona, España',
            'autoGeolocated' => true,
        ]);

        $del = $delivery->deliveryAddress;
        self::assertInstanceOf(Order\DeliveryAddress::class, $del);
        $this->responseObjectTest($del, [
            'id' => 16188,
            'street' => 'Carrer de la Tecnologia, 17',
            'details' => null,
            'city' => 'Viladecans',
            'province' => 'Barcelona',
            'postalCode' => '08840',
            'latitude' => 41.31372,
            'longitude' => 2.031222,
            'googlePlaceId' => 'ChIJRQPl5lmcpBIRXpga-ZW5xvY',
            'placeName' => 'Carrer de la Tecnologia, 17, 08840 Viladecans, Barcelona, España',
            'autoGeolocated' => true,
        ]);
    }

    public function getDifferentOrders(): Generator
    {
        yield 'collection_order' => [file_get_contents(__DIR__.'/responses/collection_order_example.json')];
        yield 'delivery_order' => [file_get_contents(__DIR__.'/responses/delivery_order_example.json')];
        yield 'inside_order' => [file_get_contents(__DIR__.'/responses/inside_order_example.json')];
        yield 'insitu_order' => [file_get_contents(__DIR__.'/responses/insitu_order_example.json')];
        yield 'reservation_order' => [file_get_contents(__DIR__.'/responses/reservation_order_example.json')];
    }

    /**
     * @dataProvider getDifferentOrders
     */
    public function testCanGetDifferentOrderTypes(string $file): void
    {
        $responses = [
            new ResponseObject($file),
        ];
        self::setRequest($responses);

        $data = $this->testObject->request();
        self::assertInstanceOf(Order::class, $data);
    }

    protected function setUp(): void
    {
        $this->testObject = new GetOrder(self::MARKET_ID, self::ORDER_ID);
    }
}
