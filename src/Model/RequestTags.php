<?php

declare(strict_types=1);

namespace Lsv\FoodMarketIntegration\Model;

use Lsv\FoodMarketIntegration\Model\RequestTags\Tag;

class RequestTags
{
    /**
     * @var Tag[]
     */
    private array $tags = [];

    public function addTag(string $code, string $value): void
    {
        $this->tags[] = new Tag($code, $value);
    }

    /**
     * @return Tag[]
     */
    public function getTags(): array
    {
        return $this->tags;
    }
}
