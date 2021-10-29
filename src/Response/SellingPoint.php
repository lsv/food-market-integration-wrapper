<?php

declare(strict_types=1);

namespace Lsv\FoodMarketIntegration\Response;

use Lsv\FoodMarketIntegration\Response\SellingPoint\SellingPointAddress;
use Lsv\FoodMarketIntegration\Response\SellingPoint\SellingPointSchedule;
use Lsv\FoodMarketIntegration\Response\SellingPoint\SellingPointTags;

class SellingPoint
{
    public int $id;
    public string $name;
    public SellingPointAddress $address;
    public string $phone;
    public string $email;
    public string $logo;
    public string $mainImage;
    public string $listImage;
    public string $urlKey;
    public string $type;
    public string $timezone;
    public string $description;
    public SellingPointSchedule $schedule;

    /**
     * @var string[]
     */
    public array $allowedOrderTypes;

    /**
     * @var SellingPointTags[]
     */
    public array $tags;
}
