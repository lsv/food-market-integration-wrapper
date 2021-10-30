<?php

declare(strict_types=1);

namespace Lsv\FoodMarketIntegrationTest\Request;

use DateTimeInterface;

class SellingPointException
{
    public int $id;
    public DateTimeInterface $startsAt;
    public ?DateTimeInterface $expiresAt;
}
