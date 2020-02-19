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
    public const METHOD_GET = 'GET';

    /** @var string */
    private $apiKey;
    /** @var string */
    private $url;
    private $httpClient;

    /**
     * Client constructor.
     * @param string $apiKey
     * @param bool $isProduction
     * @param ClientInterface|null $httpClient
     */
    public function __construct(string $apiKey, bool $isProduction, ClientInterface $httpClient = null)
    {
        $this->apiKey = $apiKey;
        $this->url = $isProduction ? self::LIVE_URL : self::TEST_URL;
        $this->httpClient = $httpClient ?: Psr18ClientDiscovery::find();
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
        $client = $this->httpClient;
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
     * @param string $endpoint
     * @param array|null $query
     * @return array
     * @throws \Psr\Http\Client\ClientExceptionInterface
     * @throws ApiException
     */
    public function createGetRequest(string $endpoint, array $options = []): array
    {
        $options = http_build_query($options, '', '&amp;');
        $endpoint .= $options ? "?$options" : '';
        $url = $this->getRequestUrl($endpoint);

        $client = $this->httpClient;
        $requestFactory = $this->getRequestFactory();
        $request = $requestFactory->createRequest(self::METHOD_GET, $url)
            ->withHeader('api_key', $this->apiKey)
            ->withHeader('accept-encoding', 'application/json');

        /** @var ResponseInterface $response */
        $response = $client->sendRequest($request);
        $apiResponse = json_decode($response->getBody()->getContents(), true);

        if (!$apiResponse['success']) {
            throw new ApiException($apiResponse['error_info'], $apiResponse['error_code']);
        }
        return $apiResponse;
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
