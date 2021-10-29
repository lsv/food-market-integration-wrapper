<?php

declare(strict_types=1);

namespace Lsv\FoodMarketIntegration\Request;

use Lsv\FoodMarketIntegration\Response\OrderStatus;
use Lsv\FoodMarketIntegration\Response\ResponseError;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GetOrderStatus extends AbstractRequest
{
    private const MARKET_CODE_IDENTIFIER = 'marketCode';
    private const MARKET_ORDER_IDENTIFIER = 'marketOrder';

    public function __construct(string $marketCodeIdentifier, string $marketOrderIdentifier)
    {
        $this->addQueryData(self::MARKET_CODE_IDENTIFIER, $marketCodeIdentifier);
        $this->addQueryData(self::MARKET_ORDER_IDENTIFIER, $marketOrderIdentifier);
    }

    protected function getUrlPath(): string
    {
        return sprintf(
            '/markets/%s/orders/%s/status',
            $this->getQueryData(self::MARKET_CODE_IDENTIFIER),
            $this->getQueryData(self::MARKET_ORDER_IDENTIFIER)
        );
    }

    protected function getUrlQuery(): array
    {
        return [];
    }

    protected function resolveQueryData(OptionsResolver $resolver): void
    {
        $resolver->setRequired([self::MARKET_CODE_IDENTIFIER, self::MARKET_ORDER_IDENTIFIER]);
    }

    protected function handleResponse(string $content): OrderStatus
    {
        return $this->getSerializer()->deserialize($content, OrderStatus::class, 'json');
    }

    public function request(): ResponseError|OrderStatus
    {
        return $this->doRequest();
    }
}
