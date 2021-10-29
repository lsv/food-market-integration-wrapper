<?php

declare(strict_types=1);

namespace Lsv\FoodMarketIntegration\Response\Order;

class DeliveryStatus
{
    public string $code;
    public string $name;
    public string $color;
    public bool $isFinalStatus;
}
