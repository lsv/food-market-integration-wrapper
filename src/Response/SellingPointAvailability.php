<?php

declare(strict_types=1);

namespace Lsv\FoodMarketIntegration\Response;

use Lsv\FoodMarketIntegration\Response\SellingPointAvailability\CollectionServiceAvailability;
use Lsv\FoodMarketIntegration\Response\SellingPointAvailability\DeliveryServiceAvailability;
use Lsv\FoodMarketIntegration\Response\SellingPointAvailability\InsituServiceAvailability;
use Lsv\FoodMarketIntegration\Response\SellingPointAvailability\ReservationServiceAvailability;

class SellingPointAvailability
{
    public DeliveryServiceAvailability $deliveryServiceAvailability;
    public CollectionServiceAvailability $collectionServiceAvailability;
    public InsituServiceAvailability $insituServiceAvailability;
    public ReservationServiceAvailability $reservationServiceAvailability;
}
