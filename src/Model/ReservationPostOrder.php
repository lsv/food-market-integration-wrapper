<?php

declare(strict_types=1);

namespace Lsv\FoodMarketIntegration\Model;

use Lsv\FoodMarketIntegration\Model\ReservationPostOrder\Consumer;
use Lsv\FoodMarketIntegration\Model\ReservationPostOrder\SellingPoint;

class ReservationPostOrder implements PostOrderInterface
{
    public function __construct(
        public string $marketOrderId,
        public string $code,
        public string $executionTime,
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
