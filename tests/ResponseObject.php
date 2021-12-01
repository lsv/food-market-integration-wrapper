<?php

declare(strict_types=1);

namespace Lsv\FoodMarketIntegrationTest;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class ResponseObject implements ResponseInterface
{
    private string $body;
    private int $httpCode;

    public function __construct(string $body, array $options = [])
    {
        $this->body = $body;
        $this->httpCode = $options['http_code'] ?? 200;
    }

    public function getProtocolVersion(): void
    {
    }

    public function withProtocolVersion($version): void
    {
    }

    public function getHeaders(): void
    {
    }

    public function hasHeader($name): void
    {
    }

    public function getHeader($name): void
    {
    }

    public function getHeaderLine($name): void
    {
    }

    public function withHeader($name, $value): void
    {
    }

    public function withAddedHeader($name, $value): void
    {
    }

    public function withoutHeader($name): void
    {
    }

    public function getBody(): string
    {
        return $this->body;
    }

    public function withBody(StreamInterface $body): void
    {
    }

    public function getStatusCode()
    {
        return $this->httpCode;
    }

    public function withStatus($code, $reasonPhrase = ''): void
    {
    }

    public function getReasonPhrase(): void
    {
    }
}
