<?php

declare(strict_types=1);

namespace Lsv\FoodMarketIntegration\Model;

use DateTimeInterface;
use Lsv\FoodMarketIntegration\Model\Order\Consumer;
use Lsv\FoodMarketIntegration\Model\Order\SellingPoint;

class ReservationOrder implements PostOrderInterface
{
    public function __construct(
        public string $marketOrderId,
        public string $code,
        public DateTimeInterface $executionTime,
        public string $comment,
        public Consumer $consumer,
        public SellingPoint $sellingPoint,
        public int $dinersNumber
    ) {
    }

    public function getType(): string
    {
        return 'reservation';
    }
}
