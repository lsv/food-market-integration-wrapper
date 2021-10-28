<?php

declare(strict_types=1);

namespace Lsv\FoodMarketIntegration\Request;

use Lsv\FoodMarketIntegration\Model\RequestTags;
use Lsv\FoodMarketIntegration\Response\SellingPoint;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Contracts\HttpClient\ResponseInterface;

class GetMarketSellingPoints extends Request
{
    private const MARKET_CODE_IDENTIFIER = 'marketCodeIdentifier';
    private const REQUEST_TAGS = 'tags';

    public function __construct(string $marketCodeIdentifier)
    {
        $this->queryData[self::MARKET_CODE_IDENTIFIER] = $marketCodeIdentifier;
    }

    public function setRequestTags(RequestTags $requestTags): self
    {
        $this->queryData[self::REQUEST_TAGS] = $requestTags;

        return $this;
    }

    protected function queryData(OptionsResolver $resolver): void
    {
        $resolver->setRequired([self::MARKET_CODE_IDENTIFIER]);
        $resolver->setAllowedTypes(self::MARKET_CODE_IDENTIFIER, 'string');

        $resolver->setDefined([self::REQUEST_TAGS]);
        $resolver->setAllowedTypes(self::REQUEST_TAGS, RequestTags::class);
    }

    /**
     * @param array<string, mixed> $queryData
     */
    protected function getUrl(array $queryData): string
    {
        $url = sprintf(
            '/markets/%s/sellingPoints',
            $queryData[self::MARKET_CODE_IDENTIFIER]
        );

        if (isset($queryData[self::REQUEST_TAGS]) && $queryData[self::REQUEST_TAGS]) {
            /** @var RequestTags $requestTags */
            $requestTags = $queryData[self::REQUEST_TAGS];
            $data = [];
            foreach ($requestTags->getTags() as $tag) {
                $data['tags'][] = [
                    'code' => $tag['code'],
                    'value' => $tag['value'],
                ];
            }

            $url .= '?'.http_build_query($data);
        }

        return $url;
    }

    /**
     * @return array<SellingPoint>
     */
    protected function handleResponse(ResponseInterface $response): array
    {
        return $this->getSerializer()
            ->deserialize($response->getContent(true), SellingPoint::class.'[]', 'json');
    }

    /**
     * @return array<SellingPoint>
     */
    public function request(): array
    {
        return $this->doRequest();
    }
}
