<?php

declare(strict_types=1);

namespace Lsv\FoodMarketIntegration\Model\Order;

class OrderLine
{
    /**
     * @param ChildOrderLine[] $childrenOrderLines
     */
    public function __construct(
        public string $type,
        public float $totalAmount,
        public float $unitAdditionalAmount,
        public float $unitFinalAmount,
        public float $unitAmount,
        public int $quantity,
        public string $label,
        public string $comment,
        public float $baseAmount,
        public float $vatAmount,
        public float $vatValue,
        public array $childrenOrderLines,
        public Product $product
    ) {
    }
}
