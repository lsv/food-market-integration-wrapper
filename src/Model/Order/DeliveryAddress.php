<?php

declare(strict_types=1);

namespace Lsv\FoodMarketIntegration\Model\Order;

class DeliveryAddress
{
    public function __construct(
        public string $completeAddress,
        public string $details
    ) {
    }
}
