<?php

declare(strict_types=1);

namespace Lsv\FoodMarketIntegration\Response;

use DateTimeInterface;

class SellingPointException
{
    public int $id;
    public DateTimeInterface $startsAt;
    public ?DateTimeInterface $expiresAt;
}
