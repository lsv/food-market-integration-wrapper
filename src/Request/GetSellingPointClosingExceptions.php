<?php

declare(strict_types=1);

namespace Lsv\FoodMarketIntegration\Request;

use Lsv\FoodMarketIntegration\Response\ResponseError;
use Lsv\FoodMarketIntegrationTest\Request\SellingPointException;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GetSellingPointClosingExceptions extends AbstractRequest
{
    private const MARKET_CODE_IDENTIFIER = 'marketCode';
    private const MARKET_SELLING_POINT = 'sellingCode';

    public function __construct(string $marketCodeIdentifier, int $sellingPointId)
    {
        $this->addQueryData(self::MARKET_CODE_IDENTIFIER, $marketCodeIdentifier);
        $this->addQueryData(self::MARKET_SELLING_POINT, $sellingPointId);
    }

    protected function getUrlPath(): string
    {
        return sprintf(
            '/markets/%s/sellingPoints/%d/exceptions/next',
            $this->getQueryData(self::MARKET_CODE_IDENTIFIER),
            $this->getQueryData(self::MARKET_SELLING_POINT)
        );
    }

    protected function getUrlQuery(): array
    {
        return [];
    }

    protected function resolveQueryData(OptionsResolver $resolver): void
    {
        $resolver->setRequired([self::MARKET_CODE_IDENTIFIER, self::MARKET_SELLING_POINT]);
    }

    /**
     * @return SellingPointException[]
     */
    protected function handleResponse(string $content): array
    {
        return $this->getSerializer()->deserialize($content, SellingPointException::class.'[]', 'json');
    }

    /**
     * @return ResponseError|SellingPointException[]
     */
    public function request(): ResponseError|array
    {
        return $this->doRequest();
    }
}
