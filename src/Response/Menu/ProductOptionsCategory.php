<?php

declare(strict_types=1);

namespace Lsv\FoodMarketIntegration\Response\Menu;

class ProductOptionsCategory
{
    public int $id;
    public ?string $externalId;
    public string $name;
    public ?string $shortDescription;
    public int $position;
    public ?int $maxSelection;
    public ?int $maxSameOptionSelection;
    public string $selectionLabel;

    /**
     * @var ProductOption[]
     */
    public array $productOptions;
}
