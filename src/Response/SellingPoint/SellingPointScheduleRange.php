<?php

declare(strict_types=1);

namespace Lsv\FoodMarketIntegration\Response\SellingPoint;

class SellingPointScheduleRange
{
    public string $startTime;
    public string $endTime;
    public string $timezone;
    public SellingPointScheduleRangeDay $startDay;
    public SellingPointScheduleRangeDay $endDay;
}
