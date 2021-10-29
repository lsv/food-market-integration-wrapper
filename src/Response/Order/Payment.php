<?php

declare(strict_types=1);

namespace Lsv\FoodMarketIntegration\Response\Order;

class Payment
{
    public int $id;
    public float $amount;
    public string $paymentMethodName;
    public bool $prepaid;
}
