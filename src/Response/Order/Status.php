<?php

declare(strict_types=1);

namespace Lsv\FoodMarketIntegration\Response\Order;

class Status
{
    public string $code;
    public string $name;
    public string $color;
    public bool $isFinalStatus;
    public string $globalStatusCode;
}
