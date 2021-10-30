<?php

declare(strict_types=1);

namespace Lsv\FoodMarketIntegration\Model\Order;

class Payment
{
    public function __construct(public float $amount, public string $methodCode)
    {
    }
}
