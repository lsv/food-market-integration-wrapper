<?php

declare(strict_types=1);

namespace Lsv\FoodMarketIntegration\Response\Order;

class Delivery
{
    public int $id;
    public DeliveryStatus $status;
    public ?string $driver;
    public ?string $deliveryAccountName;
    public ?string $deliveryAccountPhone;
    public PickupAddress $pickupAddress;
    public string $pickupAgreedAt;
    public string $pickupConfirmedAt;
    public DeliveryAddress $deliveryAddress;
    public string $deliveryAgreedAt;
    public string $deliveryConfirmedAt;
    public ?string $deliveryInstructions;
    public ?string $forSenderInstructions;
    public float $linearDistance;
    public ?float $realDistance;
    public ?string $route;
    public int $estimatedDeliveryDuration;
    public ?string $destinationContactEmail;
    public string $destinationContactName;
    public string $destinationContactPhone;
    public string $trackingUrl;
}
