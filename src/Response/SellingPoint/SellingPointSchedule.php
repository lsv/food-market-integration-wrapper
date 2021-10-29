<?php

declare(strict_types=1);

namespace Lsv\FoodMarketIntegration\Response\SellingPoint;

class SellingPointSchedule
{
    public int $id;

    /**
     * @var SellingPointScheduleRange[]
     */
    public array $ranges;
}
