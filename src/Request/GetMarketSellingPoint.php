<?php

declare(strict_types=1);

namespace Lsv\FoodMarketIntegration\Request;

use Lsv\FoodMarketIntegration\Response\Error;
use Lsv\FoodMarketIntegration\Response\SellingPoint;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GetMarketSellingPoint extends Request
{
    private const MARKET_CODE_IDENTIFIER = 'marketCode';
    private const MARKET_SELLING_POINT = 'sellingCode';

    public function __construct(string $marketCodeIdentifier, int $sellingPointId)
    {
        $this->queryData[self::MARKET_CODE_IDENTIFIER] = $marketCodeIdentifier;
        $this->queryData[self::MARKET_SELLING_POINT] = $sellingPointId;
    }

    protected function getUrl(array $queryData): string
    {
        return sprintf(
            '/markets/%s/sellingPoints/%s',
            $queryData[self::MARKET_CODE_IDENTIFIER],
            $queryData[self::MARKET_SELLING_POINT]
        );
    }

    protected function queryData(OptionsResolver $resolver): void
    {
        $resolver->setRequired([self::MARKET_CODE_IDENTIFIER, self::MARKET_SELLING_POINT]);
    }

    protected function handleResponse(string $content): SellingPoint
    {
        return $this->getSerializer()
            ->deserialize($content, SellingPoint::class, 'json');
    }

    public function request(): Error|SellingPoint
    {
        return $this->doRequest();
    }
}
