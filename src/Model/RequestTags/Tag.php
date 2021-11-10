<?php

declare(strict_types=1);

namespace Lsv\FoodMarketIntegration\Model\RequestTags;

class Tag
{
    public function __construct(public string $code, public string $value)
    {
    }
}
