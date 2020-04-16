<?php declare(strict_types=1);
/**
 * Copyright © 2019 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay;

use Http\Discovery\Psr17FactoryDiscovery;
use Http\Discovery\Psr18ClientDiscovery;
use MultiSafepay\Api\Base\Response;
use MultiSafepay\Exception\ApiException;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\StreamInterface;

class Client
{
    const LIVE_URL = 'https://api.multisafepay.com/v1/json/';

    const TEST_URL = 'https://testapi.multisafepay.com/v1/json/';

    const METHOD_POST = 'POST';

    const METHOD_GET = 'GET';

    /** @var string */
    private $apiKey;

    /** @var string */
    private $url;

    /**
     * @var string
     */
    private $locale = 'en';

    /** @var ClientInterface */
    protected $httpClient;

    /**
     * Client constructor.
     * @param string $apiKey
     * @param bool $isProduction
     * @param ClientInterface|null $httpClient
     * @param string $locale
     */
    public function __construct(
        string $apiKey,
        bool $isProduction,
        ClientInterface $httpClient = null,
        string $locale = 'en'
    ) {
        $this->apiKey = $apiKey;
        $this->url = $isProduction ? self::LIVE_URL : self::TEST_URL;
        $this->httpClient = $httpClient ?: Psr18ClientDiscovery::find();
        $this->locale = $locale;
    }

    /**
     * @param string $endpoint
     * @param array|null $body
     * @return Response
     * @throws ClientExceptionInterface
     * @throws ApiException
     */
    public function createPostRequest(string $endpoint, array $body = null): Response
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
        return Response::withJson($response->getBody()->getContents());
    }


    /**
     * @param string $endpoint
     * @param array $parameters
     * @return Response
     * @throws ClientExceptionInterface
     * @throws ApiException
     */
    public function createGetRequest(string $endpoint, array $parameters = []): Response
    {
        $url = $this->getRequestUrl($endpoint, $parameters);

        $client = $this->httpClient;
        $requestFactory = $this->getRequestFactory();
        $request = $requestFactory->createRequest(self::METHOD_GET, $url)
            ->withHeader('api_key', $this->apiKey)
            ->withHeader('accept-encoding', 'application/json');

        /** @var ResponseInterface $response */
        $response = $client->sendRequest($request);
        return Response::withJson($response->getBody()->getContents());
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
     * @param array $parameters
     * @return string
     */
    public function getRequestUrl(string $endpoint, $parameters = []): string
    {
        $parameters['locale'] = $this->locale;
        $endpoint .= '?' . http_build_query($parameters);
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
