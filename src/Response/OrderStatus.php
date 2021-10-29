<?php

declare(strict_types=1);

namespace Lsv\FoodMarketIntegration\Response;

class OrderStatus
{
    public string $code;
    public string $name;
    public string $color;
    public ?string $callToAction;
    public string $globalStatusCode;
}
