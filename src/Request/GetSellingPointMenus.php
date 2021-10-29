<?php

declare(strict_types=1);

namespace Lsv\FoodMarketIntegration\Request;

use Lsv\FoodMarketIntegration\Response\Menu;
use Lsv\FoodMarketIntegration\Response\ResponseError;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GetSellingPointMenus extends AbstractRequest
{
    private const MARKET_CODE_IDENTIFIER = 'marketCode';
    private const MARKET_SELLING_POINT = 'sellingCode';
    private const DATE = 'date';
    private const ORDER_TYPE = 'order_type';

    public function __construct(string $marketCodeIdentifier, int $sellingPointId)
    {
        $this->addQueryData(self::MARKET_CODE_IDENTIFIER, $marketCodeIdentifier);
        $this->addQueryData(self::MARKET_SELLING_POINT, $sellingPointId);
    }

    public function setDate(\DateTimeInterface $dateTime): void
    {
        $this->addQueryData(self::DATE, $dateTime);
    }

    public function setOrderType(string $orderType): void
    {
        $this->addQueryData(self::ORDER_TYPE, $orderType);
    }

    /**
     * @return ResponseError|Menu[]
     */
    public function request(): ResponseError|array
    {
        return $this->doRequest();
    }

    protected function getUrlPath(): string
    {
        return sprintf(
            '/markets/%s/sellingPoints/%d/menus',
            $this->getQueryData(self::MARKET_CODE_IDENTIFIER),
            $this->getQueryData(self::MARKET_SELLING_POINT)
        );
    }

    protected function getUrlQuery(): array
    {
        $data = [];

        if ($date = $this->getQueryData(self::DATE)) {
            $data['date'] = $date->format('Y-m-d');
        }

        if ($order = $this->getQueryData(self::ORDER_TYPE)) {
            $data['orderType'] = $order;
        }

        return $data;
    }

    protected function resolveQueryData(OptionsResolver $resolver): void
    {
        $resolver->setRequired([self::MARKET_CODE_IDENTIFIER, self::MARKET_SELLING_POINT]);

        $resolver->setDefined([self::DATE, self::ORDER_TYPE]);
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
