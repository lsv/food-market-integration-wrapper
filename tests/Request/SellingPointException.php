<?php

declare(strict_types=1);

namespace Lsv\FoodMarketIntegrationTest\Request;

class SellingPointException
{
    public int $id;
    public string $startsAt;
    public ?string $expiresAt;
}
