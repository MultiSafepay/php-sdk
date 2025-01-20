<?php declare(strict_types=1);
/**
 * Copyright © MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Client;

use Http\Discovery\Psr17FactoryDiscovery;
use Http\Discovery\Psr18ClientDiscovery;
use MultiSafepay\Api\Base\RequestBodyInterface;
use MultiSafepay\Api\Base\Response as ApiResponse;
use MultiSafepay\Exception\ApiException;
use MultiSafepay\Exception\ApiUnavailableException;
use MultiSafepay\Exception\InvalidApiKeyException;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\StreamInterface;

/**
 * Class Client
 * @package MultiSafepay
 * phpcs:disable ObjectCalisthenics.Metrics.MethodPerClassLimit
 * phpcs:disable ObjectCalisthenics.Files.ClassTraitAndInterfaceLength
 */
class Client
{
    public const LIVE_URL = 'https://api.multisafepay.com/v1/';
    public const TEST_URL = 'https://testapi.multisafepay.com/v1/';
    public const METHOD_POST = 'POST';
    public const METHOD_GET = 'GET';
    public const METHOD_PATCH = 'PATCH';
    public const METHOD_DELETE = 'DELETE';

    /**
     * @var ApiKey
     */
    private $apiKey;

    /**
     * @var string
     */
    private $url;

    /**
     * @var ClientInterface
     */
    protected $httpClient;

    /**
     * @var RequestFactoryInterface|null
     */
    private $requestFactory;

    /**
     * @var StreamFactoryInterface|null
     */
    private $streamFactory;

    /**
     * @var string
     */
    private $locale = 'en_US';

    /**
     * @var bool
     */
    private $strictMode;

    /**
     * Client constructor.
     * @param string $apiKey
     * @param bool $isProduction
     * @param ClientInterface|null $httpClient
     * @param RequestFactoryInterface|null $requestFactory
     * @param StreamFactoryInterface|null $streamFactory
     * @param string $locale
     * @param bool $strictMode
     * @throws InvalidApiKeyException
     */
    public function __construct(
        string $apiKey,
        bool $isProduction,
        ?ClientInterface $httpClient = null,
        ?RequestFactoryInterface $requestFactory = null,
        ?StreamFactoryInterface $streamFactory = null,
        string $locale = 'en_US',
        bool $strictMode = false
    ) {
        $this->apiKey = new ApiKey($apiKey);
        $this->url = $isProduction ? self::LIVE_URL : self::TEST_URL;
        $this->httpClient = $httpClient ?: Psr18ClientDiscovery::find();
        $this->requestFactory = $requestFactory;
        $this->streamFactory = $streamFactory ?: Psr17FactoryDiscovery::findStreamFactory();
        $this->locale = $locale;
        $this->strictMode = $strictMode;
    }

    /**
     * @param string $endpoint
     * @param RequestBodyInterface|null $requestBody
     * @param array $context
     * @return ApiResponse
     * @throws ClientExceptionInterface|ApiException|ApiUnavailableException
     */
    public function createPostRequest(
        string $endpoint,
        ?RequestBodyInterface $requestBody = null,
        array $context = []
    ): ApiResponse {
        $request = $this->createRequest($endpoint, self::METHOD_POST)
            ->withBody($this->createBody($this->getRequestBody($requestBody)))
            ->withHeader('Content-Length', strlen($this->getRequestBody($requestBody)));
        $httpResponse = $this->httpClient->sendRequest($request);

        $context['headers'] = $request->getHeaders();
        $context['request_body'] = $this->getRequestBody($requestBody);
        $context['http_response_code'] = $httpResponse->getStatusCode() ?? 0;

        return ApiResponse::withJson($httpResponse->getBody()->getContents(), $context);
    }


