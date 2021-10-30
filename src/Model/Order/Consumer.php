<?php

declare(strict_types=1);

namespace Lsv\FoodMarketIntegration\Model\Order;

class Consumer
{
    public function __construct(
        public string $email,
        public string $name,
        public string $lastname,
        public string $phone,
        public ?string $billingName,
        public ?string $billingAddress,
        public ?string $billingVatNumber
    ) {
    }
}
