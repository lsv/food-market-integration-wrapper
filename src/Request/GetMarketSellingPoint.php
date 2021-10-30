<?php

declare(strict_types=1);

namespace Lsv\FoodMarketIntegration\Request;

use Lsv\FoodMarketIntegration\Response\ResponseError;
use Lsv\FoodMarketIntegration\Response\SellingPoint;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GetMarketSellingPoint extends AbstractRequest
{
    private const MARKET_CODE_IDENTIFIER = 'marketCode';
    private const MARKET_SELLING_POINT = 'sellingCode';

    public function __construct(string $marketCodeIdentifier, int $sellingPointId)
    {
        $this->addQueryData(self::MARKET_CODE_IDENTIFIER, $marketCodeIdentifier);
        $this->addQueryData(self::MARKET_SELLING_POINT, $sellingPointId);
    }

    public function request(): ResponseError|SellingPoint
    {
        return $this->doRequest();
    }

    protected function getUrlPath(): string
    {
        return sprintf(
            '/markets/%s/sellingPoints/%s',
            $this->getQueryData(self::MARKET_CODE_IDENTIFIER),
            $this->getQueryData(self::MARKET_SELLING_POINT)
        );
    }

    protected function resolveQueryData(OptionsResolver $resolver): void
    {
        $resolver->setRequired([self::MARKET_CODE_IDENTIFIER, self::MARKET_SELLING_POINT]);
    }

    protected function handleResponse(string $content): SellingPoint
    {
        return $this->getSerializer()
            ->deserialize($content, SellingPoint::class, 'json');
    }
}
