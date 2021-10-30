<?php

declare(strict_types=1);

namespace Lsv\FoodMarketIntegration\Model;

use DateTimeInterface;
use Lsv\FoodMarketIntegration\Model\Order\Consumer;
use Lsv\FoodMarketIntegration\Model\Order\Delivery;
use Lsv\FoodMarketIntegration\Model\Order\OrderLine;
use Lsv\FoodMarketIntegration\Model\Order\Payment;
use Lsv\FoodMarketIntegration\Model\Order\SellingPoint;

class DeliveryOrder implements PostOrderInterface
{
    /**
     * @param Payment[]   $payments
     * @param OrderLine[] $orderLines
     */
    public function __construct(
        public string $marketOrderId,
        public string $code,
        public float $productsAmount,
        public float $deliveryAmount,
        public float $tipsAmount,
        public float $discountsAmount,
        public float $totalAmount,
        public DateTimeInterface $executionTime,
        public string $comment,
        public string $currency,
        public Consumer $consumer,
        public SellingPoint $sellingPoint,
        public array $payments,
        public array $orderLines,
        public Delivery $delivery
    ) {
    }

    public function getType(): string
    {
        return 'delivery';
    }
}
