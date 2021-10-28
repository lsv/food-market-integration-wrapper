<?php

declare(strict_types=1);

namespace Lsv\FoodMarketIntegration\Request;

use Lsv\FoodMarketIntegration\Authenticate;
use RuntimeException;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\PropertyInfo\Extractor\PhpDocExtractor;
use Symfony\Component\PropertyInfo\Extractor\ReflectionExtractor;
use Symfony\Component\PropertyInfo\PropertyInfoExtractor;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

abstract class Request
{
    private static ?Authenticate $authentication = null;
    private static ?HttpClientInterface $client = null;
    private static string $baseUri = 'https://api.sinqro.com/market-platform/v1';
    private string $requestUrl = '';

    /**
     * @var array<string, mixed>
     */
    protected array $queryData = [];

    public static function setAuthentication(Authenticate $authenticate): void
    {
        self::$authentication = $authenticate;
    }

    public static function setHttpClient(HttpClientInterface $client): void
    {
        self::$client = $client;
    }

    public function getMethod(): string
    {
        return 'GET';
    }

    /**
     * @param array<string, mixed> $queryData
     */
    abstract protected function getUrl(array $queryData): string;

    abstract protected function queryData(OptionsResolver $resolver): void;

    abstract protected function handleResponse(ResponseInterface $response): mixed;

    abstract public function request(): mixed;

    protected function doRequest(): mixed
    {
        $queryDataResolver = new OptionsResolver();
        $this->queryData($queryDataResolver);
        $queryData = $queryDataResolver->resolve($this->queryData);

        return $this->handleResponse(
            $this->getClient()->request(
                $this->getMethod(),
                $this->requestUrl($queryData)
            )
        );
    }

    protected function getSerializer(): SerializerInterface
    {
        $reflectionExtractor = new ReflectionExtractor();
        $phpDocExtractor = new PhpDocExtractor();

        $propertyTypeExtractor = new PropertyInfoExtractor(
            [$reflectionExtractor],
            [$phpDocExtractor, $reflectionExtractor],
            [$phpDocExtractor],
            [$reflectionExtractor],
            [$reflectionExtractor]
        );

        $normalizers = [
            new ArrayDenormalizer(),
            new DateTimeNormalizer(),
            new ObjectNormalizer(propertyTypeExtractor: $propertyTypeExtractor),
        ];

        $encoders = [
            new JsonEncoder(),
        ];

        return new Serializer($normalizers, $encoders);
    }

    public function getRequestUrl(): string
    {
        return $this->requestUrl;
    }

    /**
     * @param array<string, mixed> $queryData
     */
    private function requestUrl(array $queryData): string
    {
        return $this->requestUrl = $this->getUrl($queryData);
    }

    /**
     * @codeCoverageIgnore
     */
    private function getClient(): HttpClientInterface
    {
        if (null === self::$authentication) {
            throw new RuntimeException('You need to authenticate before running');
        }

        if (null === self::$client) {
            self::$client = HttpClient::create([
                'base_uri' => self::$baseUri,
                'headers' => [
                    'x-api-server-access-token' => self::$authentication->getServerAccessToken(),
                    'x-api-user-access-token' => self::$authentication->getUserAccessToken(),
                ],
            ]);
        }

        return self::$client;
    }
}
