<?php

declare(strict_types=1);

namespace Lsv\FoodMarketIntegration\Response\SellingPointAvailability;

use DateTimeInterface;

abstract class AbstractSellingPointAvailability
{
    public string $availabilityLabelShort;
    public string $availabilityLabel;
    public bool $desiredDayHasService;
    public ?float $distance;
    public bool $enabled;
    public ?bool $isOutOfRange;
    public string $executionTimeLabel;
    public DateTimeInterface $firstExecutionTime;
    public ?int $maxDiners;

    /**
     * @var string[]
     */
    public array $services;
}
