<?php

declare(strict_types=1);

namespace Lsv\FoodMarketIntegration\Request;

interface Request
{
    public function getMethod(): string;

    public function request(): mixed;

    public function getRequestUrl(): string;

    /**
     * @return array<string, mixed>|null
     */
    public function getRequestPostData(): ?array;
}
