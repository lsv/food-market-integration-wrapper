<?php

declare(strict_types=1);

namespace Lsv\FoodMarketIntegration\Response;

use Lsv\FoodMarketIntegration\Response\Menu\Schedule;
use Lsv\FoodMarketIntegration\Response\Menu\Section;

class Menu
{
    public int $id;
    public ?string $externalId;
    public string $name;
    public ?string $price;
    public string $type;
    public string $shortDescription;
    public int $position;
    public string $availableFrom;
    public ?string $availableTo;

    /**
     * @var Section[]
     */
    public array $menuSections;

    /**
     * @var string[]
     */
    public array $allowedOrderTypes;

    public string $scheduleLabel;
    public Schedule $schedule;
    public string $urlKey;
    public bool $hasSelection;
    public bool $selectionAvailable;
    public bool $selectionExpired;
    public bool $selectionUpcoming;
}
