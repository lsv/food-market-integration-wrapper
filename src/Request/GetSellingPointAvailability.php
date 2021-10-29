<?php

declare(strict_types=1);

namespace Lsv\FoodMarketIntegration\Request;

use DateTimeInterface;
use Lsv\FoodMarketIntegration\Response\ResponseError;
use Lsv\FoodMarketIntegration\Response\SellingPointAvailability;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GetSellingPointAvailability extends AbstractRequest
{
    private const MARKET_CODE_IDENTIFIER = 'marketCode';
    private const MARKET_SELLING_POINT = 'sellingCode';
    private const DATE = 'date';

    public function __construct(string $marketCodeIdentifier, int $sellingPointId)
    {
        $this->addQueryData(self::MARKET_CODE_IDENTIFIER, $marketCodeIdentifier);
        $this->addQueryData(self::MARKET_SELLING_POINT, $sellingPointId);
    }

    public function setDate(DateTimeInterface $dateTime): void
    {
        $this->addQueryData(self::DATE, $dateTime);
    }

    protected function getUrlPath(): string
    {
        return sprintf(
            '/markets/%s/sellingPoints/%s/availability',
            $this->getQueryData(self::MARKET_CODE_IDENTIFIER),
            $this->getQueryData(self::MARKET_SELLING_POINT)
        );
    }

    protected function getUrlQuery(): array
    {
        $data = [];
        if ($date = $this->getQueryData(self::DATE)) {
            /* @var DateTimeInterface $date */
            $data['date'] = $date->format('Y-m-d');
        }

        return $data;
    }

    protected function resolveQueryData(OptionsResolver $resolver): void
    {
        $resolver->setRequired([self::MARKET_CODE_IDENTIFIER, self::MARKET_SELLING_POINT]);
        $resolver->setDefined([self::DATE]);
    }

    protected function handleResponse(string $content): SellingPointAvailability
    {
        return $this->getSerializer()
            ->deserialize($content, SellingPointAvailability::class, 'json');
    }

    public function request(): ResponseError|SellingPointAvailability
    {
        return $this->doRequest();
    }
}
