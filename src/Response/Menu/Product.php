<?php

declare(strict_types=1);

namespace Lsv\FoodMarketIntegration\Response\Menu;

class Product
{
    public int $id;
    public ?string $externalId;
    public string $name;
    public ?string $shortDescription;
    public ?string $description;
    public ?string $image;
    public float $price;
    public int $minOrderPreparationMinutes;
    public int $minMinutesOrderInAdvance;

    /**
     * @var string[]
     */
    public array $tags;
    public ?string $parentName;
    public bool $isAvailable;

    /**
     * @var string[]
     */
    public array $productVariants;

    /**
     * @var ProductOptionsCategory[]
     */
    public array $productOptionsCategories;

    public bool $public;
    public bool $featured;
}