    /**
     * @param string $endpoint
     * @param RequestBodyInterface|null $requestBody
     * @param array $context
     * @return ApiResponse
     * @throws ClientExceptionInterface|ApiException|ApiUnavailableException
     */
    public function createPatchRequest(
        string $endpoint,
        ?RequestBodyInterface $requestBody = null,
        array $context = []
    ): ApiResponse {
        $request = $this->createRequest($endpoint, self::METHOD_PATCH)
            ->withBody($this->createBody($this->getRequestBody($requestBody)))
            ->withHeader('Content-Length', strlen($this->getRequestBody($requestBody)));
        $httpResponse = $this->httpClient->sendRequest($request);

        $context['headers'] = $request->getHeaders();
        $context['request_body'] = $this->getRequestBody($requestBody);
        $context['http_response_code'] = $httpResponse->getStatusCode() ?? 0;

        return ApiResponse::withJson($httpResponse->getBody()->getContents(), $context);
    }

    /**
     * @param string $endpoint
     * @param array $parameters
     * @param array $context
     * @return ApiResponse
     * @throws ClientExceptionInterface|ApiException|ApiUnavailableException
     */
    public function createGetRequest(string $endpoint, array $parameters = [], array $context = []): ApiResponse
    {
        $request = $this->createRequest($endpoint, self::METHOD_GET, $parameters);
        $httpResponse = $this->httpClient->sendRequest($request);

        $context['headers'] = $request->getHeaders();
        $context['request_params'] = $parameters;
        $context['http_response_code'] = $httpResponse->getStatusCode() ?? 0;

        return ApiResponse::withJson($httpResponse->getBody()->getContents(), $context);
    }

    /**
     * @param string $endpoint
     * @param array $parameters
     * @param array $context
     * @return ApiResponse
     * @throws ClientExceptionInterface|ApiException|ApiUnavailableException
     */
    public function createDeleteRequest(string $endpoint, array $parameters = [], array $context = []): ApiResponse
    {
        $request = $this->createRequest($endpoint, self::METHOD_DELETE, $parameters);
        $httpResponse = $this->httpClient->sendRequest($request);

        $context['headers'] = $request->getHeaders();
        $context['request_params'] = $parameters;
        $context['http_response_code'] = $httpResponse->getStatusCode() ?? 0;

        return ApiResponse::withJson($httpResponse->getBody()->getContents(), $context);
    }

    /**
     * Get the request factory
     *
     * @return RequestFactoryInterface
     */
    public function getRequestFactory(): RequestFactoryInterface
    {
        if (!$this->requestFactory instanceof RequestFactoryInterface) {
            $this->requestFactory = Psr17FactoryDiscovery::findRequestFactory();
        }

        return $this->requestFactory;
    }

    /**
     * @param string $endpoint
     * @param array $parameters
     * @return string
     */
    public function getRequestUrl(string $endpoint, $parameters = []): string
    {
        if (!isset($parameters['locale'])) {
            $parameters['locale'] = $this->locale;
        }
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
        if (!$this->streamFactory instanceof StreamFactoryInterface) {
            $this->streamFactory = Psr17FactoryDiscovery::findStreamFactory();
        }

        return $this->streamFactory->createStream($body);
    }

    /**
     * @return ClientInterface
     */
    public function getHttpClient(): ClientInterface
    {
        return $this->httpClient;
    }

    /**
     * @param bool $strictMode
     * @return Client
     */
    public function useStrictMode(bool $strictMode): Client
    {
        $this->strictMode = $strictMode;

        return $this;
    }

    /**
     * @param string $endpoint
     * @param string $method
     * @param array $parameters
     * @return RequestInterface
     */
    private function createRequest(string $endpoint, string $method, array $parameters = []): RequestInterface
    {
        $url = $this->getRequestUrl($endpoint, $parameters);
        $requestFactory = $this->getRequestFactory();

        return $requestFactory->createRequest($method, $url)
            ->withHeader('api_key', $this->apiKey->get())
            ->withHeader('accept-encoding', 'application/json')
            ->withHeader('Content-Type', 'application/json');
    }

    /**
     * @param RequestBodyInterface $requestBody
     * @return string
     */
    private function getRequestBody(RequestBodyInterface $requestBody): string
    {
        $requestBody->useStrictMode($this->strictMode);

        return json_encode($requestBody->getData(), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    }
}
