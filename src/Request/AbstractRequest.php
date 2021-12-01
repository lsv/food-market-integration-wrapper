<?php

declare(strict_types=1);

namespace Lsv\FoodMarketIntegration\Request;

use Lsv\FoodMarketIntegration\Authenticate;
use Lsv\FoodMarketIntegration\Response\ResponseError;
use Nyholm\Psr7\ServerRequest;
use Psr\Http\Client\ClientInterface;
use RuntimeException;
use Symfony\Component\HttpClient\Psr18Client;
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

abstract class AbstractRequest implements Request
{
    private static ?Authenticate $authentication = null;
    private static ?ClientInterface $client = null;
    private static string $baseUri = 'https://api.sinqro.com/market-platform/v1';
    private string $requestUrl = '';

    /**
     * @var array<string, mixed>
     */
    private array $queryData = [];

    /**
     * @var array<string, mixed>
     */
    private array $resolvedQueryData = [];

    /**
     * @var array<string, mixed>
     */
    private array $postData = [];

    /**
     * @var array<string, mixed>
     */
    private array $resolvedPostData = [];

    public static function setAuthentication(Authenticate $authenticate): void
    {
        self::$authentication = $authenticate;
    }

    public static function setHttpClient(ClientInterface $client): void
    {
        self::$client = $client;
    }

    public function getMethod(): string
    {
        return 'GET';
    }

    public function getRequestUrl(): string
    {
        return $this->requestUrl;
    }

    public function getRequestPostData(): ?array
    {
        return $this->getFormData();
    }

    abstract protected function getUrlPath(): string;

    abstract protected function handleResponse(string $content): mixed;

    abstract protected function resolveQueryData(OptionsResolver $resolver): void;

    protected function resolvePostData(OptionsResolver $resolver): void
    {
    }

    /**
     * @return array<string, mixed>|null
     */
    protected function getQueryPath(): ?array
    {
        return null;
    }

    /**
     * @return array<string, mixed>|null
     */
    protected function getFormData(): ?array
    {
        return null;
    }

    protected function addQueryData(string $key, mixed $value): void
    {
        $this->queryData[$key] = $value;
    }

    protected function getQueryData(string $key): mixed
    {
        return $this->resolvedQueryData[$key] ?? null;
    }

    protected function addPostData(string $key, mixed $value): void
    {
        $this->postData[$key] = $value;
    }

    protected function getPostData(string $key): mixed
    {
        return $this->resolvedPostData[$key] ?? null;
    }

    protected function doRequest(): mixed
    {
        $queryDataResolver = new OptionsResolver();
        $this->resolveQueryData($queryDataResolver);
        $this->resolvedQueryData = $queryDataResolver->resolve($this->queryData);

        $postDataResolver = new OptionsResolver();
        $this->resolvePostData($postDataResolver);
        $this->resolvedPostData = $postDataResolver->resolve($this->postData);

        $request = new ServerRequest(
            $this->getMethod(),
            $this->url(),
            $this->getHeaders(),
            $this->getFormData() ? json_encode($this->getFormData(), JSON_THROW_ON_ERROR) : null
        );

        $response = $this->getClient()->sendRequest($request);
        if (in_array($response->getStatusCode(), [400, 404])) {
            return $this->getSerializer()->deserialize(
                $response->getBody(),
                ResponseError::class,
                'json'
            );
        }

        $content = (string) $response->getBody();

        return $this->handleResponse($content);
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

    private function requestUrl(): string
    {
        $url = $this->getUrlPath();
        if ($query = $this->getQueryPath()) {
            $url .= '?'.http_build_query($query);
        }

        return $this->requestUrl = $url;
    }

    /**
     * @codeCoverageIgnore
     */
    private function getClient(): ClientInterface
    {
        if (null === self::$authentication) {
            throw new RuntimeException('You need to authenticate before running');
        }

        if (null === self::$client) {
            self::$client = new Psr18Client();
        }

        return self::$client;
    }

    /**
     * @return array<string, string|null>
     * @noinspection PhpDocSignatureInspection
     */
    private function getHeaders(): array
    {
        return [
            'x-api-server-access-token' => self::$authentication?->getServerAccessToken(),
            'x-api-user-access-token' => self::$authentication?->getUserAccessToken(),
        ];
    }

    private function url(): string
    {
        return sprintf('%s%s', self::$baseUri, $this->requestUrl());
    }
}
