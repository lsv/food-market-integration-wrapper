<?php

declare(strict_types=1);

namespace Lsv\FoodMarketIntegration\Response;

class Error
{
    /**
     * @var Error\Error[]
     */
    public array $errors;
    public string $code;
    public string $message;
    public string $httpResponseCode;
}
