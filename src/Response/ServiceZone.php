<?php

declare(strict_types=1);

namespace Lsv\FoodMarketIntegration\Response;

use Lsv\FoodMarketIntegration\Response\ServiceZone\ServiceLocation;

class ServiceZone
{
    public string $code;
    public string $name;
    /** @var ServiceLocation[] */
    public array $serviceLocations;
}
