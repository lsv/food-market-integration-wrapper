<?php

declare(strict_types=1);

namespace Lsv\FoodMarketIntegration\Response\Order;

class OrderLine
{
    public string $type;
    public float $totalAmount;
    public float $unitPrice;
    public float|int $quantity;
    public string $label;
    public ?string $comment;
    /**
     * @var OrderLine[]
     */
    public array $childrenOrderLines;
    public float $baseAmount;
    public float $vatAmount;
    public float $vatValue;
    public ProductOption $productOption;
}
