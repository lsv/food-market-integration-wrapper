<?php

declare(strict_types=1);

namespace Lsv\FoodMarketIntegration\Response\Order;

class DeliveryAddress
{
    public int $id;
    public string $street;
    public ?string $details;
    public string $city;
    public string $province;
    public string $postalCode;
    public float $latitude;
    public float $longitude;
    public string $googlePlaceId;
    public string $placeName;
    public bool $autoGeolocated;
}
