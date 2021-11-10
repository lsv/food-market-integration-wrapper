<?php

declare(strict_types=1);

namespace Lsv\FoodMarketIntegration\Request;

use Lsv\FoodMarketIntegration\Model\RequestTags;
use Lsv\FoodMarketIntegration\Response\ResponseError;
use Lsv\FoodMarketIntegration\Response\SellingPoint;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GetMarketSellingPoints extends AbstractRequest
{
    private const MARKET_CODE_IDENTIFIER = 'marketCodeIdentifier';
    private const REQUEST_TAGS = 'tags';

    public function __construct(string $marketCodeIdentifier)
    {
        $this->addQueryData(self::MARKET_CODE_IDENTIFIER, $marketCodeIdentifier);
    }

    public function setRequestTags(RequestTags $requestTags): void
    {
        $this->addQueryData(self::REQUEST_TAGS, $requestTags);
    }

    /**
     * @return ResponseError|array<SellingPoint>
     */
    public function request(): ResponseError|array
    {
        return $this->doRequest();
    }

    protected function resolveQueryData(OptionsResolver $resolver): void
    {
        $resolver->setRequired([self::MARKET_CODE_IDENTIFIER]);
        $resolver->setAllowedTypes(self::MARKET_CODE_IDENTIFIER, 'string');

        $resolver->setDefined([self::REQUEST_TAGS]);
        $resolver->setAllowedTypes(self::REQUEST_TAGS, RequestTags::class);
    }

    protected function getUrlPath(): string
    {
        return sprintf(
            '/markets/%s/sellingPoints',
            $this->getQueryData(self::MARKET_CODE_IDENTIFIER)
        );
    }

    /**
     * @return array<string, mixed>
     */
    protected function getQueryPath(): array
    {
        $data = [];

        /** @var RequestTags $requestTags */
        $requestTags = $this->getQueryData(self::REQUEST_TAGS);
        if (null !== $requestTags) {
            foreach ($requestTags->getTags() as $tag) {
                $data['tags'][] = [
                    'code' => $tag->code,
                    'value' => $tag->value,
                ];
            }
        }

        return $data;
    }

    /**
     * @return array<SellingPoint>
     */
    protected function handleResponse(string $content): array
    {
        return $this->getSerializer()
            ->deserialize($content, SellingPoint::class.'[]', 'json');
    }
}
