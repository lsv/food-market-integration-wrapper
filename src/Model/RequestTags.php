<?php

declare(strict_types=1);

namespace Lsv\FoodMarketIntegration\Model;

class RequestTags
{
    /**
     * @var array[]
     */
    private array $tags = [];

    public function addTag(string $code, string $value): void
    {
        $this->tags[] = ['code' => $code, 'value' => $value];
    }

    /**
     * @return array[]
     */
    public function getTags(): array
    {
        return $this->tags;
    }
}
