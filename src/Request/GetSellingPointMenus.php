<?php

declare(strict_types=1);

namespace Lsv\FoodMarketIntegration\Request;

use Lsv\FoodMarketIntegration\Response\Error;
use Lsv\FoodMarketIntegration\Response\Menu;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GetSellingPointMenus extends Request
{
    private const MARKET_CODE_IDENTIFIER = 'marketCode';
    private const MARKET_SELLING_POINT = 'sellingCode';

    public function __construct(string $marketCodeIdentifier, int $sellingPointId)
    {
        $this->queryData[self::MARKET_CODE_IDENTIFIER] = $marketCodeIdentifier;
        $this->queryData[self::MARKET_SELLING_POINT] = $sellingPointId;
    }

    /**
     * @return Error|Menu[]
     */
    public function request(): Error|array
    {
        return $this->doRequest();
    }

    protected function getUrl(array $queryData): string
    {
        return sprintf(
            '/markets/%s/sellingPoints/%d/menus',
            $this->queryData[self::MARKET_CODE_IDENTIFIER],
            $this->queryData[self::MARKET_SELLING_POINT]
        );
    }

    protected function queryData(OptionsResolver $resolver): void
    {
        $resolver->setRequired([self::MARKET_CODE_IDENTIFIER, self::MARKET_SELLING_POINT]);
    }

    /**
     * @return Menu[]
     */
    protected function handleResponse(string $content): array
    {
        return $this->getSerializer()
            ->deserialize($content, Menu::class.'[]', 'json');
    }
}
