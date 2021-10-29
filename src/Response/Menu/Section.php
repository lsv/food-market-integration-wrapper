<?php

declare(strict_types=1);

namespace Lsv\FoodMarketIntegration\Response\Menu;

class Section
{
    public int $id;
    public ?string $externalId;
    public string $name;
    public ?string $shortDescription;
    public ?string $image;
    public int $position;
    public bool $showProductImages;
    public int $maxSelection;
    public int $minSelection;

    /**
     * @var Product[]
     */
    public array $products;
}
