<?php

declare(strict_types=1);

namespace Lsv\FoodMarketIntegration\Response\Menu;

class ProductOption
{
    public int $id;
    public ?string $externalId;
    public string $name;
    public ?string $shortDescription;
    public int $position;
    public float $price;
    public bool $isAvailable;
}
