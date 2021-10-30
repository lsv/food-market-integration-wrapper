<?php

declare(strict_types=1);

namespace Lsv\FoodMarketIntegration\Model\Order;

class Delivery
{
    public function __construct(public DeliveryAddress $deliveryAddress)
    {
    }
}
