<?php

declare(strict_types=1);

namespace Lsv\FoodMarketIntegration\Request;

use Lsv\FoodMarketIntegration\Response\Order;
use Lsv\FoodMarketIntegration\Response\ResponseError;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CancelOrder extends AbstractRequest
{
    private const MARKET_CODE_IDENTIFIER = 'marketCode';
    private const MARKET_ORDER_IDENTIFIER = 'marketOrder';
    private const COMMENT = 'comment';

    public function __construct(string $marketCodeIdentifier, string $marketOrderIdentifier, string $comment)
    {
        $this->addQueryData(self::MARKET_CODE_IDENTIFIER, $marketCodeIdentifier);
        $this->addQueryData(self::MARKET_ORDER_IDENTIFIER, $marketOrderIdentifier);
        $this->addPostData(self::COMMENT, $comment);
    }

    public function getMethod(): string
    {
        return 'POST';
    }

    public function request(): ResponseError|Order
    {
        return $this->doRequest();
    }

    protected function getUrlPath(): string
    {
        return sprintf(
            '/markets/%s/orders/%s/cancel',
            $this->getQueryData(self::MARKET_CODE_IDENTIFIER),
            $this->getQueryData(self::MARKET_ORDER_IDENTIFIER)
        );
    }

    protected function resolveQueryData(OptionsResolver $resolver): void
    {
        $resolver->setRequired([self::MARKET_CODE_IDENTIFIER, self::MARKET_ORDER_IDENTIFIER]);
    }

    protected function getFormData(): ?array
    {
        return [
            'comment' => $this->getPostData(self::COMMENT),
        ];
    }

    protected function resolvePostData(OptionsResolver $resolver): void
    {
        $resolver->setRequired([self::COMMENT]);
    }

    protected function handleResponse(string $content): Order
    {
        return $this->getSerializer()->deserialize($content, Order::class, 'json');
    }
}
