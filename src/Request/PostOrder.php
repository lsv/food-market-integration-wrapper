<?php

declare(strict_types=1);

namespace Lsv\FoodMarketIntegration\Request;

use Lsv\FoodMarketIntegration\Model\PostOrderInterface;
use Lsv\FoodMarketIntegration\Response\Order;
use Lsv\FoodMarketIntegration\Response\ResponseError;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PostOrder extends AbstractRequest
{
    private const MARKET_CODE_IDENTIFIER = 'marketCode';
    private const ORDER = 'order';

    public function __construct(string $marketCodeIdentifier, PostOrderInterface $order)
    {
        $this->addQueryData(self::MARKET_CODE_IDENTIFIER, $marketCodeIdentifier);
        $this->addPostData(self::ORDER, $order);
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
            '/markets/%s/orders',
            $this->getQueryData(self::MARKET_CODE_IDENTIFIER)
        );
    }

    protected function resolveQueryData(OptionsResolver $resolver): void
    {
        $resolver->setRequired([self::MARKET_CODE_IDENTIFIER]);
    }

    protected function resolvePostData(OptionsResolver $resolver): void
    {
        $resolver->setRequired([self::ORDER]);
        $resolver->setAllowedTypes(self::ORDER, PostOrderInterface::class);
    }

    protected function getFormData(): ?array
    {
        $serialized = $this->getSerializer()->serialize($this->getPostData(self::ORDER), 'json');

        return json_decode($serialized, true, 512, JSON_THROW_ON_ERROR);
    }

    protected function handleResponse(string $content): Order
    {
        return $this->getSerializer()->deserialize($content, Order::class, 'json');
    }
}
