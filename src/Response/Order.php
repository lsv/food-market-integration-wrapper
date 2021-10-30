<?php

declare(strict_types=1);

namespace Lsv\FoodMarketIntegration\Response;

use DateTimeInterface;
use Lsv\FoodMarketIntegration\Response\Order\Consumer;
use Lsv\FoodMarketIntegration\Response\Order\Currency;
use Lsv\FoodMarketIntegration\Response\Order\Delivery;
use Lsv\FoodMarketIntegration\Response\Order\DeliveryAddress;
use Lsv\FoodMarketIntegration\Response\Order\OrderLine;
use Lsv\FoodMarketIntegration\Response\Order\Payment;
use Lsv\FoodMarketIntegration\Response\Order\Status;

class Order
{
    public int $id;
    public ?int $orderGroupId;
    public float $totalAmount;
    public string $executionTimeLabel;
    public string $preparationTimeLabel;
    public string $comment;
    public ?string $cancellationComment;
    public Consumer $consumer;
    public Status $status;
    public string $type;
    public SellingPoint $sellingPoint;
    /**
     * @var Payment[]
     */
    public array $payments;

    /**
     * @var OrderLine[]
     */
    public array $orderLines;
    public bool $isCancellable;
    public bool $isAcceptable;
    public float $baseAmount;
    public float $vatAmount;
    public Currency $currency;
    public ?int $posOrderId;
    public string $marketOrderId;
    public string $marketOrderCode;
    public DateTimeInterface $executionTime;
    public float $deliveryAmount;
    public DeliveryAddress $deliveryAddress;
    /**
     * @var Delivery[]
     */
    public array $deliveries;
}
