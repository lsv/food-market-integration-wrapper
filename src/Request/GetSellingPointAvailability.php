<?php

declare(strict_types=1);

namespace Lsv\FoodMarketIntegration\Request;

use Lsv\FoodMarketIntegration\Response\Error;
use Lsv\FoodMarketIntegration\Response\SellingPointAvailability;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GetSellingPointAvailability extends Request
{
    private const MARKET_CODE_IDENTIFIER = 'marketCode';
    private const MARKET_SELLING_POINT = 'sellingCode';
    private const DATE = 'date';

    public function __construct(string $marketCodeIdentifier, int $sellingPointId)
    {
        $this->queryData[self::MARKET_CODE_IDENTIFIER] = $marketCodeIdentifier;
        $this->queryData[self::MARKET_SELLING_POINT] = $sellingPointId;
    }

    public function setDate(\DateTimeInterface $dateTime): void
    {
        $this->queryData[self::DATE] = $dateTime;
    }

    protected function getUrl(array $queryData): string
    {
        $url = sprintf(
            '/markets/%s/sellingPoints/%s/availability',
            $queryData[self::MARKET_CODE_IDENTIFIER],
            $queryData[self::MARKET_SELLING_POINT]
        );

        if (isset($this->queryData[self::DATE])) {
            $url .= '?'.http_build_query(['date' => $this->queryData[self::DATE]->format('Y-m-d')]);
        }

        return $url;
    }

    protected function queryData(OptionsResolver $resolver): void
    {
        $resolver->setRequired([self::MARKET_CODE_IDENTIFIER, self::MARKET_SELLING_POINT]);
        $resolver->setDefined([self::DATE]);
    }

    protected function handleResponse(string $content): SellingPointAvailability
    {
        return $this->getSerializer()
            ->deserialize($content, SellingPointAvailability::class, 'json');
    }

    public function request(): Error|SellingPointAvailability
    {
        return $this->doRequest();
    }
}
