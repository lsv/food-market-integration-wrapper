<?php

declare(strict_types=1);

namespace Lsv\FoodMarketIntegration;

class Authenticate
{
    public function __construct(private string $userAccessToken, private string $serverAccessToken)
    {
    }

    public function getUserAccessToken(): string
    {
        return $this->userAccessToken;
    }

    public function getServerAccessToken(): string
    {
        return $this->serverAccessToken;
    }
}
