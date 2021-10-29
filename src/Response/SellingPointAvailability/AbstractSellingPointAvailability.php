<?php

declare(strict_types=1);

namespace Lsv\FoodMarketIntegration\Response\SellingPointAvailability;

abstract class AbstractSellingPointAvailability
{
    public string $availabilityLabelShort;
    public string $availabilityLabel;
    public bool $desiredDayHasService;
    public ?float $distance;
    public bool $enabled;
    public ?bool $isOutOfRange;
    public string $executionTimeLabel;
    public string $firstExecutionTime;
    public ?int $maxDiners;

    /**
     * @var string[]
     */
    public array $services;
}
