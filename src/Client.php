<?php declare(strict_types=1);
/**
 * Copyright © 2019 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */
namespace MultiSafepay;

use Http\Discovery\Psr17FactoryDiscovery;
use Http\Discovery\Psr18ClientDiscovery;
use MultiSafepay\Exception\ApiException;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\StreamInterface;

class Client
{
    public const LIVE_URL = 'https://api.multisafepay.com/v1/json/';
    public const TEST_URL = 'https://testapi.multisafepay.com/v1/json/';
    public const METHOD_POST = 'POST';

    /** @var string */
    private $apiKey;
    /** @var bool */
    private $isProduction;
    /** @var string */
    private $url;

    /**
     * Client constructor.
     * @param string $apiKey
     * @param bool $isProduction
     */
    public function __construct(string $apiKey, bool $isProduction)
    {
        $this->apiKey = $apiKey;
        $this->isProduction = $isProduction;
        $this->url = $isProduction ? self::LIVE_URL : self::TEST_URL;
    }

    /**
     * @param string $endpoint
     * @param array|null $body
     * @return array
     * @throws \Psr\Http\Client\ClientExceptionInterface
     * @throws ApiException
     */
    public function createPostRequest(string $endpoint, array $body = null): array
    {
        $client = $this->getHttpClient();
        $requestFactory = $this->getRequestFactory();
        $url = $this->getRequestUrl($endpoint);
        $request = $requestFactory->createRequest(self::METHOD_POST, $url)
            ->withBody($this->createBody(json_encode($body)))
            ->withHeader('api_key', $this->apiKey)
            ->withHeader('accept-encoding', 'application/json')
            ->withHeader('Content-Type', 'application/json')
            ->withHeader('Content-Length', strlen(json_encode($body)));

        /** @var ResponseInterface $response */
        $response = $client->sendRequest($request);
        $apiResponse = json_decode($response->getBody()->getContents(), true);

        if (!$apiResponse['success']) {
            throw new ApiException($apiResponse['error_info'], $apiResponse['error_code']);
        }
        return $apiResponse;
    }

    /**
     * Get the ClientInterface
     *
     * @return ClientInterface
     */
    public function getHttpClient(): ClientInterface
    {
        return Psr18ClientDiscovery::find();
    }

    /**
     * Get the request factory
     *
     * @return RequestFactoryInterface
     */
    public function getRequestFactory(): RequestFactoryInterface
    {
        return Psr17FactoryDiscovery::findRequestFactory();
    }

    /**
     * @param string $endpoint
     * @return string
     */
    public function getRequestUrl(string $endpoint): string
    {
        return $this->url . $endpoint;
    }

    /**
     * Create a body used for the Client
     *
     * @param string $body
     * @return StreamInterface
     */
    public function createBody(string $body): StreamInterface
    {
        $stream = Psr17FactoryDiscovery::findStreamFactory();
        return $stream->createStream($body);
    }
}
